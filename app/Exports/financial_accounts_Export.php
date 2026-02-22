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
    protected $currentRow = 2; // يبدأ من 2 لأن الصف الأول هو العناوين
    protected $start_at;
    protected $end_at;
    protected $allAccounts;
    protected $directBalances;
    
    // متغيرات لتجميع الإجمالي العام في نهاية الملف
    protected $grand_o_d = 0;
    protected $grand_o_c = 0;
    protected $grand_c_d = 0;
    protected $grand_c_c = 0;

    private $colorMainParent = 'FFCCE5FF'; // اللون الأزرق الفاتح للتصنيف

    public function __construct($start_at, $end_at)
    {
        $this->start_at = $start_at;
        $this->end_at = $end_at;
        
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

    private function getOnlyChildrenSum($accountId)
    {
        $totals = ['o_d' => 0, 'o_c' => 0, 'c_d' => 0, 'c_c' => 0];
        $children = $this->allAccounts->where('parent_account_number', $accountId);

        if ($children->isEmpty()) {
            $direct = $this->directBalances[$accountId] ?? null;
            if ($direct) {
                $totals['o_d'] = (float)$direct->open_debtor;
                $totals['o_c'] = (float)$direct->open_creditor;
                $totals['c_d'] = (float)$direct->curr_debtor;
                $totals['c_c'] = (float)$direct->curr_creditor;
            }
        } else {
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
    $this->rows = [];
    $this->styles = [];
    $this->currentRow = 2; 

    $types = acounts_type::all();
    
    foreach ($types as $type) {
        // 1. جلب الحسابات الرئيسية التابعة لهذا التصنيف (1, 2, 3...)
        $topAccounts = $this->allAccounts->where('account_type', $type->id)
            ->whereIn('parent_account_number', [null, 0, '']);

        $initialCount = count($this->rows);
        $placeholderIdx = count($this->rows);

        // متغيرات لتجميع إجمالي التصنيف الحالي
        $typeTotals = ['o_d' => 0, 'o_c' => 0, 'c_d' => 0, 'c_c' => 0];

        foreach ($topAccounts as $acc) {
            // معالجة الحسابات كالمعتاد
            $this->processRow($acc, 0); 
            
            // 2. جمع قيم الحسابات الرئيسية لإضافتها في صف التصنيف
            $accVals = $this->getOnlyChildrenSum($acc->id);
            $typeTotals['o_d'] += $accVals['o_d'];
            $typeTotals['o_c'] += $accVals['o_c'];
            $typeTotals['c_d'] += $accVals['c_d'];
            $typeTotals['c_c'] += $accVals['c_c'];
        }

        // إذا كان هناك حسابات تحت هذا التصنيف، نضع صف "التصنيف الرئيسي" مع مجموع القيم
        if (count($this->rows) > $initialCount) {
            $typeName = app()->getLocale() == 'ar' ? $type->name_ar : $type->name_en;
            $net = ($typeTotals['o_d'] + $typeTotals['c_d']) - ($typeTotals['o_c'] + $typeTotals['c_c']);

            // إضافة سطر التصنيف مع المجاميع
            array_splice($this->rows, $placeholderIdx, 0, [[
                'account_number' => $type->id, 
                'name'           => 'إجمالي ' . $typeName, 
                'account_type'   => 'تصنيف الرئيسي', 
                'status'         => '---',
                'o_d' => $typeTotals['o_d'], 
                'o_c' => $typeTotals['o_c'], 
                'c_d' => $typeTotals['c_d'], 
                'c_c' => $typeTotals['c_c'], 
                'f_d' => $net > 0 ? $net : 0, 
                'f_c' => $net < 0 ? abs($net) : 0
            ]]);

            // تلوين سطر التصنيف
            $targetRow = $this->currentRow - (count($this->rows) - $placeholderIdx) + 1;
            $this->styles[$targetRow] = ['fill' => $this->colorMainParent, 'bold' => true];
            
            $this->currentRow++;

            // تجميع للإجمالي العام للميزانية في الأسفل
            $this->grand_o_d += $typeTotals['o_d'];
            $this->grand_o_c += $typeTotals['o_c'];
            $this->grand_c_d += $typeTotals['c_d'];
            $this->grand_c_c += $typeTotals['c_c'];
        }
    }

    // إضافة سطر الإجمالي النهائي في آخر الملف
    $final_net = ($this->grand_o_d + $this->grand_c_d) - ($this->grand_o_c + $this->grand_c_c);
    $this->rows[] = [
        'account_number'   => '', 'name' => 'الإجمالي العام', 'account_type' => '', 'status' => '',
        'o_d' => $this->grand_o_d==0?'0':$this->grand_o_d, 'o_c' => $this->grand_o_c==0?'0':$this->grand_o_c,
        'c_d' => $this->grand_c_d==0?'0':$this->grand_c_d, 'c_c' => $this->grand_c_c==0?'0':$this->grand_c_c,
        'f_d' => $final_net > 0 ? $final_net : 0, 'f_c' => $final_net < 0 ? abs($final_net) : 0,
    ];
    $this->styles[$this->currentRow] = ['fill' => 'FFA9A9A9', 'bold' => true];

    return new Collection($this->rows);
}
private function processRow($account, $level) 
{
    $vals = $this->getOnlyChildrenSum($account->id);
    $activity = array_sum($vals);

    if ($activity != 0 || $vals['o_d'] != 0 || $vals['o_c'] != 0) {
        
        // التحقق من الحسابات الـ 5 الأساسية (رؤوس المجموعات)
        $isTargetMainAccount = in_array($account->account_number, [1, 2, 3, 4, 5]);
        $isFinalChild = $this->allAccounts->where('parent_account_number', $account->id)->isEmpty();

        if ($isTargetMainAccount || $isFinalChild) {
            $net = ($vals['o_d'] + $vals['c_d']) - ($vals['o_c'] + $vals['c_c']);
            $indent = str_repeat('    ', $level);

            $this->rows[] = [
                'account_number'   => $account->account_number,
                'name'             => $indent . $account->name,
                'account_type'     => $account->acounts_type->name_ar ?? '',
                'status'           => $account->is_parent == 1 ? 'رئيسي' : 'فرعي',
                'debtor_opening'   => $vals['o_d']==0?'0':$vals['o_d'],
                'creditor_opening' => $vals['o_c']==0?'0':$vals['o_c'],
                'debtor_current'   => $vals['c_d']==0?'0':$vals['c_d'],
                'creditor_current' => $vals['c_c']==0?'0':$vals['c_c'],
                'final_debtor'     => $net > '0' ? $net : '0',
                'final_creditor'   => $net < '0' ? abs($net) : '0',
            ];

            // تجميع الإجماليات فقط من الحسابات 1، 2، 3، 4، 5 لضمان عدم التكرار
            if ($isTargetMainAccount) {
                $this->grand_o_d += $vals['o_d']==0?'0':$vals['o_d'];
                $this->grand_o_c += $vals['o_c']==0?'0':$vals['o_c'];
                $this->grand_c_d += $vals['c_d']==0?'0':$vals['c_d'];
                $this->grand_c_c += $vals['c_c']==0?'0':$vals['c_c'];
            }

            $this->currentRow++;
        }

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
            $range = "A{$row}:J{$row}";
            if (isset($format['bold'])) $sheet->getStyle($range)->getFont()->setBold(true);
            if (isset($format['fill'])) {
                $sheet->getStyle($range)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB($format['fill']);
            }
        }
    }

    public function headings(): array
    {
        return ["رقم الحساب", "اسم الحساب", "التصنيف", "النوع", "مدين أول", "دائن أول", "حركة مدين", "حركة دائن", "رصيد مدين", "رصيد دائن"];
    }
}