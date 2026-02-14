@extends('layouts.master')
@section('css')
<style>
    @media print {
        #print_Button {
            display: none;
        }
          .double {
      border: 3px solid grey;
      border-radius: 5px;
      width: 200px;
      font-size: 15px !important;

    }

    }
  .double {
      border: 3px solid grey;
      border-radius: 5px;
      width: 200px;
      font-size: 15px !important;

    }

    body {
        font: 13pt Georgia, "Times New Roman", Times, serif;
        line-height: 1.5;
        border-style: solid;

    }
</style>
@endsection
@section('title')
{{ __('home.print') }}
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row row-sm">
    <div class="col-md-12 col-xl-12">
        <div class=" main-content-body-invoice" id="print">
            <div class="card card-invoice">
                   <div class="d-flex justify-content-center">
                            <button class="btn btn-danger print-style float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                {{ __('home.print') }}
                                <i class="mdi mdi-printer ml-1"></i>
                        </div>
                        <br>

                <div class="card-body">
                  <div class="invoice-header" style="display: flex;justify-content:space-between;width:100%">

                      
                        
                        
                             <div class="billed-from" style="width:33%;text-align: center;">
                            <br>

                           <span style="font-size:16px">{{Namear}}</span>
                            <br>
                            <p> {{describtionar}}</p>
                            <p>{{STar}}</p>
                            <p>{{Taxar}}</p>

                        </div><!-- billed-from -->
                        <div class="row">
                        <?php
$logo=camplogo;
    ?>
    <a href="https://ebdeasoft.com/"><img src="{{ asset('assets\img\brand').'/'.$logo }}" class="logo-1" alt="logo" style="width: 110px; height: 100px;"></a>

                        </div>

  <div class="billed-from" style="width:33%;text-align: center;" >
                            <br>
                             <span style="font-size:19px">{{Nameen}}</span>
                            <br>
                            <p dir=ltr> {{describtionen}} </p>
                            <span dir=ltr>{{STen}} </span>
                            <p dir=ltr> {{Taxen}} </p>

                        </div>
                   
                    </div><!-- invoice-header -->

                    <div class="card-body">
                        <br>
                   <center>    <span class='double'>ارباح المبيعات  Sales profits</span></center> 
                        
                        <br>
                        <div class="">

                                <?php
                                $currentdata = \Carbon\Carbon::now()->addHours(3)->format("Y-m-d H:i:s");

                                ?>

                          
                                          <div class="table-padding table-responsive ">
                                <table style="border: 2px solid rgba(0,0,0,0)" class="table table-striped table-bordered text-center my-2">
                                    <col style="width:15%">
                                    <col style="width:15%">
                                    <col style="width:15%">
                                    <col style="width:20%">
                                    <col style="width:15%">
                                    <col style="width:20%">
                                    <thead>
                                        <tr>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label style="font-size: 14px;color:#419BB2 ;font-weight:bold;" for="exampleFormControlSelect1"> {{ __('report.fromdate') }}:</label>

                                            </th>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label style="font-size: 14px;color:#419BB2 ;font-weight:bold;" for="exampleFormControlSelect1"> {{ $start }}</label>
                                            </th>

                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label style="font-size: 14px;color:#419BB2 ;font-weight:bold;" for="exampleFormControlSelect1"> {{ __('report.todate') }}</label>

                                            </th>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label style="font-size: 14px;color:#419BB2 ;font-weight:bold;" for="exampleFormControlSelect1">{{ $end }}</label>
                                            </th>



                                           
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label style="font-size: 14px;color:#419BB2 ;font-weight:bold;" for="exampleFormControlSelect1"> {{ __('home.exportTime') }} </label>

                                            </th>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label style="font-size: 14px;color:#419BB2 ;font-weight:bold;" for="exampleFormControlSelect1"> {{ $currentdata }}</label>
                                            </th>
                                        </tr>


                                    </thead>
                                </table>
                            </div>
                            <div style="border-radius: 10px" class="card pb-0 px-3">
                                <br>

                                <?php
                                $count = 0;
                             
                                $totalcost = 0;
                                $totalsales = 0;
                                $totaldiscount = 0;
                                $totalprofit = 0;
                                $i=0;
                                $quantity=0;
                                $quentitywithreturn=0;
                                $discountreturn=0;
                                $totaldiscountelment=0;
                                ?>
                              
                                <br>





                                <table class="table table-responsive table-striped table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">#</th>
                                            <th class="border-bottom-0">{{ __('report.date') }}</th>
                                            <th class="border-bottom-0"> {{ __('home.productNo') }}</th>
                                            <th class="border-bottom-0"> {{ __('home.product') }}</th>
                                            <th class="border-bottom-0"> {{ __('home.quantity') }}</th>
                                            <th class="border-bottom-0"> {{ __('home.purchaseproductwithouttax') }}</th>
                                            <th class="border-bottom-0"> {{ __('home.total') }}</th>
                                            <th class="border-bottom-0">{{ __('home.sellingproduct without tax') }}</th>
                                            <th class="border-bottom-0"> {{ __('home.total') }}</th>
                                            <th class="border-bottom-0">{{ __('home.discount') }}</th>
                                            <th class="border-bottom-0"> {{ __('report.profit') }}</th>
                                        </tr>
                                    </thead>
                                  
                                    @foreach ($data['sales'] as $product)
                                  <?php
                                        $quentitywithreturn=$product->quantity;
                                        $totaldiscountelment=$product->Discount_Value;
                                       foreach( App\Models\return_sales::where('product_id', $product->product_id)->where('invoice_id', $product->invoice_id)->get() as $item){
                                          $totaldiscountelment+= $item->discountvalue;
                                          $quentitywithreturn+=$item->return_quantity;
                                       }
                                       
                                        $i++;
                                       $invoicesdata= App\Models\invoices::find($product->invoice_id);
                                        $discoundineachproduct=0;
                                         $discoundoninvoice=0;
                                         if($invoicesdata){
                                        if($invoicesdata->Number_of_Quantity==0){
                                              foreach (App\Models\return_sales::where('invoice_id', $product->invoice_id)->get() as $item){
                                                
                                                $discoundoninvoice+=$item->discountoninvoice;

                                               }
                                        }else{
                                                 $discoundoninvoice=$invoicesdata->discount-$invoicesdata->discountOnProduct;
                                                    
                                        }
                                       
                                             $quentity_all_invoice=0;
                                               foreach (App\Models\return_sales::where('invoice_id', $product->invoice_id)->get() as $item){
                                                
                                                $quentity_all_invoice+=$item->return_quantity;
                                               }
                                             foreach (App\Models\sales::where('invoice_id', $product->invoice_id)->get() as $item){
                                                
                                                $quentity_all_invoice+=$item->quantity;

                                               }
                                               if($quentity_all_invoice>0){
                                   $discoundineachproduct=($discoundoninvoice/$quentity_all_invoice);
                                   $totaldiscountelment+=($discoundineachproduct*$quentitywithreturn);
  }
                                   $quantity+=$quentitywithreturn;
                                $count = 0;
                                $totalcost += ($product->productData->purchasingـprice *$quentitywithreturn);
                                $totalsales +=($product->Unit_Price *$quentitywithreturn );
                                $totaldiscount +=$totaldiscountelment;
                                $totalprofit +=((($product->Unit_Price *$quentitywithreturn ))-(($product->productData->purchasingـprice *$quentitywithreturn)+($totaldiscountelment)));
                               $temp= ($product->productData->purchasingـprice *$quentitywithreturn);
                           }       ?>
                                    <tbody>
                                        <tr>

                                            <td>{{ $i }}</td>
                                            <td>{{ $product->created_at }}</td>
                                            <td dir='ltr'>{{ $product->productData->Product_Code??'-' }}</td>
                                            <td>{{ $product->productData->product_name??'-' }}</td>
                                            <td>{{ number_format($quentitywithreturn, 2, '.', '') }}</td>
                                            <td>{{ number_format($product->productData->purchasingـprice??0, 2, '.', '') }}</td>
                                            <td>{{ number_format($product->productData->purchasingـprice*$quentitywithreturn, 2, '.', '') }}</td>
                                            <td>{{ number_format($product->Unit_Price , 2, '.', '')}}</td>
                                            <td>{{ number_format($product->Unit_Price *$quentitywithreturn, 2, '.', '') }}</td>
                                            <td>{{ number_format($totaldiscountelment, 2, '.', '') }}</td>
                                            <td>{{ number_format(round(($quentitywithreturn * $product->Unit_Price)-($totaldiscountelment) - ($temp),2), 2, '.', '') }}
                                            </td>

                                                                                      
                                        </tr>
                                        @endforeach
                                       <tr>
                                           <td>-</td>
                                           <td>-</td>
                                           <td>-</td>
                                           <td>-</td>
                                           <td>{{number_format($quantity, 2, '.', '')}}</td>
                                           <td>-</td>
                                           <td>{{number_format($totalcost, 2, '.', '')}}</td>
                                           <td>-</td>
                                           <td>{{number_format($totalsales, 2, '.', '')}}</td>
                                           <td>{{number_format($totaldiscount, 2, '.', '')}}</td>
                                           <td>{{number_format($totalprofit, 2, '.', '')}}</td>

                                       </tr>
                                    </tbody>
                                    
                                </table>


                               

                                <br>
    <center>    <span class='double'>ارباح مرتجع المبيعات    sales Return profits</span></center> 

                                <?php
                                
                                
                                
                                   $totalcostreturn = 0;
                                $totalsalesreturn = 0;
                                $totaldiscountreturn = 0;
                                $totalprofitreturn = 0;
                                $quantityreturn=0;
$i=0;
                                ?>
                              <br>  
                              <br>  
                              <br>  

                                <table class="table table-responsive table-striped table-bordered text-center">
                                    <thead>

                                      
                                        <tr>
                                            <th class="border-bottom-0">#</th>
                                            <th class="border-bottom-0">{{ __('report.date') }}</th>
                                            <th class="border-bottom-0"> {{ __('home.productNo') }}</th>
                                            <th class="border-bottom-0"> {{ __('home.product') }}</th>
                                            <th class="border-bottom-0"> {{ __('home.salesـreturned') }}</th>
                                            <th class="border-bottom-0"> {{ __('home.purchaseproductwithouttax') }}</th>
                                            <th class="border-bottom-0"> {{ __('home.total') }}</th>
                                            <th class="border-bottom-0">{{ __('home.sellingproduct without tax') }}</th>
                                            <th class="border-bottom-0"> {{ __('home.total') }}</th>
                                            <th class="border-bottom-0">{{ __('home.discount') }}</th>
                                            <th class="border-bottom-0"> {{ __('report.profit') }}</th>
                                        </tr>
                                    </thead>
                                  
                                    @foreach ($data['returnsales'] as $product)
                                  <?php
                                  $i++;
                                   $quantityreturn+=$product->return_quantity;
                                $count = 0;
                                $invoice=App\Models\invoices::find($product->invoice_id);
                                $totalcostreturn +=  ($product->productData->purchasingـprice *$product->return_quantity);
                                $totalsalesreturn +=($product->return_Unit_Price *$product->return_quantity );
                                $totaldiscountreturn +=($product->discountoninvoice+$product->discountvalue);
                                $totalprofitreturn +=(($product->return_Unit_Price *$product->return_quantity ))-(($product->productData->purchasingـprice *$product->return_quantity)+($product->discountoninvoice+$product->discountvalue) );
                               
                                  ?>
                                    <tbody>
                                        <tr>

                                            <td>{{ $i }}</td>
                                            <td>{{ $product->created_at }}</td>
                                            <td dir='ltr'>{{ $product->productData->Product_Code }}</td>
                                            <td>{{ $product->productData->product_name }}</td>
                                            <td>{{number_format( $product->return_quantity , 2, '.', '')}}</td>
                                            <td>{{number_format( $product->productData->purchasingـprice, 2, '.', '') }}</td>
                                            <td>{{number_format( $product->productData->purchasingـprice *$product->return_quantity, 2, '.', '') }}</td>
                                            <td>{{number_format( $product->return_Unit_Price, 2, '.', '') }}</td>
                                            <td>{{number_format( $product->return_Unit_Price *$product->return_quantity, 2, '.', '') }}</td>
                                            <td>{{number_format( ($product->discountoninvoice+$product->discountvalue), 2, '.', '') }}</td>
                                            <td>{{number_format( round(($product->return_quantity * $product->return_Unit_Price)- ($product->return_quantity * $product->productData->purchasingـprice)-($product->discountoninvoice+$product->discountvalue),2), 2, '.', '') }}
                                            </td>

                                                                                      
                                        </tr>

                                        @endforeach
                                       <tr>
                                           <td>-</td>
                                           <td>-</td>
                                           <td>-</td>
                                           <td>-</td>
                                           <td>{{number_format($quantityreturn, 2, '.', '')}}</td>
                                           <td>-</td>
                                           <td>{{number_format($totalcostreturn, 2, '.', '')}}</td>
                                           <td>-</td>
                                           <td>{{number_format($totalsalesreturn, 2, '.', '')}}</td>
                                           <td>{{number_format($totaldiscountreturn, 2, '.', '')}}</td>
                                           <td>{{number_format($totalprofitreturn, 2, '.', '')}}</td>

                                       </tr>
                                    </tbody>
                                    
                                </table>
                                <br>
                             <br>
 <table class="table table-responsive table-striped table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">{{ __('report.profit') }}</th>
                                            <th class="border-bottom-0"> {{$totalprofit -$totalprofitreturn}}</th>
                                         
                                        </tr>
                                    </thead>
                                    
                                    
                                    </table>
                            

                            

                            </div>
                       

                        </div>
                    </div>

                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>


<script type="text/javascript">
    function printDiv() {
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>

@endsection