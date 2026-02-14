@extends('layouts.master')
@section('css')
<!-- Internal Data table css -->
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

<!-- Internal Spectrum-colorpicker css -->
<link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

<!-- Internal Select2 css -->
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

@section('title')
{{ __('home.recentquotation') }}@stop
@endsection
@section('page-header')
<div class="main-parent">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between parent-heading">
        <div class="my-auto">
            <h4 class="content-title mb-0 my-auto">{{ __('home.recentquotation') }}</h4>
        </div>
    </div>
    <!-- breadcrumb -->
    @endsection
    @section('content')

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>خطا</strong>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- row -->
    <div class="row">

        <div class="col-xl-12">
            <div class="card mg-b-20">


                <div class="card-header pb-0">







                    {{-- 3 --}}


                    <br>



                    <?php $i = 0; ?>
                    <div class="col-xl-12">
                        <div class="card mg-b-20">
                            <div class="card-header pb-0">
                                      <div class="row">

                                        <div class="col-lg-6" id="start_at">
                                            <label class="parent-label" for="exampleFormControlSelect1"> {{ __('home.enterinvoicenumber') }}</label>
                                            <input class="form-control" value="{{ $start_at ?? '' }}" id="invoiceid" placeholder="00" type="text" onchange="searchaboutinvoiceByIdfunction()" required>
                                        </div><!-- input-group -->
                             <div class="col-lg-4" id="start_at">
                                <label for="inputName" class="control-label parent-label">{{ __('home.chooseclient') }}</label>

                                <select class="form-control select2" name="clientnamesearch" id="clientnamesearch">


                                    @foreach (App\Models\customers::get() as $customer)
                                    <option value="{{ $customer->id }}"> {{ $customer->id==1?__('home.Cash Custome'):$customer->name }}- {{ $customer->tax_no}} 

                                    </option>
                                    @endforeach
                                </select>
                            </div><!-- col-4 -->
                                    </div>
                                <div class="d-flex">

                              

                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="card-body">
                                <div class="table-responsive hoverable-table" id="previous1uotestable">
                                    <table class="table text-md-nowrap text-center our-table" id="example12" data-page-length='50' style=" text-align: center;">
                                        <thead>
                                            <tr>
                                                <th style="color: #FF4F1F;font-size:12px" class="border-bottom-0">{{ __('home.Invoice_no') }}</th>
                                                <th style="color: #FF4F1F;font-size:12px" class="border-bottom-0">{{ __('home.clietName') }}</th>
                                                <th style="color: #FF4F1F;font-size:12px" class="border-bottom-0">{{ __('home.date') }}</th>
                                                <th style="color: #FF4F1F;font-size:12px" class="border-bottom-0">{{ __('home.branch') }}</th>
                                                <th style="color: #FF4F1F;font-size:12px" class="border-bottom-0">{{ __('home.total') }}</th>

                                                <th style="color: #FF4F1F;font-size:12px" class="border-bottom-0">{{ __('home.operations') }}</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
       $avtSaleRate = App\Models\Avt::find(1);
       $avtSaleRate = $avtSaleRate->AVT;
                                            ?>
                                            @foreach ($data as $product)
                                            <?php $i++; ?>

                                            <tr id="<?php echo $product['id']; ?>">
                                                <td data-target="id">{{ $product->id }}</td>
                                                <td dir="ltr" data-target="id">
                                                    {{ $product->customer->name }}
                                                </td>
                                                <td>{{ $product->created_at }}</td>
                                                <td>{{ $product->branch->name }}
                                                </td>
<?php
$totalpricePurchases =0;
$totaldiscount =0;
                   foreach (App\Models\offer_price_to_customer_items::where('order_id',$product->id)->get() as $item)
{
                   $totalpricePurchases += ($item->PriceWithoudTax * $item->quantity);
                   $totaldiscount += $item->discount;
}
$offer_price_to_customer=App\Models\offer_price_to_customer::find($product->id);


$total_value_quote= round((round($totalpricePurchases,2)- round($totaldiscount+$offer_price_to_customer->discount,2))* $avtSaleRate,2)+round($totalpricePurchases,2)- round($totaldiscount+$offer_price_to_customer->discount,2) 
                   ?>     
                        <td>{{ $total_value_quote}}
                        </td>
                                                <td>
                                                <a class="modal-effect btn btn-sm btn-info"  data-effect="effect-scale" data-id="{{ $product->id }}" data-totalinvoice="{{$total_value_quote}}" data-toggle="modal" href="#paymentmethod" title="تعديل طريقة الدفع">{{ __('home.updateinvoicebyid') }}<i class="las la-pen"></i></a>
                                                <a class="modal-effect btn btn-sm btn-info"  data-effect="effect-scale" data-id="{{ $product->id }}" data-totalinvoice="{{$total_value_quote}}" data-toggle="modal" href="#delete_quotation" title="تعديل طريقة الدفع">{{ __('home.delete') }}<i class="las la-pen"></i></a>
                                                
                                              <a style="background-color: green;" class="modal-effect btn btn-sm btn-info"    data-effect="effect-scale"   href="generate_pdf_qoute/{{ $product->id }}" target="_blank" >{{ __('home.dwonloadpdf') }}&nbsp;<i class="fa-solid fa-download"></i></i></a>
                                                <a style="background-color: green;" class="modal-effect btn btn-sm btn-info"    data-effect="effect-scale"   href="OfferPricesTocustomer_for_update/{{ $product->id }}" target="_blank" >{{ __('home.update_qutation') }}&nbsp;</i></a>

                                                    <div class="d-flex justify-content-center">
                                                        
                                                
                                                        <form action="{{ url(Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() . '/' . ($page = 'print_order_perice_to_customer')) }}" method="POST" role="search" autocomplete="off">
                                                            {{ csrf_field() }}


                                                            <div class="d-flex justify-content-center">
                                                                <input type="number" class="form-control parent-input " name="OrderNoprint" id="OrderNoprint" title=" رقم الفاتورة " value="{{ $product->id }}" readonly required=true hidden>

                                                                <button style="background-color: #419BB2;font-size:17px" type="submit" class="btn btn-success mt-3 p-1 px-2">
                                                                    {{ __('home.show') }}
                                                                    <svg style="width: 22px !important" class="svg-icon-buttons" viewBox="0 0 20 20">
                                                                        <path d="M17.453,12.691V7.723 M17.453,12.691V7.723 M1.719,12.691V7.723 M18.281,12.691V7.723 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M7.309,13.312h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,13.312,7.309,13.312 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M16.625,6.066h-1.449V3.168c0-0.228-0.186-0.414-0.414-0.414H5.238c-0.228,0-0.414,0.187-0.414,0.414v2.898H3.375c-0.913,0-1.656,0.743-1.656,1.656v4.969c0,0.913,0.743,1.656,1.656,1.656h1.449v2.484c0,0.228,0.187,0.414,0.414,0.414h9.523c0.229,0,0.414-0.187,0.414-0.414v-2.484h1.449c0.912,0,1.656-0.743,1.656-1.656V7.723C18.281,6.81,17.537,6.066,16.625,6.066 M5.652,3.582h8.695v2.484H5.652V3.582zM14.348,16.418H5.652v-4.969h8.695V16.418z M17.453,12.691c0,0.458-0.371,0.828-0.828,0.828h-1.449v-2.484c0-0.228-0.186-0.414-0.414-0.414H5.238c-0.228,0-0.414,0.186-0.414,0.414v2.484H3.375c-0.458,0-0.828-0.37-0.828-0.828V7.723c0-0.458,0.371-0.828,0.828-0.828h13.25c0.457,0,0.828,0.371,0.828,0.828V12.691z M7.309,13.312h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,13.312,7.309,13.312M7.309,15.383h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,15.383,7.309,15.383 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </form>

                                                        <br>
                                                    </div>




                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <div class="justify-content-start" id="ajax_pagination_in_search">
                                        {{ $data->links() }}
                                    </div>

                                    <div>



                                    </div>
                                    <br>

                                </div>
                            </div>
                        </div>

                        <br />

                    </div>



                </div>
            </div>
            <!-- row closed -->
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->
</div>
<!-- enter payments -->


<!-- delete -->
<!-- enter payments -->
<div class="modal" id="paymentmethod">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"> {{ __('home.paymentmethod') }} </h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label style="font-size:16px" class="control-label parent-label">&nbsp;&nbsp;{{ __('home.total') }} :&nbsp; </label>
                    <label style="font-size:20px" id="totalvalue">0</label>
                    <label style="font-size:15px" class="control-label parent-label">&nbsp;{{ __('home.SAR') }} &nbsp;&nbsp;&nbsp;&nbsp; </label>
                    <br>


                </div>
                <div class=" col">
                    <label> {{ __('home.paymentmethod') }} </label>
                    <br>

                    <select class="form-control" name="paymodal" id='paymodal' required>

                        <option value="Cash"> {{ __('report.cash') }}</option>
                        <option value="Shabka"> {{ __('report.shabka') }} </option>
                        <option value="Bank_transfer"> {{ __('home.Bank_transfer') }} </option>
                        <option value="Credit"> {{ __('report.credit') }} </option>
                        <option value="Partition"> {{ __('home.Partition of the amount') }} </option>

                    </select>


                </div>
                <br>
                <div class="row">

                    <div class="col">

                        <label class="control-label parent-label">{{ __('report.cash') }}</label>
                        <input type="text" class="form-control parent-input" name="cashamount" id="cashamount" readonly value=0>
                    </div>

                    <div class="col">

                        <label class="control-label parent-label">{{ __('report.shabka') }}</label>
                        <input type="text" class="form-control parent-input" name="bankamount" id="bankamount" readonly value=0>
                    </div>

                    <div class="col">

                        <label class="control-label parent-label">{{ __('home.Bank_transfer') }}</label>
                        <input type="text" class="form-control parent-input" name="Bank_transfer" id="Bank_transfer" readonly value=0>
                    </div>
                    <div class="col">

                        <label class="control-label parent-label">{{ __('report.credit') }}</label><br>
                        <input type="text" class="form-control parent-input" name="creaditamount" id="creaditamount" readonly value=0>
                    </div>
                    <input hidden type="text" id="invoiceid">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('home.cancel') }}</button>
                <button id="confirmpayment" name="confirmpayment" data-dismiss="modal" class="btn btn-danger">{{ __('home.confirm') }}</button>
            </div>
        </div>
    </div>
</div>
    <div class="modal p-3" id="delete_quotation">
        <div style="margin: 0 9% !important;" class="modal-dialog modal-dialog-centered modal-special" role="document">
            <div class="modal-content modal-content-demo p-3">
                <form>
                    <div class="modal-header">
                        <h6 class="modal-title"> {{ __('home.alert') }} </h6><button aria-label="Close" class="close close-special" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    {{ csrf_field() }}
                    <div class="row mb-1">
                        <div class="col-lg-6 col-md-6 col-md-4 mb-2">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label"> {{ __('home.Are_you_sure_delete') }}</label>
                        </div>


                    </div>

                        <input type="text" hidden class="form-control parent-input" name="delete_id" id="delete_id" >

                    <br>
                     <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('home.cancel') }}</button>
                <button id="delete_quotation_function" name="delete_quotation_function" data-dismiss="modal" class="btn btn-danger">{{ __('home.confirm') }}</button>
            </div>
            </div>

        </div>
    </div>
</div>


@endsection
@section('js')
<!-- Internal Data tables -->

<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

<!--Internal  Datepicker js -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<!-- Internal Select2.min js -->
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!--Internal Ion.rangeSlider.min js -->
<script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
<!-- Ionicons js -->
<script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
<!--Internal  pickerjs js -->
<script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
<!-- Internal form-elements js -->
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
<script>
    var date = $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();

    $('#delete_quotation').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        $('#delete_id').val(id)
    });
    $('#paymentmethod').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var invoice = button.data('totalinvoice')
        $('#invoiceid').val(id)
        document.getElementById('totalvalue').innerHTML = invoice;
        $('#cashamount').val(invoice)

    });
    
    $("#confirmpayment").click(function(e) {


if ($('#cashamount').val() == '') {
    $('#cashamount').val(0)
}
if ($('#bankamount').val() == '') {
    $('#bankamount').val(0)
}
if ($('#creaditamount').val() == '') {
    $('#creaditamount').val(0)
}
if ($('#Bank_transfer').val() == '') {
    $('#Bank_transfer').val(0)
} else {

}


text = document.getElementById('totalvalue').innerText

console.log(" {{URL::to('updatepaymentconfirmpayment_in_quotation')}}/" + $('#invoiceid').val() + '/' + $('#cashamount').val() + '/' + $('#bankamount').val() + '/' + $('#creaditamount').val() + "/" + $('#Bank_transfer').val() + '/' + $('#paymodal').val())
if (Number(text) == (Number($('#cashamount').val()) + Number($('#Bank_transfer').val()) + Number($('#bankamount').val()) + Number($('#creaditamount').val()))) {
    $.ajax({
        url: " {{URL::to('updatepaymentconfirmpayment_in_quotation')}}/" + $('#invoiceid').val() + '/' + $('#cashamount').val() + '/' + $('#bankamount').val() + '/' + $('#creaditamount').val() + "/" + $('#Bank_transfer').val() + '/' + $('#paymodal').val(),
        type: "GET",
        dataType: "html",
        success: function(data) {

            const winUrl = URL.createObjectURL(
                new Blob([data], {
                    type: "text/html"
                })
            );
            const win = window.open(
                winUrl,
                "win",
                `width=800,height=400,screenX=200,screenY=200`
            );

        },
        error: function(response) {
console.log('response--------response')
console.log(response)
            alert("{{ __('home.sorryerror') }}")

        }

    })
} else {
    $('#saveinvice').val(0);

    alert("{{ __('home.entermonycorrect') }}")

}


})


</script>



<script>
    $("#delete_quotation_function").click(function(e) {


            var selectCustomer = $('#delete_id').val();
        if (selectCustomer != '') {
            $.ajax({
                url: " {{URL::to('delete_offer_price')}}" + "/" + selectCustomer,
                type: "GET",
                dataType: "html",
                success: function(products) {
                    $("#previous1uotestable").html(products);


                },
            });
        } else {
        
        }

        });
        
        
        
        
    function searchaboutinvoiceByIdfunction() {
        date = $('#invoiceid').val();
        if (date != '') {
            console.log("{{URL::to('ar/searchpreviousquotes')}}" + "/" + date)
            $.ajax({
                url: "{{URL::to('searchpreviousquotes')}}" + "/" + date,
                type: "GET",
                dataType: "html",
                success: function(products) {
                    $("#previous1uotestable").html(products);


                },
            });
        }
    }
          $('select[name="clientnamesearch"]').on('change', function() {
            console.log('AJAX load   work 0000');

            var selectCustomer = $(this).val();
        if (selectCustomer != '') {
            $.ajax({
                url: " {{URL::to('getquotebycustomer')}}" + "/" + selectCustomer,
                type: "GET",
                dataType: "html",
                success: function(products) {
                    console.log(products)
                    $("#previous1uotestable").html(products);


                },
            });
        } else {
        
        }

        });
</script>





















<script>
    $('select[name="paymodal"]').on('change', function() {

        var selectCustomer = $(this).val();
        if ($('#cashamount').val() != 0) {
            value = $('#cashamount').val()

        } else if ($('#bankamount').val() != 0) {
            value = $('#bankamount').val();

        } else if ($('#Bank_transfer').val() != 0) {
            value = $('#Bank_transfer').val();

        } else {
            value = $('#creaditamount').val();
        }


        if (selectCustomer == 'Cash') {
            $('#cashamount').val(value)
            $('#bankamount').val(0)
            $('#creaditamount').val(0)
            $('#Bank_transfer').val(0)
            document.getElementById("bankamount").readOnly = true;
            document.getElementById("cashamount").readOnly = true;
            document.getElementById("Bank_transfer").readOnly = true;


        } else if (selectCustomer == 'Shabka') {
            $('#cashamount').val(0)
            $('#bankamount').val(value)
            $('#creaditamount').val(0)
            $('#Bank_transfer').val(0)

            document.getElementById("bankamount").readOnly = true;
            document.getElementById("cashamount").readOnly = true;
            document.getElementById("Bank_transfer").readOnly = true;

        } else if (selectCustomer == 'Credit') {
            $('#cashamount').val(0)
            $('#bankamount').val(0)
            $('#Bank_transfer').val(0)
            $('#creaditamount').val(value)
            document.getElementById("bankamount").readOnly = true;
            document.getElementById("cashamount").readOnly = true;
            document.getElementById("Bank_transfer").readOnly = true;

        } else if (selectCustomer == 'Bank_transfer') {


            $('#cashamount').val(0)
            $('#bankamount').val(0)
            $('#creaditamount').val(0)
            $('#Bank_transfer').val(value)
            document.getElementById("bankamount").readOnly = true;
            document.getElementById("cashamount").readOnly = true;
            document.getElementById("Bank_transfer").readOnly = true;

        } else {
            $('#cashamount').val(value)
            $('#bankamount').val(0)
            $('#creaditamount').val(0)
            $('#Bank_transfer').val(0)
            document.getElementById("bankamount").readOnly = false;
            document.getElementById("cashamount").readOnly = false;
            document.getElementById("Bank_transfer").readOnly = false;


        }





    });
    $('#updateCustomer').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        $('#cashamount').val(0)
        $('#Bank_transfer').val(0)
        $('#creaditamount').val(0)
        $('#bankamount').val(0)

        var customername = button.data('customername')


        var modal = $(this)

        modal.find('.modal-body #customername').val(customername);
        modal.find('.modal-body #id').val(id);

    })
</script>

<script>

    $(document).ready(function() {


        $('select[name="clientnamesearch"]').on('change', function() {
            console.log('AJAX load   work 0000');

            var selectclientid = $(this).val();
            if (selectclientid) {
                console.log('AJAX load   work');

                $.ajax({
                    url: "{{ URL::to('getcustomer') }}/" + selectclientid,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log("success");
                        console.log(data['name']);
                        $('#clientName').val(data['name']);
                        $('#address').val(data['address']);
                        $('#phonenumber').val(data['phone']);
                        $('#notes').val(data['notes']);
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });

    $('select[name="searchproductNo"]').on('change', function() {
        console.log('AJAX load   work 0000');

        var selectclientid = $(this).val();
        if (selectclientid) {
            console.log('AJAX load   work');

            $.ajax({
                url: "{{ URL::to('getproduct') }}/" + selectclientid,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log("success");
                    console.log(data['name']);
                    $('#quentity').val(data['numberofpice']);

                },
            });
        } else {
            console.log('AJAX load did not work');
        }
    });
</script>




<script>
    $(document).ready(function() {
        $.ajax({
            url: " {{URL::to('getAllinvicesajax')}}",
            type: "GET",
            dataType: "html",
            success: function(products) {
                $("#ajax_responce_allinvoicesDiv").html(products);


            },
        });
        $('#invoice_number').hide();

        $('input[type="radio"]').click(function() {
            if ($(this).attr('id') == 'type_div') {
                $('#invoice_number').hide();
                $('#type').show();
                $('#start_at').show();
                $('#end_at').show();
            } else {
                $('#invoice_number').show();
                $('#type').hide();
                $('#start_at').hide();
                $('#end_at').hide();
            }
        });
    });
</script>


@endsection