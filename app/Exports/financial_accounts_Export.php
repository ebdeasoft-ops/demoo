<?php

namespace App\Exports;

use App\Models\financial_accounts;
use App\Models\acounts_type;
use App\Models\credittransactions;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class financial_accounts_Export implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $rows = [];
    protected $styles = [];
    protected $currentRow = 2;
    protected $start_at;
    protected $end_at;
    protected $allAccounts;
    protected $directBalances;

    public function __construct($start_at, $end_at)
    {
        $this->start_at = $start_at;
        $this->end_at = $end_at;
        
        // جلب البيانات الأساسية
        $this->allAccounts = financial_accounts::all();
        $this->directBalances = credittransactions::where('save', 1)
            ->select('customer_id', 
                DB::raw("SUM(CASE WHEN DATE(created_at) < '{$this->start_at}' THEN debtor ELSE 0 END) as open_debtor"),
                DB::raw("SUM(CASE WHEN DATE(created_at) < '{$this->start_at}' THEN creditor ELSE 0 END) as open_creditor"),
                DB::raw("SUM(CASE WHEN DATE(created_at) >= '{$this->start_at}' AND DATE(created_at) <= '{$this->end_at}' THEN debtor ELSE 0 END) as curr_debtor"),
                DB::raw("SUM(CASE WHEN DATE(created_at) >= '{$this->start_at}' AND DATE(created_at) <= '{$this->end_at}' THEN creditor ELSE 0 END) as curr_creditor")
            )
            ->groupBy('customer_id')
            ->get()
            ->keyBy('customer_id');
    }

    /**
     * الدالة الجوهرية: تجمع أرصدة الأبناء فقط وتهمل رصيد الأب المباشر إذا وجد له أبناء
     */
    private function getOnlyChildrenSum($accountId)
    {
        $totals = ['o_d' => 0, 'o_c' => 0, 'c_d' => 0, 'c_c' => 0];
        
        // ابحث هل هذا الحساب له أبناء؟
        $children = $this->allAccounts->where('parent_account_number', $accountId);

        if ($children->isEmpty()) {
            // إذا كان حساب فرعي (ليس له أبناء)، نأخذ رصيده المباشر
            $direct = $this->directBalances[$accountId] ?? null;
            if ($direct) {
                $totals['o_d'] = (float)$direct->open_debtor;
                $totals['o_c'] = (float)$direct->open_creditor;
                $totals['c_d'] = (float)$direct->curr_debtor;
                $totals['c_c'] = (float)$direct->curr_creditor;
            }
        } else {
            // إذا كان حساب أب، نهمل رصيده المباشر ونجمع أرصدة أبنائه (تكرارياً)
            foreach ($children as $child) {
                $childSum = $this->getOnlyChildrenSum($child->id);
                $totals['o_d'] += $childSum['o_d'];
                $totals['o_c'] += $childSum['o_c'];
                $totals['c_d'] += $childSum['c_d'];
                $totals['c_c'] += $childSum['c_c'];
            }
        }

        return $totals;
    }

    public function collection()
    {
        $types = acounts_type::all();
        foreach ($types as $type) {
            $topAccounts = $this->allAccounts->where('account_type', $type->id)
                ->whereIn('parent_account_number', [null, 0, '']);

            $initialCount = count($this->rows);
            $placeholderIdx = count($this->rows);

            foreach ($topAccounts as $acc) {
                $this->processRow($acc, 0);
            }

            if (count($this->rows) > $initialCount) {
                $typeName = app()->getLocale() == 'ar' ? $type->name_ar : $type->name_en;
                array_splice($this->rows, $placeholderIdx, 0, [[
                    'num' => $type->id, 'name' => $typeName, 'type' => $typeName, 'st' => 'تصنيف',
                    'o_d' => '', 'o_c' => '', 'c_d' => '', 'c_c' => '', 'f_d' => '', 'f_c' => ''
                ]]);
                $this->styles[$this->currentRow - (count($this->rows) - $placeholderIdx)] = ['fill' => 'FFA9A9A9', 'bold' => true];
                $this->currentRow++;
            }
        }
        return new Collection($this->rows);
    }

    private function processRow($account, $level)
    {
        // جلب مجموع الأبناء فقط (مع إهمال رصيد الأب نفسه)
        $vals = $this->getOnlyChildrenSum($account->id);
        
        $activity = array_sum($vals);

        if ($activity > 0) {
            $net = ($vals['o_d'] + $vals['c_d']) - ($vals['o_c'] + $vals['c_c']);
            
            $indent = str_repeat('    ', $level);
$this->rows[] = [
    'account_number'   => $account->account_number,
    'name'             => $indent . $account->name,
    'account_type'     => $account->acounts_type->name_ar ?? '',
    'status'           => $account->is_parent == 1 ? 'رئيسي' : 'فرعي',
    'debtor_opening'   => $vals['o_d']> 0 ? $vals['o_d']  : '0', // سيظهر 0 إذا كانت القيمة صفر
    'creditor_opening' => $vals['o_c']> 0 ? $vals['o_c']  : '0', // سيظهر 0 إذا كانت القيمة صفر
    'debtor_current'   => $vals['c_d'] > 0 ? $vals['c_d']  : '0', // سيظهر 0 إذا كانت القيمة صفر
    'creditor_current' => $vals['c_c'] > 0 ? $vals['c_c'] : '0', // سيظهر 0 إذا كانت القيمة صفر
    'final_debtor'     => $net > 0 ? $net : '0', 
    'final_creditor'   => $net < 0 ? abs($net) : '0',
];

            if ($level == 0) $this->styles[$this->currentRow] = ['fill' => 'FFD3D3D3', 'bold' => true];
            $this->currentRow++;

            $children = $this->allAccounts->where('parent_account_number', $account->id)->sortBy('account_number');
            foreach ($children as $child) {
                $this->processRow($child, $level + 1);
            }
        }
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        foreach ($this->styles as $row => $format) {
            $sheet->getStyle("A$row:J$row")->getFont()->setBold($format['bold']);
            $sheet->getStyle("A$row:J$row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($format['fill']);
        }
    }

    public function headings(): array
    {
        return ["رقم الحساب", "اسم الحساب", "التصنيف", "النوع", "مدين أول", "دائن أول", "حركة مدين", "حركة دائن", "رصيد مدين", "رصيد دائن"];
    }
}