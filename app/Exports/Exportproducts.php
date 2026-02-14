<?php

namespace App\Exports;

use App\Models\products;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Exportproducts implements FromCollection,WithHeadings
{
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
    $products_data= products::where('branchs_id',Auth()->user()->branchs_id)->get(['id','product_name','Product_Code','Product_Location','numberofpice','purchasingـprice']);
    $total=0;
    foreach($products_data as $item){
       $total=$total+($item->numberofpice*$item->purchasingـprice) ;
    }
    
    $products_data[]=["-", "-", "-","الاجمالي المخزون بدون ضريبة",$total,"TOTAL WITHOUD TAX"];
        return $products_data;
        
    }
    public function headings() :array
    {
        return ["id", "name", "barcode","Product_Location", "All QUENTITY","purchasingـprice"];
    }
}
