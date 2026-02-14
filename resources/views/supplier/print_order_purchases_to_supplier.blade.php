@extends('layouts.master')
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }

    </style>
@endsection
@section('title')
    معاينه طباعة للموارد
@stop
@section('page-header')
    <!-- breadcrumb -->
   
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12 mt-5">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        
                        
                                                                                <button class="btn btn-danger float-left mt-3 mr-2 print-style" id="print_Button" onclick="printDiv()"> <i class="mdi mdi-printer ml-1"></i>طباعة</button>
<br>
                    <div class="invoice-header" style="display: flex;justify-content:space-between;width:100%" dir=rtl>




<div class="billed-from" style="width:33%;text-align: center;">
    <br>

    <span  class="tx-18 thick">{{Namear}}</span>
    <br>
    <p class="tx-16 thick"> {{describtionar}}</p>
    <p class="tx-16 thick">{{STar}}</p>
    <p class="tx-16 thick">{{Taxar}}</p>

</div><!-- billed-from -->
<div class="row">
    <?php
    $logo = camplogo;
    ?>
    <a href="https://ebdeasoft.com/"><img src="{{ asset('assets\img\brand').'/'.$logo }}" class="logo-1" alt="logo" style="width: 110px; height: 100px;"></a>

</div>

<div class="billed-from" style="width:33%;text-align: center;">
    <br>
    <span class="tx-18 thick">{{Nameen}}</span>
    <br>
    <p class="tx-16 thick" > {{describtionen}} </p>
    <span class="tx-16 thick">{{STen}} </span>
    <p class="tx-16 thick"> {{Taxen}} </p>

</div>

</div><!-- invoice-header -->
            <center> <p  >  {{__('home.Purchase_order_of_resources')}}</p></center>


                        <div class="row mg-t-12">
                            <div class="col-md">
                            <div class="col-md">



                                <div class="table-responsive mg-t-30 table-padding">
                                    <table class="table text-center table-invoice border text-md-nowrap mb-0 table-bordered table-striped" id="tableTotalPrice"
                                        name="tableTotalPrice"width="50%">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0"><span>{{__('home.Invoice_no')}}  </span></th>
                                                <th class="border-bottom-0"><span>{{$data['productsdata'][0]->supllier->id}}</span></th>
                                            </tr>
                                        </thead>
        
                                        <body>
                                      

                                            <tr>
                                                <td><span> {{ __('home.date') }}</span></td>
                                                <td><span><?php echo date("Y-m-d h:i") ?></span></td>
                                            </tr>
                                            <tr>
                                                <td><span>{{ __('home.suppliername') }}   </span></td>
                                                <td><span>{{$data['supllierdata']->name}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><span>{{ __('supprocesses.Location') }}</span></td>
                                                <td><span>{{$data['supllierdata']->location}}</span></td>
                                            </tr>

                                            <tr>
                                                <td><span>{{ __('supprocesses.phone') }}  </span></td>
                                                <td><span>{{$data['supllierdata']->phone}}</span></td>
                                            </tr>
                                          
        
                                        </body>
        
                                    </table>

                                </div>    


                            </div>
                            </div>
                           
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-bordered table-striped text-center table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">#</th>
                                        <th class="wd-40p"> {{ __('home.productNo') }}</th>
                                        <th class="wd-40p">{{ __('home.product') }}</th>
                                        <th class="tx-center"> {{__('home.quantity')}} </th>
                                        <th class="tx-center"> {{__('home.price')}} </th>
                                        <th class="tx-center"> {{__('home.addedValue')}}    </th>
                                        <th class="tx-center"> {{__('home.total')}}    </th>
                                       
                                       

                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0;
                                $totalprice=0;
                                $totalAddedvalue=0; ?>

                                @foreach ($data['productsdata'] as $product)
                                <?php $i++;
                                $totalprice+=$product->purchasingـprice  *$product->numberofpice;
                                $totalAddedvalue+=$product->Added_Value*$product->numberofpice;
                                ?>
                                @if($product->numberofpice!=0)

                                    <tr>
                                    <td>{{ $i }}</td>

                                        <td dir=ltr>{{$product->productData->Product_Code}}</td>
                                        <td class="tx-12">{{$product->product_name}}</td>
                                        <td class="tx-center">{{ $product->numberofpice}}</td>
                                        <td class="tx-center">{{ $product->purchasingـprice}}</td>
                                        <td class="tx-center">{{ $product->Added_Value}}</td>
                                        <td class="tx-center">{{ ($product->Added_Value*$product->numberofpice)+($product->purchasingـprice  *$product->numberofpice)}}</td>
                                       
                                    </tr>
                                    @endif
                                    @endforeach

                              
                                   
                                </tbody>
                            </table>
                        </div>

                        
                        <br>
                        <div class="table-responsive mg-t-30 table-padding">
                            <table class="table table-bordered table-striped text-center table-invoice border text-md-nowrap mb-0" id="tableTotalPrice" name="tableTotalPrice"width="50%">
	<col style="width:15%">
	<col style="width:15%">
	<col style="width:15%">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">{{ __('home.the amount') }}</th>
                                    <th class="border-bottom-0">{{ __('home.addedValue') }}</th>
                                    <th class="border-bottom-0">{{ __('home.total') }} </th>

                                </tr>
                            </thead>
                            <body>
<tr>
<td>  {{$totalprice}}</td>
<td>{{$totalAddedvalue}}</td>
<td>{{$totalAddedvalue+ $totalprice}}</td>
</tr>
                            
                                </body>

                            </table>
                        <br>
                        <br>
                        <br>
                        
                        <p>{{__('home.signtyre_purchase_manger')}}</p>
                        <p>{{__('home.thesignature')}} : </p>

                        
                        
                        <hr class="mg-b-40">



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
