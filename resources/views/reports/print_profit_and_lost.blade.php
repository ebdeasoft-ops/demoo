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
{{ __('home.profit_and_lost') }}
@stop
@section('page-header')
<div class="main-parent">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between parent-heading">
        <div class="my-auto">
            <div class="d-flex">
                <h5 style="color: white" class="mt-1">
                    معاينة طباعة الفاتورة</h5>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
    @endsection
    @section('content')
    <!-- row -->
    <div class="row row-sm">
        <div style="padding-left: 0;padding-right:0" class="col-md-12 col-xl-12">

            </h5>
            <div class="col-md-12 col-xl-12">
                <div class=" main-content-body-invoice" id="print">


                    <div class="card card-invoice p-3 pt-4">
<div class="row justify-content-center">    

     <div class="d-flex ">
                            <button class="btn btn-danger print-style float-left mt-3 mr-2" id="print_Button"
                                onclick="printDiv()">
                                {{ __('home.print') }}
                                <i class="mdi mdi-printer ml-1"></i>
                              
                             
                        </div>
                        
                          &nbsp;
                                &nbsp;
                                    <a style="background-color: #419BB2;font-size:17px" class="btn btn-success p-1" href="{{ url('/' . ($page = 'profit_lose_export') .'/' . $start . '/' . $end. '/' . $branch) }}">
                              EXPORT
                                <svg style="width: 20px !important" class="svg-icon-buttons" viewBox="0 0 20 20">
                                    <path d="M17.453,12.691V7.723 M17.453,12.691V7.723 M1.719,12.691V7.723 M18.281,12.691V7.723 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M7.309,13.312h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,13.312,7.309,13.312 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M16.625,6.066h-1.449V3.168c0-0.228-0.186-0.414-0.414-0.414H5.238c-0.228,0-0.414,0.187-0.414,0.414v2.898H3.375c-0.913,0-1.656,0.743-1.656,1.656v4.969c0,0.913,0.743,1.656,1.656,1.656h1.449v2.484c0,0.228,0.187,0.414,0.414,0.414h9.523c0.229,0,0.414-0.187,0.414-0.414v-2.484h1.449c0.912,0,1.656-0.743,1.656-1.656V7.723C18.281,6.81,17.537,6.066,16.625,6.066 M5.652,3.582h8.695v2.484H5.652V3.582zM14.348,16.418H5.652v-4.969h8.695V16.418z M17.453,12.691c0,0.458-0.371,0.828-0.828,0.828h-1.449v-2.484c0-0.228-0.186-0.414-0.414-0.414H5.238c-0.228,0-0.414,0.186-0.414,0.414v2.484H3.375c-0.458,0-0.828-0.37-0.828-0.828V7.723c0-0.458,0.371-0.828,0.828-0.828h13.25c0.457,0,0.828,0.371,0.828,0.828V12.691z M7.309,13.312h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,13.312,7.309,13.312M7.309,15.383h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,15.383,7.309,15.383 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555">
                                    </path>
                                </svg>
                            </a>

</div>
                   
                        <br>

                        <div class="card-body pt-3">
                            <div class="invoice-header" style="display: flex;justify-content:space-between;width:100%">

                                <div class="billed-from" style="width:33%;text-align: center;">
                                    <br>
                                    <span style="font-size:25px">{{Nameen}}</span>
                                    <br>
                                    <p dir=ltr> {{describtionen}} </p>
                                    <span dir=ltr>{{STen}} </span>
                                    <p dir=ltr> {{Taxen}} </p>

                                </div>
                                <div class="row">
                                    <?php
$logo=camplogo;
    ?>
                                    <a href="https://ebdeasoft.com/"><img
                                            src="{{ asset('assets\img\brand').'/'.$logo }}" class="logo-1" alt="logo"
                                            style="width: 110px; height: 70px;"></a>

                                </div>


                                <div class="billed-from" style="width:33%;text-align: center;">
                                    <br>

                                    <span style="font-size:25px">{{Namear}}</span>
                                    <br>
                                    <p> {{describtionar}}</p>
                                    <p>{{STar}}</p>
                                    <p>{{Taxar}}</p>

                                </div><!-- billed-from -->
                            </div><!-- invoice-header -->
                            <div class="row mg-t-12">
                                <br>
                                <br>
                                <br>

                            </div>





                            <?php
                            $currentdata = \Carbon\Carbon::now()->addHours(3)->format("Y-m-d H:i:s");
                            $banktransfertotal=0;
                            ?>

                            <center>

                                <h6 style="color: black" class="invoice-title">{{ __('home.profit_and_lost') }}</h6>


                            </center>

                            <div class="table-padding table-responsive ">


                                <table style="border: 2px solid rgba(0,0,0,0)"
                                    class="table table-striped table-bordered text-center my-2">
                                    <col style="width:15%">
                                    <col style="width:15%">
                                    <col style="width:20%">
                                    <col style="width:15%">
                                    <col style="width:20%">
                                    <thead>
                                        <tr>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label
                                                    style="font-size: 14px;color:#419BB2 ;font-weight:bold;"
                                                    for="exampleFormControlSelect1">
                                                    {{ __('report.fromdate') }}:</label>

                                            </th>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label
                                                    style="font-size: 14px;color:#419BB2 ;font-weight:bold;"
                                                    for="exampleFormControlSelect1"> {{ $start }}</label>
                                            </th>

                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label
                                                    style="font-size: 14px;color:#419BB2 ;font-weight:bold;"
                                                    for="exampleFormControlSelect1"> {{ __('report.todate') }}</label>
                                            </th>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label
                                                    style="font-size: 14px;color:#419BB2 ;font-weight:bold;"
                                                    for="exampleFormControlSelect1">{{ $end }}</label></th>


                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label
                                                    style="font-size: 14px;color:#419BB2 ;font-weight:bold;"
                                                    for="exampleFormControlSelect1"> {{ __('home.branch') }} </label>

                                            </th>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label
                                                    style="font-size: 14px;color:#419BB2 ;font-weight:bold;"
                                                    for="exampleFormControlSelect1"> {{ $branch }}</label>
                                            </th>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label
                                                    style="font-size: 14px;color:#419BB2 ;font-weight:bold;"
                                                    for="exampleFormControlSelect1"> {{ __('home.exportTime') }}
                                                </label>

                                            </th>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label
                                                    style="font-size: 14px;color:#419BB2 ;font-weight:bold;"
                                                    for="exampleFormControlSelect1"> {{ $currentdata }}</label>
                                            </th>
                                        </tr>


                                    </thead>
                                </table>
                            </div>

                            <hr class="mg-b-40">

                            <div class="table-padding table-responsive ">


                                <table style="border: 2px solid rgba(0,0,0,0)"
                                    class="table table-striped table-bordered text-center my-2">
                                    <col style="width:30%">
                                    <col style="width:20%">
                                    <col style="width:30%">
                                    <col style="width:20%">

                                    <thead>
                                        <tr>
                                            <th>-</th>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label
                                                    style="font-size: 14px;color:#419BB2 ;font-weight:bold;"
                                                    for="exampleFormControlSelect1">التكاليف والمصاريف Costs and
                                                    expenses</label>

                                            </th>
                                            <th>-</th>

                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label
                                                    style="font-size: 14px;color:#419BB2 ;font-weight:bold;"
                                                    for="exampleFormControlSelect1"> الايردات Revenue </label>
                                            </th>


                                        </tr>


                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>المصاريف - expenses</td>
                                            <td>{{$data['expense']}}</td>
                                            <td>ايردات المبيعات  Sales revenue  </td>
                                            <td>{{$data['sales']}}</td>
                                        </tr>

                                        <tr>
                                            <td>تكاليف المشتريات Purchasing costs</td>
                                            <td>{{$data['purchase']}}</td>
                                            <td> ايردات مرتجع المشتريات Purchase returns</td>
                                            <td>{{$data['purchase_return']}}</td>
                                        </tr>
                                        <tr>
                                            <td>تكاليف مرتجع المبيعات Sales return costs</td>
                                            <td>{{$data['sales_return']}}</td>
                                            <td>  ايردات بيع الاصول Selling assets</td>
                                            <td>0</td>
                                        </tr>
                                           <tr>
                                            <td>تكاليف اخري Other costs </td>
                                            <td>0</td>
                                            <td>  ايردات اخري  Other revenues </td>
                                            <td>0</td>
                                        </tr>
                                        <?php
                                        $total_expense=$data['purchase']+$data['expense']+$data['sales_return'];
                                        $total_incoming=$data['purchase_return']+$data['sales'];
                                        $profit_final_value=$total_incoming-$total_expense;
                                        $string_value=$profit_final_value>0?'صافي الربح  Net profit':'صافي الخسارة Net loss';
                                        ?>
                                        <tr>
                                            <td>الاجمالي  TOTAL</td>

                                            <td>  {{   $total_expense}} </td>
                                            <td>الاجمالي  TOTAL</td>

                                            <td>  {{    $total_incoming}} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-padding table-responsive ">


                                <table style="border: 2px solid rgba(0,0,0,0)"
                                    class="table table-striped table-bordered text-center my-2">
                                    <col style="width:15%">
                                    <col style="width:15%">

                                    <thead>
                                        <tr>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label
                                                    style="font-size: 14px;color:#419BB2 ;font-weight:bold;"
                                                    for="exampleFormControlSelect1"> {{ $string_value}}:</label>

                                            </th>
                                            <th style="background-color: rgba(236, 240, 250, 1);"> <label
                                                    style="font-size: 14px;color:#419BB2 ;font-weight:bold;"
                                                    for="exampleFormControlSelect1">
                                                    {{$profit_final_value>0? $profit_final_value:$profit_final_value*-1}}</label>
                                            </th>


                                        </tr>


                                    </thead>
                                </table>
                            </div>

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
</div>
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