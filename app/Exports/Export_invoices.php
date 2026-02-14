<?php

namespace App\Exports;

use App\Models\invoices;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Avt;

class Export_invoices implements FromCollection,WithHeadings
{
    
    
    public $branch;
    public $pay;
    public $startat;
    public $end_at;

    // Constructor with 4 parameters
    public function __construct($branch, $pay, $startat, $end_at) {
        $this->branch = $branch;
        $this->pay = $pay;
        $this->startat = $startat;
        $this->end_at = $end_at;
    }
    
    
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data=[];
        if ($this->pay == '-' &&  $this->branch == "-") {
            $Invoices = invoices::whereDate('created_at', '>=', $this->startat)->whereDate('created_at', '<=', $this->end_at)->where('save', 1)->get();
        } else {
            if ($this->pay == "-" &&  $this->branch != "-") {
                $Invoices = invoices::where('branchs_id',  $this->branch)->whereDate('created_at', '>=', $this->startat)->whereDate('created_at', '<=', $this->end_at)->where('save', 1)->get();
            } elseif ($this->pay != "-" &&  $this->branch == "-") {
                $Invoices = invoices::where('Pay', $this->pay)->whereDate('created_at', '>=', $this->startat)->whereDate('created_at', '<=', $this->end_at)->where('save', 1)->get();
            } else {
                $Invoices = invoices::where('branchs_id',  $this->branch)->where('Pay', $this->pay)->whereDate('created_at', '>=', $this->startat)->whereDate('created_at', '<=', $this->end_at)->where('save', 1)->get();
            }

        }        foreach($Invoices as $product){
            
               $pays = '';
                                            if ($product->Pay == 'Cash') {
                                                $pays = __('report.cash');
                                            } elseif ($product->Pay == 'Shabka') {
                                                $pays = __('report.shabka');
                                            } elseif ($product->Pay == "Credit") {
                                                $pays = __('report.credit');
                                            } elseif ($product->Pay == "Bank_transfer") {
                                                $pays = __('home.Bank_transfer');
                                            } else {
                                                $pays = __('home.Partition of the amount');
                                            }


$avt = Avt::find(1);
$saleavt = $avt->AVT;
$total_withod_tax= round($product->Price-$product->discount,2)  ;
$addvalue=round($total_withod_tax*$saleavt,2)   ;

            $data[]=[
                   "id"=> $product->id,
                   "created_at"=>$product->created_at,
                   "customer"=> $product->customer->name,
                   "tax_no"=> $product->customer->tax_no,
                   "PAYMENT"=> $pays,
                   "TOTAL"=> $total_withod_tax+$addvalue,

                   ];

        }
        
        

        return collect($data);
    }
    public function headings() :array
    {
        return ["INVOICE_ID", "DATE", "CUSTOMER_NAME","TAX_NUMBER", "PAYMENT","AMOUNT_WITH_TAX"];
    }
}