<!DOCTYPE html>
<html dir="rtl">

<head>
  <title> Invoice </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    * {
      font-family: DejaVu Sans !important;
    }

    body {
      font-size: 12px;
      font-family: 'DejaVu Sans', 'Roboto', 'Montserrat', 'Open Sans', sans-serif;
      padding: 2px;
      margin: 10px;

      color: black;
    }

.tx-center{
    text-align: center;
}
    body {
      color: black;
      text-align: right;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }


    .footernew {
 
    }
    th,
    td {
      /* text-align: left; */
      padding: 1px;
                    text-align: center;

    }
    .border{
                border: 1px solid black;

    }

    tr:nth-child(even) {
      background-color: #D6EEEE;
    }

    @page {
      size: a4;
      margin: 4px;
      padding: 0;
    }

    .double {
      border: 3px solid grey;
      border-radius: 5px;
      width: 90%;
      font-size: 10px !important;

    }


    .row {
      display: block;
      padding-left: 24;
      padding-right: 24;
      page-break-before: avoid;
      page-break-after: avoid;
    }

    .column {
      display: block;
      page-break-before: avoid;
      page-break-after: avoid;
    }
        hr {
      border: none;
      height: 2px;           
      background: #333;      
      margin: 24px 0;      
    }
    
    
       .box {
      border: 1px solid #333;   
      padding: 1px;           
      width: 120px;         
    }
  </style>
</head>

<body>
  <div  style="display: flex;width:100%" dir=rtl>




    
      <?php
      $logo = camplogo;
      ?>



   
    <table>
     <?php

                                    $pay = '';
                                   if ($data['invoiceData']->Pay == "Credit") {
                                        $pay = 'اجل';
                                    }else {
                                        $pay = 'نقدي';
                                    }
                                    ?>


      <tr class="heading">
      <td  style="width:35%">
          <center><span class="thick" style="font-size:12px">{{Nameen}}</span> </center>
          <center><span class="tx-14 thick"> {{describtionen}} </span> </center>
          <center><span class="tx-14 thick">{{STen}} </span> </center>
          <center><span class="tx-14 thick"> {{Taxen}} </span> </center>

        </td>
      <td style="width:35%"><center>          
        <img src="{{ public_path('assets/img/brand').'/'.$logo }}"
      style="width: 150px; height: 100px;">
</center>
<h3>                          @if(strlen($data['invoiceData']->customer->tax_no)==15)
                                    <center >  <p class="double thick">  فاتورة ضريبية</p></center>

            @else
            
            
            <center >  <p class="double thick">         فاتورة ضريبية مبسطة </p></center>


             @endif  </h3>
            <p style="color:black;font-size:15px" >   {{$pay}}</p>
            
            </td>  

        <td style="width:30%">
        <center><span style="font-size:12px">{{Namear}}</span> </center>
        <center><span class="tx-14 thick"> {{describtionar}}</span> </center>
        <center><span class="tx-14 thick">{{STar}}</span> </center>
        <center><span class="tx-14 thick">{{Taxar}}</span> </center>

        </td>

     
      </tr>
          </table>

                            <table style="" class="info-table">

      <tr class="heading">
    
      <td  style="width:35%">
                            <span class="box" >  INVOICE NO</span> 
                  <span class="box ">{{ $data['invoiceData']->id}}</span> 
                                   <span class="box ">رقم الفاتورة</span> 
 </td>
<td  style="width:35%">.</td>

<td  style="width:35%">
                      <span class="box">   DATE</span> 
                  <span class="box">{{ $data['invoiceData']->created_at}}</span> 
                <span class="box">تاريخ  </span>

</td>
</tr>
    </table>
    
               
  
  </div><!-- invoice-header -->



  
            </div>
 <br>
<table style="width:100%; border: 1px solid black;">

    <tr class="heading">
    
<br>
      <td>

            </div>
          <div  dir=rtl>
   <table dir="rtl" style="border:2px solid rgba(0,0,0,.3);width:100%; border-radius: 5px;" class="table double" >
                            <thead>
                            <tr class="row12"  >
                                                            <th class="tx-16">   TAX NUMBER   </th>

                            <th class="tx-16" >{{$data['invoiceData']->customer->id}}</th>
                                           <th class="tx-16"> رقم العميل      </th>

                                                        <th  class="tx-16">   CLIENT NO   </th>

                            <th class="tx-16" >{{$data['invoiceData']->customer->name}}</th>
                                                        <th  class="tx-16"> اسم العميل     </th>

             
                            </tr>
                                        <tr class="row12"  >
                                    <th class="tx-16">   PHONE NUMBER   </th>

                                    <th class="tx-16">{{$data['invoiceData']->customer->phone}}</th>
                                                                        <th class="tx-16"> رقم الجوال     </th>

                                                                        <th class="tx-16"> ADDRESS </th>

                                    <th class="tx-16">{{$data['invoiceData']->customer->id==1?'-':$data['invoiceData']->customer->address}}- {{$data['invoiceData']->customer->sub_city}}-{{$data['invoiceData']->customer->street_name}}-{{$data['invoiceData']->customer->postcode}}-
                                    {{$data['invoiceData']->customer->building_number}}</th>
                                                                        <th class="tx-16">العنوان  </th>

                            </tr>
                                
                            <tr   >
                                                                   <th class="tx-16">   TAX NUMBER   </th>

                                    <th class="tx-16">{{$data['invoiceData']->customer->tax_no==0?'-':$data['invoiceData']->customer->tax_no}}  </th>
                                                                        <th class="tx-16"> الرقم الضريبي     </th>

                                                                        <th class="tx-16">   NOTES   </th>

                                    <th class="tx-16">{{$data['invoiceData']->notes}}</th>
                                         <th class="tx-16"> ملاحظات      </th>

                                    </tr>
                              
                               
                            </thead>
                           
                        </table>

           
      </td>
    </tr>


    </table>
 



 
  <br>
  <br>
  <div dir="ltr">
                      <table style="border:2px solid rgba(0,0,0,.3)" class="info-table">
                            
                            <col style="width:20%">
                            <col style="width:10%">
                            <col style="width:10%">
                            <col style="width:10%">
                            <col style="width:25%">
                            <col style="width:20%">
                            <col style="width:5%">
                            
                            
            <tbody>
                
              <tr>
                 <td class="wd-center tx-18">NO<br>رقم</td>
 @if($data['invoiceData']->display_number)
                <td style="widtd=4%" class="tx-16">Item NO <br> رقم منتج </td>
               @endif
               
                               <td class="tx-16">ITEM NAME<br>اسم الصنف </td>
                <td class="tx-center tx-18 "   > QUANTITY <br>الكمية </td>

                               <td class="tx-center tx-18 "   > UNIT <br>الوحدة </td>
                <td class="tx-16">PRODUCT PRICE<br>سعر القطعة </td>

                <td class="tx-16"> Total<br>الاجمالي </td>
              
            
              </tr>



              <?php $i = 0;
                                   $discountreturn=0;
                $avt = App\Models\Avt::find(1);

                                ?>
                     @foreach (App\Models\sales::where('invoice_id', $data['invoiceData']->id)->get() as $product)
                     @if($product->quantity!=0)
                        <?php
                            $i++ ;
                        $total_row_befor_tax=round(  ($product->Unit_Price*$product->quantity)-$product->Discount_Value ,2);
                        $added_value_row=round($total_row_befor_tax*$avt->AVT  ,2);
                        ?>
                     <tr>
                                                 <td class="wd-10p">{{$i}}</td>
  @if($data['invoiceData']->display_number)
                        <td class="wd-center" dir="rtl">{{$product->productData->Product_Code}}</td>
                         @endif
                                                      <td class="tx-center text">{{ $product->productData->product_name}}</td>

                        <td class="tx-center ">{{$product->quantity}}</td>
                        <td class="tx-center ">{{$product->unit??'حبة'}}</td>

                                     <td class="tx-center">{{ number_format($product->Unit_Price, 2, '.', '')}}</td>

                        <td class="tx-center">{{ number_format($product->Unit_Price*$product->quantity, 2, '.', '')}}</td>
                      
             

                    
                     </tr>
                     @endif
                     @endforeach
           



                  </tbody>
               </table>
  </div>
  <br>

  <div class='row' dir=ltr >
                  <?php
                    function ConvertToHEX($value)
                   {
                       return pack("H*", sprintf("%02X", $value));
                   }
                  $invoice=App\Models\invoices::find( $data['invoiceData']->id);
                  $price=$invoice->cashamount+$invoice->Bank_transfer+$invoice->bankamount+$invoice->creaditamount;

                  $price_befor_tax=$price*100/(100+($avt->AVT*100));
                  $invoicetotal_addedvalue = ($price_befor_tax )* $avt->AVT;
                  $invoicetotal_price = $price_befor_tax;
                  $invoicetotal_discount = $invoice->discount+$discountreturn;



                  
                   $sellerName = sallerQrCode;
                   $varNumber = TaxQrCode;
                   $time =$invoice->created_at;
$issue_time=substr($time, 11);
                   $issue_date=substr($time, 0, 10);
                   $time = (string)$issue_date . 'T' . (string)$issue_time;

                   $total = number_format((round($invoicetotal_addedvalue + $invoicetotal_price, 2)),2,'.','');
                   $tax = number_format(round($invoicetotal_addedvalue, 2),2,'.','');
                   $HexSeller = ConvertToHEX(1) . ConvertToHEX(strlen($sellerName));
                   $seller  =  $HexSeller . $sellerName;
                   $HexVAT  = ConvertToHEX(2) . ConvertToHEX(strlen($varNumber));
                   $vat  = $HexVAT . $varNumber;
                   $HexTime = ConvertToHEX(3) . ConvertToHEX(strlen($time));
                   $time  = $HexTime . $time;
                   $HexTotal = ConvertToHEX(4) . ConvertToHEX(strlen($total));
                   $total  = $HexTotal . $total;
                   $HexVATN = ConvertToHEX(5) . ConvertToHEX(strlen($tax));
                   $VATN  = $HexVATN . $tax;
      $empty='';
                 $Hexempty = ConvertToHEX(6) . ConvertToHEX(strlen($empty));
                 $empty6 = $Hexempty . $empty;
                 $Hexempty = ConvertToHEX(7) . ConvertToHEX(strlen($empty));
                 $empty7 = $Hexempty . $empty;
                 $Hexempty = ConvertToHEX(8) . ConvertToHEX(strlen($empty));
                 $empty8 = $Hexempty . $empty;
                 $Hexempty = ConvertToHEX(9) . ConvertToHEX(strlen($empty));
                 $empty9 = $Hexempty . $empty;
                 $tobase   = $seller . $vat . $time . $total . $VATN. $empty6. $empty7. $empty8. $empty9; 
                                 
                   $dataforQRcode =  base64_encode($tobase);
                  ?>
        
        <div class="row"  dir=rtl >
                                                   

                           <table style="width:110%" class="table text-md-nowrap mb-0 table-striped invoice-table text-center">
<tr>
    
    

    <td>
        
         
  
               <table style="width:100%" class="tx-center tx-18">


                  <body>
                     <tr>
                        <td class="tx-16">  SUB TOTAL </td>
                        

                        <td class="tx-16">الاجمالي  </td>
                                                <td class="tx-16">{{number_format((float)(round($invoicetotal_price,2)+round($invoicetotal_discount,2)), 2, '.', '')}}</td>

                     </tr>
                     <tr>

                        <td class="tx-16">  DISCOUNT </td>
                                                <td class="tx-16">الخصم  </td>

                                                                         <td class="tx-16">{{number_format(round($invoicetotal_discount,2), 2, '.', '')}}</td>

                     </tr>
                     <tr>

                        <td class="tx-16"> SUB TOTAL AFTER DISCOUNT </td>
                                                <td class="tx-16">الاجمالي بعد الخصم </td>

                                                                         <td class="tx-16">{{number_format(round($invoicetotal_price,2), 2, '.', '')}}</td>

                     </tr>
                     <tr>
                        <td class="tx-16">VALUE ADDED TAX ({{$avt->AVT*100}}%)</td>
                                                <td class="tx-16">ضريبة القيمة المضافة({{$avt->AVT*100}}%)</td>

                                                <td class="tx-16">{{number_format(round($invoicetotal_addedvalue,2), 2, '.', '')}}</td>

                     </tr>



                     <tr>
                        <td class="tx-16"> NET TOTAL</td>
             
                                           <td class="tx-16">الاجمالي الكلي </td>

                        <td class="tx-16">{{number_format(round($invoicetotal_addedvalue+$invoicetotal_price,2), 2, '.', '')}}</td>
  
                     </tr>
                  </body>


               </table>
    </td>


    
</tr>
</table>
 
           
        <div>

         <div class="row"  dir=rtl >
<p>.</p>
<table>
    
      <img src="data:image/png;base64,{!! base64_encode(QrCode::size(110)->generate( $dataforQRcode) )!!}">

</table>

           </div>    
      

        </div>
        </div>
             
 </div>
  <br>



 <center>

   </center>

  </div>
  <br>
<span style="color:black"> 
<center>

</center>
</span>
  <br>

  <span class="tx-16 ">{{__('home.notesClient')}} : {{$data['invoiceData']->note}}</span>
  <br>
  <br>
  <br>
  
      <table>
      <tr class="heading">


                 <td>Received By: ______________________المستلم :</td>
                         <td>Salesman: ______________________: البائع</td>


        </tr>    
       

</table>
           <hr>

  </div>      
  <div>

  </div>
  </div>
  <div style="  position: fixed;     
       text-align: center;    
       bottom: 0px; 
       width: 100%;">


   



  
  </div>
</body>

</html>