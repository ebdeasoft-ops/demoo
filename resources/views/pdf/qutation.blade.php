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
<h3>                       
                                    <center >  <p class="double thick">  عرض سعر  QUOTATION </p></center>
 </h3>

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
     <?php
$offer_price_to_customer=App\Models\offer_price_to_customer::find($itemsRequest[0]->order_id);

?>
      <tr class="heading">
    
      <td  style="width:35%">
                            <span class="box" >  QUOTE NO</span> 
                  <span class="box ">{{$offer_price_to_customer->id}}</span> 
                                   <span class="box ">رقم التسعيرة</span> 
 </td>
<td  style="width:35%">.</td>

<td  style="width:35%">
                      <span class="box">   DATE</span> 
                  <span class="box">{{ $offer_price_to_customer->created_at}}</span> 
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

                            <th class="tx-16" >{{$offer_price_to_customer->customer->id}}</th>
                                           <th class="tx-16"> رقم العميل      </th>

                                                        <th  class="tx-16">   CLIENT NO   </th>

                            <th class="tx-16" >{{$offer_price_to_customer->customer->name}}</th>
                                                        <th  class="tx-16"> اسم العميل     </th>

             
                            </tr>
                                        <tr class="row12"  >
                                    <th class="tx-16">   PHONE NUMBER   </th>

                                    <th class="tx-16">{{$offer_price_to_customer->customer->phone}}</th>
                                                                        <th class="tx-16"> رقم الجوال     </th>

                                                                        <th class="tx-16"> ADDRESS </th>

                                    <th class="tx-16">{{$offer_price_to_customer->customer->id==1?'-':$offer_price_to_customer->customer->address}}- {{$offer_price_to_customer->customer->sub_city}}-{{$offer_price_to_customer->customer->street_name}}-{{$offer_price_to_customer->customer->postcode}}-
                                    {{$offer_price_to_customer->customer->building_number}}</th>
                                                                        <th class="tx-16">العنوان  </th>

                            </tr>
                                
                            <tr   >
                                                                   <th class="tx-16">   TAX NUMBER   </th>

                                    <th class="tx-16">{{$offer_price_to_customer->customer->tax_no==0?'-':$offer_price_to_customer->customer->tax_no}}  </th>
                                                                        <th class="tx-16"> الرقم الضريبي     </th>

                                                                        <th class="tx-16">   NOTES   </th>

                                    <th class="tx-16">{{$offer_price_to_customer->notes}}</th>
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
                                     @if($offer_price_to_customer->numbershowstatus)
                <td style="widtd=4%" class="tx-16">Item NO <br> رقم منتج </td>
               @endif
               
                               <td class="tx-16">ITEM NAME<br>اسم الصنف </td>
                <td class="tx-center tx-18 "   > QUANTITY <br>الكمية </td>

                               <td class="tx-center tx-18 "   > UNIT <br>الوحدة </td>
                <td class="tx-16">PRODUCT PRICE<br>سعر القطعة </td>

                <td class="tx-16"> Total<br>الاجمالي </td>
              
            
              </tr>



           <?php $i = 0;
                                                        $totalpricePurchases = 0;
                                                        $totalAddedValue = 0;
                                                        $totaldiscount = 0;
                                                        ?>
                                                        @foreach ($itemsRequest as $product)
                     
                     @if($product->quantity!=0)
                                             <?php $i++;
                                                            $avt = App\Models\Avt::find(1);
                                                            $totalpricePurchases += ($product->PriceWithoudTax * $product->quantity);
                                                            // $totalAddedValue += $product->PriceWithoudTax * $avt->AVT * $product->quantity;
                                                            $totaldiscount += $product->discount;
                                                            
                                                            ?>
                        <?php
                        $total_row_befor_tax=round(  ($product->Unit_Price*$product->quantity)-$product->Discount_Value ,2);
                        $added_value_row=round($total_row_befor_tax*$avt->AVT  ,2);
                        ?>
                     <tr>
                                                 <td class="wd-10p">{{$i}}</td>
                                     @if($offer_price_to_customer->numbershowstatus)
                        <td class="wd-center" dir="rtl">{{$product->productData->Product_Code}}</td>
                         @endif
                                                      <td class="tx-center text">{{ $product->productData->product_name}}</td>

                        <td class="tx-center ">{{$product->quantity}}</td>
                        <td class="tx-center ">{{$product->unit??'حبة'}}</td>

                                     <td class="tx-center">{{ number_format($product->PriceWithoudTax, 2, '.', '')}}</td>

                        <td class="tx-center">{{ number_format($product->PriceWithoudTax*$product->quantity, 2, '.', '')}}</td>
                      
             

                    
                     </tr>
                     @endif
                     @endforeach
           



                  </tbody>
               </table>
  </div>
  <br>

  <div class='row' dir=ltr >
                
        <div class="row"  dir=rtl >
                                                   

                           <table style="width:110%" class="table text-md-nowrap mb-0 table-striped invoice-table text-center">
<tr>
    
    

    <td>
        
         
    <td>
        
.
    </td>
               <table style="width:100%" class="tx-center tx-18">


                  <body>
                     <tr>
                        <td class="tx-16">  SUB TOTAL </td>
                        

                        <td class="tx-16">الاجمالي  </td>
                                                <td class="tx-16">{{number_format($totalpricePurchases, 2, '.', '')}}</td>

                     </tr>
                     <tr>

                        <td class="tx-16">  DISCOUNT </td>
                                                <td class="tx-16">الخصم  </td>

                                                                         <td class="tx-16">{{number_format(round($totaldiscount+$offer_price_to_customer->discount,2), 2, '.', '')}}</td>

                     </tr>
                     <tr>

                        <td class="tx-16"> SUB TOTAL AFTER DISCOUNT </td>
                                                <td class="tx-16">الاجمالي بعد الخصم </td>

                                                                         <td class="tx-16">{{number_format(round($totalpricePurchases,2)- round($totaldiscount+$offer_price_to_customer->discount,2), 2, '.', '')}}</td>

                     </tr>
                     <tr>
                        <td class="tx-16">VALUE ADDED TAX ({{$avt->AVT*100}}%)</td>
                                                <td class="tx-16">ضريبة القيمة المضافة({{$avt->AVT*100}}%)</td>

                                                <td class="tx-16">{{number_format(round((round($totalpricePurchases,2)- round($totaldiscount+$offer_price_to_customer->discount,2))* $avt->AVT,2), 2, '.', '')}}</td>

                     </tr>



                     <tr>
                        <td class="tx-16"> NET TOTAL</td>
             
                                           <td class="tx-16">الاجمالي الكلي </td>

                        <td class="tx-16">{{number_format(round((round($totalpricePurchases,2)- round($totaldiscount+$offer_price_to_customer->discount,2))* $avt->AVT,2)+(round($totalpricePurchases,2)- round($totaldiscount+$offer_price_to_customer->discount,2)), 2, '.', '')}}</td>
  
                     </tr>
                  </body>


               </table>
    </td>


    
</tr>
</table>
 
           
        <div>

         <div class="row"  dir=rtl >
<p>.</p>


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

  
      <table>
 
       

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