@extends('layouts.master')
@section('css')
<style>
    form {
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
    }

    .radio-label {
        display: flex;
        cursor: pointer;
        font-weight: 500;
        position: relative;
        overflow: hidden;
        margin-bottom: 0.375em;
        /* Accessible outline */
        /* Remove comment to use */
        /*
  	&:focus-within {
  			outline: .125em solid $primary-color;
  	}
  */
    }

    .radio-label input {
        position: absolute;
        left: -9999px;
    }

    .radio-label input:checked+span {
        background-color: #d6d6e5;
    }

    .radio-label input:checked+span:before {
        box-shadow: inset 0 0 0 0.4375em #00005c;
    }

    .radio-label span {
        display: flex;
        align-items: center;
        padding: 0.375em 0.75em 0.375em 0.375em;
        border-radius: 99em;
        transition: 0.25s ease;
    }

    .radio-label span:hover {
        background-color: #d6d6e5;
    }

    .radio-label span:before {
        display: flex;
        flex-shrink: 0;
        content: "";
        background-color: #fff;
        width: 1.5em;
        height: 1.5em;
        border-radius: 50%;
        margin-right: 0.375em;
        transition: 0.25s ease;
        box-shadow: inset 0 0 0 0.125em #00005c;
    }
</style>
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
{{ __('supprocesses.stockadjustment') }}@stop
@endsection
@section('page-header')
<div class="main-parent">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between parent-heading">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('supprocesses.stockadjustment') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
                </span>
            </div>
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
    @if (session()->has('productupdated'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <br>

        <strong>{{ session()->get('productupdated') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">



            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <!-- row -->
    <div class="row">

        <div class="col-xl-12">
            <div class="card mg-b-20">


                <div class="card-header pb-0">

                    <form action="{{ url(Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() . '/' . ($page = 'stockAdjastment')) }}" method="POST" role="search" autocomplete="off">
                        {{ csrf_field() }}







                        <div class="row">



                            <div class="col-lg-3 mg-t-20 mg-lg-t-0" id="type">
                                <input class="form-control select2 " name="productNo" id="productNo" hidden required>

                            </div>
                            <!-- col-4 -->




                        </div>
                        <div class="col-lg-4 mg-t-20 mg-lg-t-0">

                            <a style="background-color: #FBA10F" class="modal-effect btn btn-md px-0 btn-info" data-effect="effect-scale" data-toggle="modal" href="#SearchProduct" title="تحديد"><i style="
                 width: 200px;" class="las la-search">
                                    {{ __('home.chooose product') }}</i></a>
                        </div>
                        <br>
                        <div class="card pt-4">
                            <div class="card-body pt-3">

                                <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2" action="{{ url(Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() . '/' . ($page = 'Increaseـor_deduction')) }}" method="post">
                                    {{ csrf_field() }}
                                 
                   
                            <div style="border-radius: 10px;width:30% !important" class="row card text-center p-3 mx-2 card-increase">

                                <label style="font-size: 1.1vw;" class="radio-label parent-label mb-3">&nbsp;
                                    <input checked name="rdio" type="radio" value="1" id="type_div" />
                                    <span class="span-radio">{{ __('home.increasequantity') }}</span>
                                </label>
                                <label style="font-size: 1.1vw;" class="radio-label parent-label mb-3">&nbsp;
                                    <input name="rdio" value="2" type="radio" />
                                    <span class="span-radio">{{ __('home.decreasequentity') }}</span>
                                </label>

                            </div>
                            <input type="hidden" id="token_search" value="{{ csrf_token() }}">


                            <div class="row">

                                <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                    <label for="inputName" class="control-label parent-label"> {{ __('home.productname') }} </label>
                                    <input type="text" class="form-control parent-input" id="productnameshow" name="productnameshow" readonly required>

                                </div>
                                <div class="col-lg-2 mg-t-20 mg-lg-t-0" id="type">
                                    <p class="mg-b-10 parent-label"> {{ __('home.productNo') }} </p>
                                    <input class="form-control parent-input parent-input" name="productcode" id="productcode" list="productsList" dir="ltr" readonly>
                                </div>




                                <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                    <label for="inputName" class="control-label parent-label"> {{ __('supprocesses.current_quantity') }}
                                    </label>
                                    <input type="number" class="form-control parent-input" id="quentity" name="quentity" readonly>
                                </div>
                                 <div class="col-lg-3 mg-t-20 mg-lg-t-0" >
                                    <label for="inputName"  class="control-label parent-label"> {{ __('home.notesClient') }}
                                    </label>
                                    <input type="test" class="form-control parent-input" id="note" name="note" required onkeyup="convertToNewQuantity()" required>
                                </div>
                                <div class="col-lg-2 mg-t-20 mg-lg-t-0" id="lnWrapper">
                                    <label for="inputName" id='productincreaselabel' class="control-label parent-label"> {{ __('home.productincrease') }}
                                    </label>
                                    <input type="number" class="form-control parent-input" id="productincrease" name="productincrease" required onkeyup="convertToNewQuantity()" required>
                                </div>

                                <div class="col-lg-2 mg-t-20 mg-lg-t-0" id="fnWrapper">
                                    <label for="inputName" id="productdecreaselabel" class="control-label parent-label"> {{ __('home.productdecrease') }}
                                    </label>
                                    <input type="number" class="form-control parent-input" id="productdecrease" name="productdecrease" required onkeyup="convertToNewQuantity()" required>
                                </div>
                                
                                <input type="number" class="form-control parent-input" id="orderNo" name="orderNo" hidden>
                            </div>
                            <br>

                            <div class="d-flex justify-content-center">
                                <button style="background-color: #419BB2;font-size:17px" type="submit" class="btn btn-success">
                                    {{ __('roles.update') }}
                                    <svg style="width: 20px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                        <path fill="none" d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z"></path>
                                    </svg>
                                </button>
                            </div>
                            <input hidden=true class="form-control" id="branchs_id" name="branchs_id" value="{{Auth()->user()->branchs_id}}">


                            <br>



                        </div>
                </div>



                <br>



                @if (isset($itemsRequest))
                <?php $i = 0; ?>
                <div class="col-xl-12">
                    <div class="card mg-b-20">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <i class="mdi mdi-dots-horizontal text-gray"></i>
                                <i class="mdi mdi-dots-horizontal text-gray"></i>
                                <i class="mdi mdi-dots-horizontal text-gray"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive hoverable-table">
                                <table class="table table-hover" id="example1" data-page-length='50' style=" text-align: center;">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0"># </th>
                                            <th class="border-bottom-0">{{ __('home.productNo') }} </th>
                                            <th class="border-bottom-0">{{ __('home.product') }}</th>
                                            <th class="border-bottom-0">{{ __('home.quantity') }}</th>



                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @foreach ($itemsRequest as $product)
                                        <?php $i++; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $product->productData->Product_Code }}</td>
                                            <td>{{ $product->productData->product_name }}</td>
                                            <td>{{ $product->quantity }}</td>

                                        <tr>
                                            @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">

                                    <a class="btn btn-success" href="{{ url('/' . ($page = 'printOrderPriceFromSupplier') . '/' . $itemsRequest[0]->order_id) }}">
                                        {{ __('home.print') }}</a>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br />
            </form>

        </div>




        <div class="row">







            @endif

            </table>

        </div>
    </div>


</div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!--search  -->

<div class="modal fade" id="SearchProduct" name="SearchProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" dir='rtl' aria-hidden="true">
    <div class="modal-dialog modal-xl product-selection" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="card-body">

                    <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                        <label for="inputName" style="font-weight: bold" class="control-label parent-label"> {{__('home.searchaboutproduct')}} </label>
                        <input dir="ltr" type="text" class="form-control parent-input" placeholder="{{ __('home.Search By Name or Product Number') }}" id="searchaboutproduct" name="searchaboutproduct" onkeyup="searchaboutproductfunction()">
                    </div>
                    <br>
                    <div class="table-responsive" id="ajax_responce_serarchDiv">
                        <table class="table text-md-nowrap text-center our-table" id="SearchProductTable" width="100%" style="border: 2px solid rgba(0,0,0,.3);">
                            <col style="width:5%">
                            <col style="width:14%">
                            <col style="width:28%">
                            <col style="width:10%">
                            <col style="width:10%">
                            <col style="width:13%">
                            <col style="width:10%">
                            <col style="width:10%">

                            <thead>
                                <tr>
                                    <th style="font-size: 15px" class="border-bottom-0">#</th>
                                    <th style="font-size: 15px" class="border-bottom-0">{{__('home.productNo')}} </th>
                                    <th style="font-size: 15px" class="border-bottom-0" style="text-align:center">{{__('home.product')}}</th>
                                    <th style="font-size: 15px" class="border-bottom-0" style="text-align:center">{{__('home.branch')}}</th>
                                    <th style="font-size: 15px" class="border-bottom-0" style="text-align:center">{{__('home.productlocation')}}</th>

                                    <th style="font-size: 15px" class="border-bottom-0">{{__('home.quantity')}}</th>
                                    <th style="font-size: 13px" class="border-bottom-0">{{__('home.purchaseproductwithouttax')}}</th>
                                    <th style="font-size: 13px" class="border-bottom-0">{{__('home.sellingproduct without tax')}}</th>
                                    <th style="font-size: 15px" class="border-bottom-0">{{__('home.Add')}}</th>



                                </tr>
                            </thead>
                            <tbody class="">
                                <?php $i = 0;
                                $data = 'm'; ?>

                                <?php $i++ ?>

                                <tr>
                                    <td id="tableData" dir=ltr>-</td>
                                    <td id="tableData" dir=ltr>-</td>
                                    <td id="tableData" data-target="product_name">-</td>
                                    <td id="tableData" data-target="product_name">-</td>
                                    <td id="tableData" data-target="numberofpice">-</td>
                                    <td id="tableData" data-target="numberofpice">-</td>
                                    <td id="tableData" data-target="numberofpice">-</td>
                                    <td id="tableData" data-target="numberofpice">-</td>
                                    <td id="tableData">- </td>
                                </tr>
                            </tbody>
                        </table>
                        <div>

                        </div>
                        <div class="row d-flex justify-content-between pagination-row">



                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('home.cancel')}}</button>
                    </div>

                </div>


            </div>
        </div>

    </div>

    <!-- main-content closed -->
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
</script>
<script>
    function convertToNumbersalePrice() {
        var input = document.getElementById("sale_price");
        var val = toEnglishNumber(input.value)
        input.value = val;
    }

    function toEnglishNumber(strNum) {
        var ar = '٠١٢٣٤٥٦٧٨٩'.split('');
        var en = '0123456789'.split('');
        strNum = strNum.replace(/[٠١٢٣٤٥٦٧٨٩]/g, x => en[ar.indexOf(x)]);
        //  strNum = strNum.replace(/[^\d]/g, '');
        return strNum;
    }
</script>
<script>
    function convertToNewQuantity() {
        var input = document.getElementById("newquentity");
        var val = toEnglishNumber(input.value)
        input.value = val;
    }

    function toEnglishNumber(strNum) {
        var ar = '٠١٢٣٤٥٦٧٨٩'.split('');
        var en = '0123456789'.split('');
        strNum = strNum.replace(/[٠١٢٣٤٥٦٧٨٩]/g, x => en[ar.indexOf(x)]);
        //  strNum = strNum.replace(/[^\d]/g, '');
        return strNum;
    }
    document.addEventListener('keydown', (e) => {
        if (e.key === "F9") {
            $('#SearchProduct').modal().show();

        }
    })
    document.addEventListener('keydown', (e) => {
        searchtext = $('#product_code').val();

        if (e.key === "Enter") {
            searchtext = $('#product_code').val();
            $('#searchaboutproduct').val(searchtext);
            // document.getElementById("searchaboutproduct").focus();
            $('#SearchProduct').modal().show();



        }
    })
    $('#SearchProduct').on('shown.bs.modal', function() {
        $('#searchaboutproduct').focus();
    })
</script>
<script>
    function searchaboutproductfunction() {
        searchtext = $('#searchaboutproduct').val();
        branchs_id = $('#branchs_id').val();
        var token_search = $("#token_search").val();


        console.log(branchs_id)
        jQuery.ajax({
            url:  "{{ URL::to('ChooseProductpaginatenewupdate')}}",
                type: 'post',
                cache: false,
                dataType: 'html',
                data: {
                    "_token": token_search,
                    "searchtext": searchtext,
                    "branchs_id": branchs_id,
                },
                  success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {

            }
        });

    }
    $(document).on('click', '#ajax_pagination_in_search a ', function(e) {
        e.preventDefault();
           searchtext = $('#searchaboutproduct').val();
        branchs_id = $('#branchs_id').val();
        var token_search = $("#token_search").val();
        var url = $(this).attr("href");

        jQuery.ajax({
            url: url,
                  type: 'post',
                cache: false,
                dataType: 'html',
                data: {
                    "_token": token_search,
                    "searchtext": searchtext,
                    "branchs_id": branchs_id,
                },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {

            }
        });
    });
    $('#SearchProduct').on('show.bs.modal', function(event) {
        branchs_id = $('#branchs_id').val();
        console.log(branchs_id)
        jQuery.ajax({
            url: " {{URL::to('ChooseProductpaginatenew')}}/" + branchs_id,
            type: 'get',
            dataType: 'html',
            cache: false,

            success: function(data) {
                console.log('done')
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {

            }
        });

    })
</script>

<script>
    function chooseProduct(code, name, price, sale_price, productcode, availablequantity, productcode2) {
        $('#SearchProduct').modal().hide();
        console.log('gggffffffff')
        console.log(code)
        console.log(availablequantity)
        console.log(productcode)
        console.log(productcode2)
        console.log(price)
        console.log(code)
        console.log('gggffffffff')

        var Product_Code = code
        var product_name = name
        var product_sale_pice = price
        searchtext = productcode;
        branchs_id = $('#branchs_id').val();
        console.log(" {{URL::to('detproductbycode')}}/" + searchtext + "/" + branchs_id)
        jQuery.ajax({
            url: " {{URL::to('detproductbycode')}}/" + searchtext + "/" + branchs_id,
            type: 'get',
            cache: false,
            dataType: "json",
            success: function(data) {

                console.log(data)

                availablequantity = data['numberofpice']

                $('#quentity').val(availablequantity);




            }

        })
        $("#productNo").val(code);
        $('#productnameshow').val(name);
        $('#productcode').val(productcode);
        avtsale = $('#avtValue').val();
        $('#avt').val(sale_price * avtsale);
    }
</script>

<script>
    $(document).ready(function() {
        $('select[name="suppliertNosearch"]').on('change', function() {
            console.log('AJAX load   work 0000');

            var selectclientid = $(this).val();
            if (selectclientid) {
                console.log('AJAX load   work');

                $.ajax({
                    url: "{{ URL::to('getsupllier') }}/" + selectclientid,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log("success");
                        console.log(data['name']);
                        $('#clientName').val(data['name']);
                        $('#address').val(data['location']);
                        $('#phonenumber').val(data['phone']);
                        $('#notes').val(data['comp_name']);
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });

        $('select[name="suppliernamesearch"]').on('change', function() {
            console.log('AJAX load   work 0000');

            var selectclientid = $(this).val();
            if (selectclientid) {
                console.log('AJAX load   work');

                $.ajax({
                    url: "{{ URL::to('getsupllier') }}/" + selectclientid,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log("success");
                        console.log(data['name']);
                        $('#clientName').val(data['name']);
                        $('#address').val(data['location']);
                        $('#phonenumber').val(data['phone']);
                        $('#notes').val(data['comp_name']);
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });

    $('select[name="productNo"]').on('change', function() {
        console.log('AJAX load   work 0000');

        var selectclientid = $(this).val();
        if (selectclientid) {
            console.log('AJAX load   work');
            $.ajax({
                url: "{{ URL::to('getproduct') }}/" + selectclientid,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log("success123");
                    console.log(data);
                    console.log("{{ URL::to('getsupllier') }}/" + selectclientid);
                    $('#productnameshow').val(data['product_name']);
                    $('#quentity').val(data['numberofpice']);

                },
            });
        } else {
            console.log('AJAX load did not work');
        }
    });
    $('select[name="productname"]').on('change', function() {
        console.log('AJAX load   work 0000');

        var selectclientid = $(this).val();
        if (selectclientid) {
            console.log('AJAX load   work');
            $.ajax({
                url: "{{ URL::to('getproduct') }}/" + selectclientid,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log("success123");
                    console.log(data);
                    console.log("{{ URL::to('getsupllier') }}/" + selectclientid);
                    $('#productnameshow').val(data['product_name']);
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

        $('#productdecrease').val(0);
        $('#productincrease').val(0);

            $(function() {
                var timeout = 4000; // in miliseconds (3*1000)
                $('.alert').delay(timeout).fadeOut(500);
            });

       
        $(function() {
            var timeout = 4000; // in miliseconds (3*1000)
            $('.alert').delay(timeout).fadeOut(500);
        });
        $('#productdecrease').hide();

        $('#productdecreaselabel').hide();

        $('input[type="radio"]').click(function() {
            if ($(this).attr('id') == 'type_div') {

                $('#productincreaselabel').show();
                $('#productincrease').show();
                $('#productdecreaselabel').hide();
                $('#productdecrease').hide();
                $('#productdecrease').val(0);
                $('#lnWrapper').show();

            } else {

                $('#productdecreaselabel').show();
                $('#productdecrease').show();
                $('#productincrease').hide();
                $('#productincrease').val(0);
                $('#productincreaselabel').hide();
                $('#lnWrapper').hide();

            }
        });
    });
</script>



@endsection