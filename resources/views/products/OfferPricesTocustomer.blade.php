@extends('layouts.master')
@section('css')

<!-- Internal Data table css -->

<!--Internal  Datatable js -->
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<style>
    /* =========================
   Modern UI + Inner Borders
   ========================= */

    /* الخط العام */
    body,
    table,
    td,
    th,
    input,
    button,
    .form-control {
        font-family: "Tajawal", sans-serif;
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* جدول بحدود داخلية */
    table {
        border-collapse: collapse !important;
        width: 100%;
    }

    table thead th {
        background: #f1f3f9;
        padding: 12px;
        font-weight: 700 !important;
        color: #000 !important;
        text-align: center;
        border: 1px solid #d6d6d6 !important;
        /* حدود داخلية */
    }

    /* الصفوف */
    #productsTableBody tr {
        background: #ffffff;
        transition: background 0.2s ease;
    }

    #productsTableBody tr:hover {
        background: #f7f9ff;
    }

    /* حدود داخلية للـ <td> */
    #productsTableBody td {
        border: 1px solid #e0e0e0 !important;
        padding: 10px !important;
        vertical-align: middle;
    }

    /* الحقول */
    .form-control {
        border-radius: 6px !important;
        border: 1px solid #c8ccd4 !important;
        transition: .2s;
    }

    .form-control:focus {
        border-color: #478bff !important;
        box-shadow: 0 0 0 2px rgba(71, 139, 255, 0.25);
    }

    /* أزرار اختيار المنتج */
    .btn-info,
    .btn-primary {
        background: linear-gradient(135deg, #478bff, #357bff) !important;
        border: none !important;
        color: #fff !important;
        border-radius: 6px !important;
        font-weight: 700 !important;
    }

    .btn-info:hover,
    .btn-primary:hover {
        background: linear-gradient(135deg, #3f79ff, #296bff) !important;
        transform: translateY(-1px);
    }

    /* زر الحذف */
    .btn-danger {
        background: linear-gradient(135deg, #ff5b5b, #ff3b3b) !important;
        border: none !important;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #ff4343, #ff2020) !important;
        transform: scale(1.05);
    }

    /* زر إضافة صف */
    #addProductBtn,
    .btn-add-product {
        background: linear-gradient(135deg, #1a73e8, #0d5bd8) !important;
        padding: 8px 20px;
        border-radius: 8px !important;
        color: #fff !important;
        font-weight: 700 !important;
        border: none;
    }

    #addProductBtn:hover {
        transform: translateY(-2px);
    }

    /* المودال */
    .modal-content {
        border-radius: 12px !important;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        background: #f1f3f9;
        border-bottom: 1px solid #ddd !important;
    }

    .modal-title {
        color: #000 !important;
        font-weight: 700 !important;
    }

    .modal-body {
        background: #fff;
    }

    /* جدول البحث داخل المودال */
    #productsTable th,
    #productsTable td {
        border: 1px solid #dcdcdc !important;
    }

    #productsTable tr:hover {
        background: #eef3ff !important;
    }

    /* تحسين الـ div */
    td .d-flex {
        align-items: center;
    }
</style>
@section('title')
    {{ __('home.Offerـpricesـtoـcustomer') }}
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="main-parent">
        <div style="justify-content: space-between !important" class="breadcrumb-header parent-heading ">
            <div class="my-auto" style="width:100%">
                <div class="d-flex" style="width:100%">



                    <div class="d-flex">
                        <h4 class="conte  nt-title mb-0 my-auto">{{ __('home.Offerـpricesـtoـcustomer') }}</h4>
                        <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                        </span>
                    </div>
                    <div class="last-sales" style="width:70%"></div>
                    <div class="last-sales" style="font-size:13px;">
                        <select class="form-control select2" style=" font-size:18px;" name="numbershowstatus"
                            id="numbershowstatus" required>
                            <option style=" font-size:18px;" value=1>{{__('home.shownumberselect')}}</option>
                            <option style=" font-size:18px;" value=0>{{__('home.notshow')}}</option>
                        </select>
                    </div>



                    <div class="choose-product">
                        <button style="background-color: #23395D;"
                            class="modal-effect btn btn-sm btn-info p-2 m-1 button-eng" data-effect="effect-scale"
                            data-toggle="modal" href="#createcustomer">
                            {{ __('home.addnewcustomer') }}
                        </button>
                    </div>



                    <div class="choose-product">
                        <button style="background-color: #23395D;"
                            class="modal-effect btn btn-sm btn-info p-2 m-1 button-eng" data-effect="effect-scale"
                            data-toggle="modal" href="#createproduct">
                            {{ __('supprocesses.addproduct') }}
                        </button>
                    </div>

                     <div class="choose-product">
                                    <button style="background-color: green;"
                                        class="modal-effect btn btn-sm btn-info p-2 m-1 button-eng"
                                        data-effect="effect-scale" data-toggle="modal" href="#updateinvoicefromsale"
                                        title="تحديد"><i style=" height: 100;font-weight:400 !important;
                                                 width: 65px;
                                                 font-size:13px" class="las"> {{ __('home.update_delivery') }}</i>
                                        <svg style="width:16px !important" class="svg-icon-buttons" viewBox="0 0 20 20">
                                            <path
                                                d="M17.927,5.828h-4.41l-1.929-1.961c-0.078-0.079-0.186-0.125-0.297-0.125H4.159c-0.229,0-0.417,0.188-0.417,0.417v1.669H2.073c-0.229,0-0.417,0.188-0.417,0.417v9.596c0,0.229,0.188,0.417,0.417,0.417h15.854c0.229,0,0.417-0.188,0.417-0.417V6.245C18.344,6.016,18.156,5.828,17.927,5.828 M4.577,4.577h6.539l1.231,1.251h-7.77V4.577z M17.51,15.424H2.491V6.663H17.51V15.424z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>

                </div>

            </div><!-- col-4 -->
        </div><!-- col-4 -->
    </div><!-- col-4 -->
    </div><!-- col-4 -->








@endsection
@section('content')


    <!-- row -->
    <div class="row">

        <div class="col-xl-12">
            <div class="card mg-b-20">


                <div class="card-header pb-0">


                    <?php
    $avtSaleRate = App\Models\Avt::find(1);
    $avtSaleRate = $avtSaleRate->AVT;
                                                                        ?>

                    <form enctype="multipart/form-data" method="POST" role="search" name="form-name" id='formdata'
                        autocomplete="off">
                        {{ csrf_field() }}



                        <div style="border-radius: 10px" class="card p-3 my-3">





                            <?php $i = 0; ?>


                            <table class="table-responsive table table-bordered">
                                <thead class="table-dark">
                                    <col style="width:0.5%">
                                    <col style="width:2%">
                                    <col style="width:16%">
                                    <col style="width:28%">
                                    <col style="width:9%">
                                    <col style="width:9%">
                                    <col style="width:9%">
                                    <col style="width:9%">
                                    <col style="width:9%">
                                    <col style="width:9%">
                                    <col style="width:10%">
                                    <thead>
                                        <tr>
                                            <th>- </th>

                                            <th> # </th>
                                            <th>{{ __('home.productNo') }} </th>
                                            <th>{{ __('home.product') }}</th>
                                            <th> {{ __('home.productprice') }} </th>
                                            <th>{{ __('home.quantity') }}</th>
                                            <th>{{ __('home.price') }}</th>
                                            <th>{{ __('home.discount') }}</th>
                                            <th>{{ __('home.addedValue') }}</th>
                                            <th>{{ __('home.total') }}</th>
                                            <th>{{ __('home.operations') }}</th>
                                        </tr>
                                    </thead>
                                <tbody id="productsTableBody">
                                    <tr data-index="0">
                                        <td><input type="hidden" name="products[0][product_id]"
                                                class="product-id form-control"></td>
                                        <td class="align-middle text-center">1</td>
                                        <td class="text-start">
                                            <div class="d-flex gap-2">
                                                <input type="text" class="form-control product-code" placeholder="اختر منتج"
                                                    readonly>
                                                <button style="background-color: #FBA10F;font-size:13px;width:40px"
                                                    class="modal-effect btn btn-sm btn-info p-1" data-effect="effect-scale"
                                                    data-toggle="modal" type="button" onclick="openProductModal(0)"
                                                    title="تحديد">
                                                    <i style=" height: 100;

                                                             font-size:13px" class="las"></i>
                                                    <svg style="width: 16px;height:16px" xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-search" width="24" height="24"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                        <path d="M21 21l-6 -6"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="d-flex gap-2">
                                                <input type="text" class="form-control product-name" placeholder="اختر منتج"
                                                    readonly>
                                                <button type="button"
                                                    style="background-color: #FBA10F;font-size:13px;width:40px"
                                                    class="modal-effect btn btn-sm btn-info p-1" data-effect="effect-scale"
                                                    data-toggle="modal" onclick="openProductModal(0)" title="تحديد">
                                                    <i style=" height: 100;

                                                             font-size:13px" class="las"></i>
                                                    <svg style="width: 16px;height:16px" xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-search" width="24" height="24"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                        <path d="M21 21l-6 -6"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                        <td><input type="text" name="products[0][price]"
                                                class="form-control product-price" value="0" min="0"
                                                oninput="calculateTotals()"></td>
                                        <td><input type="text" name="products[0][quentity]"
                                                class="form-control product-quentity" oninput='calculateTotals()' value="1">
                                        </td>

                                        <td><input type="text" name="products[0][totalprice_withodtax]"
                                                class="form-control product-totalprice_withodtax" readonly value="0" min="0"
                                                oninput="calculateTotals()"></td>
                                        <td><input type="text" name="products[0][discound]" oninput='calculateTotals()'
                                                class="form-control product-discound" value="0" min="0"></td>
                                        <td><input type="text" name="products[0][tax]" readonly
                                                class="form-control product-tax" value="0" min="0"></td>
                                        <td><input type="text" class="form-control product-total" readonly value="0">
                                        </td>
                                        <td><button type="button" class="btn btn-danger btn-sm"
                                                onclick="removeRow(this)">{{ __(key: 'home.delete') }}</button></td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="button" class="addProductBtn" style="background-color: #419BB2 ;width:8%"
                                onclick="addRow()"> {{ __('supprocesses.addproduct') }}</button>
                            <br>
                            <div class="col-md-2"><label class="form-label">{{ __('home.discound_on_invoice') }}
                                </label><input type="text" id="discound_on_invoice" name="discound_on_invoice"
                                    oninput='calculateTotalDiscount()' class="form-control"></div>


                            <div class="row mt-3">


                                <div class="col-md-3"><label class="form-label">{{ __('home.the amount') }}</label><input
                                        readonly type="text" id="totalSum" name="totalSum"
                                        class="form-control parent-input">
                                </div>
                                <div class="col-md-3"><label class="form-label">{{ __('home.discount') }}
                                    </label><input type="text" id="totaldiscound" name="totaldiscound" readonly
                                        class="form-control parent-input">
                                </div>
                                <div class="col-md-3"><label class="form-label">{{ __('home.addedValue') }}
                                    </label><input type="text" id="totalTax" name="totalTax" readonly
                                        class="form-control parent-input"></div>
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('home.total') }}</label><input type="text"
                                        id="grandTotal" name="grandTotal" readonly class="form-control parent-input">
                                </div>
                            </div>



                            <br>

      <input type="text" class="form-control " name="show_invoice_number_update" id="show_invoice_number_update" value=0 title=" رقم الفاتورة " hidden>



                            <div class='row'>

                                <div class="col-lg-4 mg-lg-t-10">
                                    <label for="inputName" class="form-label">{{ __('home.chooseclient') }}</label>

                                    <select class="form-control select2" name="clientnamesearch" id="clientnamesearch">


                                        @foreach (App\Models\customers::get() as $customer)
                                            <option value="{{ $customer->id }}">
                                                {{ App::getLocale() == 'ar' ? $customer->name . ' - ' . $customer->tax_no : $customer->comp_name . ' - ' . $customer->tax_no}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div><!-- col-4 -->


                                <div class="col-lg-8 mg-t-10">
                                    <label for="inputName" class="form-label">{{ __('home.notesClient') }}
                                    </label>
                                    <input autocomplete="off" type="text" class="form-control parent-input" id="notes"
                                        name="notes" title="يرجي ادخال ملاحظات   " onchange="makenoteoninvoice()"
                                        value="- ">
                                </div>
                                <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <input type="text" hidden=true class="form-control" id="invoice_number"
                                        name="invoice_number" value="{{ $data['invoice_id'] ?? '' }}">

                                    <input type="text" hidden=true class="form-control" id="saveinvice" name="saveinvice"
                                        value=0>

                                    <input hidden=true class="form-control" id="branchs_id" name="branchs_id"
                                        value="{{Auth()->user()->branchs_id}}">
                                    <input hidden=true class="form-control" id="user_id" name="user_id"
                                        value="{{Auth()->user()->discount_allow_limit}}">
                                    <?php

    $rate_discount = App\Models\system_setting::find(1);
    $rate_system = $rate_discount->discount_on_invoice;
                                                                            ?>
                                    <input hidden=true class="form-control" id="rate_system" name="rate_system"
                                        value="{{$rate_system}}">
                                    <input hidden=true class="form-control" id="shownumberproduct" name="shownumberproduct"
                                        value="1">
                                </div>
                                <br>
                                <br>
                                <div class="d-flex justify-content-center">
                                    <button type='submit' style="background-color: #419BB2" id="saveInvoice"
                                        name="saveInvoice" class="btn btn-success p-1">
                                        {{ __('home.invoice_save') }}
                                        <svg style="width: 20px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                            <path fill="none"
                                                d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z">
                                            </path>
                                        </svg>
                                    </button>
                                    &nbsp;

                                    <!-- <a style="background-color: #419BB2;font-size:15px;width: 120px!important;height:30px"
                                            class="btn btn-success p-1 px-2 fw-bolder"
                                            id="pending_invoice">{{ __('home.pending_invoice') }}&nbsp; <svg style="width: 20px"
                                                class="svg-icon-buttons" viewBox="0 0 20 20">
                                                <path fill="none"
                                                    d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z">
                                                </path>
                                            </svg></i></a> -->

                                </div>
                    </form>

                </div>

                <input type="text" class="form-control " name="show_invoice_number" id="show_invoice_number"
                    title=" رقم الفاتورة " hidden>

                <center>
                    <div class=" justify-content-center" id="printdiv">
            <form action="{{ url(Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() . '/' . ($page = 'print_order_perice_to_customer')) }}" method="POST" role="search" autocomplete="off">
                                    {{ csrf_field() }}


                                    <div class="d-flex justify-content-center">
                                        <div class="row">
                                        <input class="form-control parent-input " name="OrderNoprint" id="OrderNoprint" title=" رقم الفاتورة "   hidden>
                                      
                                        <button style="background-color: #419BB2;font-size:17px" type="submit" class="btn btn-success mt-3 p-1 px-2">
                                            {{ __('home.print') }}
                                            <svg style="width: 22px !important" class="svg-icon-buttons" viewBox="0 0 20 20">
                                                <path d="M17.453,12.691V7.723 M17.453,12.691V7.723 M1.719,12.691V7.723 M18.281,12.691V7.723 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M7.309,13.312h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,13.312,7.309,13.312 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M16.625,6.066h-1.449V3.168c0-0.228-0.186-0.414-0.414-0.414H5.238c-0.228,0-0.414,0.187-0.414,0.414v2.898H3.375c-0.913,0-1.656,0.743-1.656,1.656v4.969c0,0.913,0.743,1.656,1.656,1.656h1.449v2.484c0,0.228,0.187,0.414,0.414,0.414h9.523c0.229,0,0.414-0.187,0.414-0.414v-2.484h1.449c0.912,0,1.656-0.743,1.656-1.656V7.723C18.281,6.81,17.537,6.066,16.625,6.066 M5.652,3.582h8.695v2.484H5.652V3.582zM14.348,16.418H5.652v-4.969h8.695V16.418z M17.453,12.691c0,0.458-0.371,0.828-0.828,0.828h-1.449v-2.484c0-0.228-0.186-0.414-0.414-0.414H5.238c-0.228,0-0.414,0.186-0.414,0.414v2.484H3.375c-0.458,0-0.828-0.37-0.828-0.828V7.723c0-0.458,0.371-0.828,0.828-0.828h13.25c0.457,0,0.828,0.371,0.828,0.828V12.691z M7.309,13.312h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,13.312,7.309,13.312M7.309,15.383h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,15.383,7.309,15.383 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555"></path>
                                            </svg>
                                        </button>
                                        
                                   
                                        
                                        
                                    </div>
                                    </div>
                                    <br>
                                           <a style="background-color: #419BB2;font-size:15px;width: 120px!important;height:30px"
                    class="btn btn-success p-1 px-2 fw-bolder"  id="generate_pdf" target="_blank" >{{ __('home.dwonloadpdf') }}&nbsp;<i class="fa-solid fa-download"></i></i></a>

                            </div>

                        </div>

                        <br>
                        <br />
                        </form>
                    </div>



                </center>

            </div>

        </div>

    </div>









    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    </div>
    <!--search  -->


    <div class="modal fade product-selection"
        style="background-color: rgba(0, 0, 0, 0)!important;color: rgba(0, 0, 0, 0)!important;" id="massagesave"
        name="massagesave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" dir='rtl' aria-hidden="true">
        <div class="modal-dialog modal-xl"
            style="background-color: rgba(0, 0, 0, 0)!important;color: rgba(0, 0, 0, 0)!important;" role="document">
            <div class="modal-content">

                <div class="modal-body" style="justify-content: center;">


                    <center><img style="width:250px;height:250px;" class="custom_img"
                            src="{{ asset('assets/admin/uploads/done.png') }}">

                    </center>




                </div>


            </div>


        </div>
    </div>

    </div>
    <input hidden=true class="form-control" id="phone" name="phone">



    <div class="modal fade product-selection" id="SearchProduct" name="SearchProduct" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" dir='rtl' aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">

                </div>
                <div class="modal-body">


                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                <label for="inputName" style="font-weight: bold" class="control-label parent-label">
                                    {{__('home.searchaboutproduct')}} </label>
                                <input autocomplete="off" dir="ltr" type="text" autofocus class="form-control parent-input"
                                    placeholder="{{ __('home.Search By Name or Product Number') }}" id="searchaboutproduct"
                                    name="searchaboutproduct" onkeyup="searchaboutproductfunction()" autofocus>
                            </div>
                            <div class="col-lg-3 mb-2">
                                <label for="inputName" class="control-label parent-label">{{ __('home.groups') }}</label>
                                <select style="width:100%!important" name="product_group" id="product_group"
                                    class="form-control select2">
                                    <!--placeholder-->
                                    @foreach (App\Models\products_group::get() as $section)
                                        <option value="{{ $section->id }}"> {{ $section->group_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive" id="ajax_responce_serarchDiv">
                            <table class="table text-md-nowrap text-center our-table" id="SearchProductTable" width="100%"
                                style="border: 2px solid rgba(0,0,0,.3);">
                                <col style="width:5%">
                                <col style="width:14%">
                                <col style="width:28%">
                                <col style="width:10%">
                                <col style="width:18%">
                                <col style="width:15%">
                                <col style="width:10%">

                                <thead>
                                    <tr>
                                        <th style="font-size: 15px" class="border-bottom-0">{{__('home.productNo')}}
                                        </th>
                                        <th style="font-size: 15px" class="border-bottom-0" style="text-align:center">
                                            {{__('home.product')}}
                                        </th>
                                        <th style="font-size: 15px" class="border-bottom-0" style="text-align:center">
                                            {{__('home.branch')}}
                                        </th>
                                        <th style="font-size: 15px" class="border-bottom-0" style="text-align:center">
                                            {{__('home.productlocation')}}
                                        </th>

                                        <th style="font-size: 15px" class="border-bottom-0">{{__('home.quantity')}}
                                        </th>
                                        <th style="font-size: 13px" class="border-bottom-0">
                                            {{__('home.purchaseproductwithouttax')}}
                                        </th>
                                        <th style="font-size: 13px" class="border-bottom-0">
                                            {{__('home.sellingproduct without tax')}}
                                        </th>
                                        <th style="font-size: 15px" class="border-bottom-0">{{__('home.Add')}}</th>



                                    </tr>
                                </thead>


                                <tbody class="">
                                    <?php $i = 0;
    $data = 'm'; ?>

                                    <?php $i++ ?>

                                    <tr>
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
                            <td id="tableData">- </td>
                            </tr>

                            </tbody>
                            </table>
                            <div>

                            </div>



                        </div>

                    </div>

                    <div class="modal-footer">
                        {{-- <button id="added_product" name="added_product" id="added_product"
                            class="btn btn-primary">{{__('home.confirm')}}</button>
                        --}}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('home.cancel')}}</button>
                    </div>

                </div>


            </div>
        </div>

    </div>

    <?php
    $avtSaleRate = App\Models\Avt::find(1);
    $avtSaleRate = $avtSaleRate->AVT;
                                        ?>
    <input type="text" class="form-control " id="avtValue" name="avtValue" value="{{$avtSaleRate}}" hidden>
    {{-- End Update ( 24/4/2023 ) --}}



    <div class="modal p-3" id="createcustomer">
        <div style="margin: 0 9% !important;" class="modal-dialog modal-dialog-centered modal-special" role="document">
            <div class="modal-content modal-content-demo p-3">
                <form>
                    <div class="modal-header">
                        <h6 class="modal-title"> {{ __('home.addnewcustomer') }} </h6><button aria-label="Close"
                            class="close close-special" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    {{ csrf_field() }}
                    <div class="row mb-1">
                        <div class="col-lg-4 col-md-6 col-md-4 mb-2">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label">
                                {{ __('supprocesses.name') }}</label>
                            <input style="height:32px" type="text" class="form-control parent-input" id="name" name="name"
                                title="{{ __('supprocesses.name') }}" required>
                        </div>

                        <div class="col-lg-4 col-md-3 mb-2 col-md-3">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label">
                                {{ __('supprocesses.phone') }}</label>
                            <input style="height:32px;" type="text" class="form-control parent-input" id="phone"
                                name="phone" onkeyup="phoneConvert()" title="{{ __('supprocesses.phone') }}">
                        </div>

                        <div class="col-lg-4 col-md-3 mb-2 col-md-3">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label">
                                {{ __('supprocesses.email') }}</label>
                            <input style="height:32px" type="text" class="form-control parent-input" id="email" name="email"
                                title="{{ __('supprocesses.email') }}" value='Example@gmail.com'>
                        </div>
                        <!-- <div class="col-lg-3 col-md-3">
                                        <label for="inputName" class="control-label parent-label"> {{ __('home.current balance') }} </label>
                                        <input type="text" class="parent-input form-control" id="balance" name="balance"
                                            title="يرجي ادخال الكمية  " value="{{ $data['customer']->Balance ?? '0' }}"
                                            >
                                    </div> -->
                    </div>

                    {{-- 2 --}}
                    <div class="row mb-1">
                        <div class="col-lg-3 col-md-3">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label">
                                {{ __('supprocesses.timeout_periodـinـdays') }}</label>
                            <input style="height:32px" type="text" class="form-control parent-input"
                                id="timeout_periodـinـdays" name="timeout_periodـinـdays"
                                title="{{ __('supprocesses.timeout_periodـinـdays') }}"
                                onkeyup="timeout_periodـinـdaysConvert()" value=30 required>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label">
                                {{ __('home.tax_number') }}</label>
                            <input style="height:32px" type="text" class="form-control parent-input" id="TaxـNumber"
                                name="TaxـNumber" onkeyup="TaxـNumberConvert()" title="{{ __('supprocesses.TaxـNumber') }}">
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label">
                                {{ __('home.CRN') }}</label>
                            <input style="height:32px" type="text" class="form-control parent-input" id="CRN" name="CRN"
                                onkeyup="TaxـNumberConvert() " value=0 title="{{ __('supprocesses.TaxـNumber') }}">
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label">
                                {{ __('supprocesses.credit_limit') }}</label>
                            <input style="height:32px" type="text" class="form-control parent-input" id="credit_limit"
                                name="credit_limit" onkeyup="credit_limitConvert()"
                                title="{{ __('supprocesses.credit_limit') }}" value=10000 required>
                        </div>

                        <div class="col-lg-2 col-md-3">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label">
                                {{ __('supprocesses.product_notes') }}</label>
                            <input style="height:32px" type="text" class="form-control parent-input" id="product_notes"
                                name="product_notes" title="{{ __('supprocesses.product_notes') }}" value='-'>
                        </div>

                    </div>
                    <div class="row mb-3">

                        <div class="col-lg-2">
                            <label for="inputName" class="control-label parent-label">
                                {{ __('home.city') }}</label>
                            <input type="text" class="form-control parent-input" id="city" name="city"
                                title="{{ __('supprocesses.product_notes') }}" required>
                        </div>
                        <div class="col-lg-2">
                            <label for="inputName" class="control-label parent-label">
                                {{ __('home.region') }}</label>
                            <input type="text" class="form-control parent-input" id="sub_city" name="sub_city"
                                title="{{ __('supprocesses.product_notes') }}" required>
                        </div>

                        <div class="col-lg-2">
                            <label for="inputName" class="control-label parent-label">
                                {{ __('home.StreetName') }}</label>
                            <input type="text" class="form-control parent-input" id="StreetName" name="StreetName"
                                title="{{ __('supprocesses.product_notes') }}" required>
                        </div>
                        <div class="col-lg-2">
                            <label for="inputName" class="control-label parent-label">
                                {{ __('home.plot_identification') }}</label>
                            <input type="text" class="form-control parent-input" id="plot_identification"
                                name="plot_identification" title="{{ __('supprocesses.product_notes') }}" required>
                        </div>
                        <div class="col-lg-2">
                            <label for="inputName" class="control-label parent-label">
                                {{ __('home.buildnumber') }}</label>
                            <input type="text" class="form-control parent-input" id="buildnumber" name="buildnumber"
                                title="{{ __('supprocesses.product_notes') }}" required>
                        </div>
                        <div class="col-lg-2">
                            <label for="inputName" class="control-label parent-label">
                                {{ __('home.postcode') }}</label>
                            <input type="text" class="form-control parent-input" id="postcode" name="postcode"
                                title="{{ __('home.postcode') }}" value='' required>
                        </div>


                    </div>
                    <br>
                    <div class="d-flex justify-content-center">
                        <button style="background-color: #419BB2" class="btn btn-primary p-1" data-dismiss="modal"
                            onclick="createnewcustomerajax()">
                            {{ __('supprocesses.save_data') }}
                            <svg style="width: 20px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                <path fill="none"
                                    d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z">
                                </path>
                            </svg>
                        </button>
                    </div>
            </div>

        </div>
    </div>
    </div>

    <div class="modal p-3" id="updateinvoicefromsale">
        <div style="margin: 0 9% !important;" class="modal-dialog modal-dialog-centered modal-special" role="document">
            <div class="modal-content modal-content-demo p-3">
                <form>
                    <div class="modal-header">
                        <h6 class="modal-title"> {{ __('home.updateinvoice') }} </h6><button aria-label="Close"
                            class="close close-special" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    {{ csrf_field() }}
                    <div class="row mb-1">
                        <div class="col-lg-6 col-md-6 col-md-4 mb-2">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label">
                                {{ __('home.enterinvoicenumber') }}</label>
                            <input style="height:32px" type="text" class="form-control parent-input"
                                id="updateinvoicebyidforsale" name="updateinvoicebyidforsale"
                                title="{{ __('supprocesses.name') }}" required>
                        </div>


                    </div>


                    <br>
                    <div class="d-flex justify-content-center">
                        <button style="background-color: #419BB2" class="btn btn-primary p-1" data-dismiss="modal"
                            id="updateinvoicebyidforsaleupdate">
                            {{ __('home.search') }}
                            <svg style="width: 20px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                <path fill="none"
                                    d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z">
                                </path>
                            </svg>
                        </button>
                    </div>
            </div>

        </div>
    </div>
    </div>


    <div class="modal p-3" id="updateinvoicebyidmodale">
        <div style="margin: 0 9% !important;" class="modal-dialog modal-dialog-centered modal-special" role="document">
            <div class="modal-content modal-content-demo p-3">
                <form>
                    <div class="modal-header">
                        <h6 class="modal-title"> {{ __('home.updateinvoicebyid') }} </h6><button aria-label="Close"
                            class="close close-special" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    {{ csrf_field() }}
                    <div class="row mb-1">
                        <div class="col-lg-6 col-md-6 col-md-4 mb-2">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label">
                                {{ __('home.enterinvoicenumber') }}</label>
                            <input style="height:32px" type="text" class="form-control parent-input" id="updateinvoicebyid"
                                name="name" title="{{ __('supprocesses.name') }}" required>
                        </div>


                    </div>


                    <br>
                    <div class="d-flex justify-content-center">
                        <button style="background-color: #419BB2" class="btn btn-primary p-1" data-dismiss="modal"
                            id="getinvoiceupdate">
                            {{ __('home.search') }}
                            <svg style="width: 20px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                <path fill="none"
                                    d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z">
                                </path>
                            </svg>
                        </button>
                    </div>
            </div>

        </div>
    </div>
    </div>



    <div class="modal p-3" id="createproduct">
        <div style="margin: 0 9% !important;" class="modal-dialog modal-dialog-centered modal-special" role="document">
            <div class="modal-content modal-content-demo p-3">
                <form>
                    <div class="modal-header">
                        <h6 class="modal-title"> {{ __('supprocesses.addproduct') }} </h6><button aria-label="Close"
                            class="close close-special" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    {{ csrf_field() }}
                    <br>
                    <label style="font-size:18px; color:red;font-weight:bold;">&nbsp;&nbsp;<input
                            style="font-size:16px; color:yellow;" type="checkbox" value=0
                            id="translate_status">&nbsp;&nbsp;{{__('home.active_translate')}}</label>
                    <br>


                    <div class="row mb-2">
                        <div class="col mb-2">
                            <label for="inputName" class="control-label parent-label">
                                {{ __('supprocesses.product_name_ar') }}</label>
                            <input autocomplete=off type="text" class="form-control parent-input" id="product_name_ar"
                                name="product_name_ar" title="{{ __('supprocesses.product_name_ar') }}"
                                onkeyup="translateNameToEnglish()" required>
                        </div>


                        <div class="col mb-2">
                            <label for="inputName" class="control-label parent-label">
                                {{ __('supprocesses.product_name_en') }}</label>
                            <input autocomplete=off type="text" class="form-control parent-input" id="product_name_en"
                                name="product_name_en" title="{{ __('supprocesses.product_name_en') }}"
                                onkeyup="translateNameToArbic()" required>
                        </div>


                        <div class="col mb-2">
                            <label for="inputName" class="control-label parent-label">
                                {{ __('supprocesses.product_code') }}</label>
                            <input type="text" class="form-control parent-input" id="product_code_create"
                                name="product_code_create" type="text" dir="ltr" onkeyup="convertToNumber()"
                                title="{{ __('supprocesses.product_code') }}">
                        </div>

                    </div>

                    {{-- 2 --}}
                    <div class="row mb-2">
                        <div class="col-lg-3 mb-2">
                            <label for="inputName"
                                class="control-label parent-label">{{ __('supprocesses.product_branch') }}</label>
                            <select name="Section" id="Section" class="form-control parent-input"
                                onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                                <!--placeholder-->
                                <option value="{{ Auth()->user()->branch->id }}"> {{ Auth()->user()->branch->name }}
                                </option>

                                @foreach (App\Models\branchs::get() as $section)
                                    @if(Auth()->user()->branch->id != $section->id)
                                        <option value="{{ $section->id }}"> {{ $section->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <label for="inputName" class="control-label parent-label">{{ __('home.groups') }}</label>
                            <select style="width:100%!important" name="product_group" id="product_group"
                                class="form-control select2">
                                <!--placeholder-->
                                @foreach (App\Models\products_group::get() as $section)
                                    <option value="{{ $section->id }}"> {{ $section->group_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <label for="inputName" class="control-label parent-label">{{ __('home.MAINproduct') }}</label>
                            <br>
                            <select style="width:100%!important" name="MAINproduct" class="form-control select2">
                                <!--placeholder-->
                                <option value=0> {{ __('home.noreplace') }}</option>


                            </select>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <label for="inputName" class="control-label parent-label">
                                {{ __('home.refnumber') }}</label>
                            <input type="text" class="form-control parent-input" id="refnumber" name="refnumber">
                        </div>
                        <select hidden name="unit" id="unit" class="form-control parent-input">
                            <!--placeholder-->
                            <div class="row">

                                <option value="piece"> {{ __('home.unitـpiece') }}</option>
                                <option value="box">{{ __('home.unit_box') }}</option>
                        </select>




                    </div>


                    {{-- 3 --}}

                    <div class="row">
                        <div class="col-lg-4">
                            <label for="inputName" class="control-label parent-label"> {{ __('home.purachesepice') }}
                            </label>
                            <input autocomplete="off" type="text" class="form-control parent-input" id="cost_price"
                                name="cost_price" value=0 onkeyup="convertToNumberpurchasersPrice()">
                        </div>
                        <div class="col-lg-4">
                            <label for="inputName" class="control-label parent-label" required>{{ __('home.salepice') }}
                            </label>
                            <input autocomplete="off" type="text" class="form-control parent-input" id="sale_price_create"
                                value=0 name="sale_price_create" onkeyup="convertToNumbersalePrice()">
                        </div>
                        <div class="col-lg-4">
                            <label for="inputName" class="control-label parent-label" required>{{ __('home.quantity') }}
                            </label>
                            <input autocomplete="off" type="text" class="form-control parent-input" id="quantity_create"
                                value=0 name="quantity_create" onkeyup="convertToNumbersalePrice()">
                        </div>

                    </div>



                    {{-- 5 --}}
                    <div class="row mb-2">
                        <div class="col-lg-4 mb-2" style="direction: ltr !important;">

                            <label for="inputName" class="control-label parent-label">
                                {{ __('supprocesses.product_location') }}</label>
                            <input dir="ltr" style="direction:LTR !important ;text-align:start!important;" type="text"
                                class="form-control parent-input" id="product_location_create"
                                name="product_location_create" value='-' title="{{ __('supprocesses.product_location') }}"
                                required>
                        </div>









                        {{-- 3 --}}





                        {{-- 5 --}}


                        <div class="col-lg-4 mb-2">
                            <label for="inputName" class="control-label parent-label">
                                {{ __('supprocesses.minmum_quantity_stock_alart') }}</label>
                            <input type="text" class="form-control parent-input" id="minmum_quantity_stock_alart"
                                name="minmum_quantity_stock_alart" onkeyup="minmum_quantity_stock_alartConvert()"
                                title="{{ __('supprocesses.minmum_quantity_stock_alart') }}" value=2 required>
                        </div>







                        <div class="col-lg-4 mb-2">
                            <label for="inputName" class="control-label parent-label">
                                {{ __('supprocesses.product_notes') }}</label>
                            <input type="text" class="form-control parent-input" id="product_notes" name="product_notes"
                                title="{{ __('supprocesses.product_notes') }}">
                        </div>

                        <div class="col-lg-4 mb-2">
                            <input type="text" class="form-control parent-input" id="product_name_en" name="product_name_en"
                                title=" {{ __('supprocesses.product_name_en') }}" hidden>
                        </div>

                    </div><br>

                    <br>
                    <div class="d-flex justify-content-center">
                        <button style="background-color: #419BB2" class="btn btn-primary p-1" data-dismiss="modal"
                            onclick="createnewproductajax()">
                            {{ __('supprocesses.save_data') }}
                            <svg style="width: 20px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                <path fill="none"
                                    d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z">
                                </path>
                            </svg>
                        </button>
                    </div>
            </div>

        </div>
    </div>

<div class="modal fade product-selection" id="operation_product" name="main_product" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" dir='rtl' aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="table-responsive" id="ajax_responce_operation_product_Div">


                </div>
            </div>

            <div class="modal-footer">
                {{-- <button id="added_product" name="added_product" id="added_product" class="btn btn-primary">{{__('home.confirm')}}</button>
                --}}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('home.cancel')}}</button>
            </div>

        </div>


    </div>
</div>

</div>




@endsection
@section('js')
    <!-- Internal Data tables -->

    <!-- Internal Data tables -->
    <!-- Internal Data tables -->
    <!--Internal  Datatable js -->
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Datatable js -->
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
    function replaceproduct(id) {
    branchs_id = $('#branchs_id').val();
    console.log(branchs_id)
    console.log(" {{URL::to('operationproducts')}}/" + branchs_id + "/" + id)
    jQuery.ajax({
        url: " {{URL::to('operationproducts')}}/" + branchs_id + "/" + id,
        type: 'get',
        dataType: 'html',
        cache: false,

        success: function(data) {
            console.log('done')
            $('#operation_product').modal().show();

            $("#ajax_responce_operation_product_Div").html(data);
        },
        error: function() {

        }
    });


}


    
let rowIndex = 1;

    $("#updateinvoicebyidforsaleupdate").click(function(e) {
        

        
            event.preventDefault();
            var url = " {{ URL::to('updateofficebyidforupdate') }}" + "/" + $('#updateinvoicebyidforsale').val();
            console.log(url)
            jQuery.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                cache: false,

             
                success: function(data) {


                

                    $('#show_invoice_number_update').val($('#updateinvoicebyidforsale').val())


                    console.log('++++++')
                    console.log(data)

                     document.getElementById("productsTableBody").innerHTML = "";

                    data['product'].forEach(async (product) => {
                        quentity = product['quantity']

 let index = rowIndex-1

                        if (quentity > 0) {
                                            let table = document.getElementById('productsTableBody');


            let row = `
            <tr data-index="${index}">
                <td><input type="hidden" name="products[${index}][product_id]" class="product-id form-control"></td>
                <td class="align-middle text-center">${index + 1}</td>

                <td class="text-start">
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control product-code" placeholder="اختر منتج" readonly>
                        <button type="button" class="btn btn-sm btn-info p-1"
                                style="background-color: #FBA10F;font-size:13px;width:40px"
                                onclick="openProductModal(${index})">   <svg style="width: 16px;height:16px" xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-search" width="24" height="24"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                            <path d="M21 21l-6 -6"></path>
                                                        </svg></button>
                    </div>
                </td>

                <td class="text-start">
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control product-name" placeholder="اختر منتج" readonly>
                        <button type="button" class="btn btn-sm btn-info p-1"
                                style="background-color: #FBA10F;font-size:13px;width:40px"
                                onclick="openProductModal(${index})">   <svg style="width: 16px;height:16px" xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-search" width="24" height="24"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                            <path d="M21 21l-6 -6"></path>
                                                        </svg></button>
                    </div>
                </td>

                <td><input type="text" name="products[${index}][price]"
                        class="form-control product-price" value="0" min="0" oninput="calculateTotals()"></td>

                <td><input type="text" name="products[${index}][quentity]"
                        class="form-control product-quentity" oninput='calculateTotals()' value=1></td>

                <td><input type="text" name="products[${index}][totalprice_withodtax]"
                        class="form-control product-totalprice_withodtax"  readonly value="0" min="0" oninput="calculateTotals()"></td>

                <td><input type="text" name="products[${index}][discound]"
                        class="form-control product-discound" value="0" oninput='calculateTotals()' min="0"></td>

                <td><input type="text" name="products[${index}][tax]" class="form-control product-tax" value="0" readonly></td>

                <td><input type="text" class="form-control product-total" readonly value="0"></td>

                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">{{ __('home.delete') }}</button>
                </td>
            </tr>`;
            
              table.insertAdjacentHTML("beforeend", row);

            

            
                        product_code = product['Product_Code']
                        product_name = product['product_name']
                        purchasingـprice = product['Unit_Price']
                        quantity = product['quantity']


                   let row_add = document.querySelector(`#productsTableBody tr[data-index='${index}']`);
                   row_add.querySelector('.product-id').value = product['id'];
                   row_add.querySelector('.product-name').value = product_name;
                   row_add.querySelector('.product-code').value = product_code;
                   row_add.querySelector('.product-price').value = purchasingـprice;
                   row_add.querySelector('.product-discound').value = 0;
                   row_add.querySelector('.product-quentity').value = quentity;

         index = rowIndex++; // 👈 يزيد دايمًا

                        }

                       window.currentRow = index;

                    });
                   try {
    $('#clientnamesearch').append(
        $('<option>', { value: data['customer']['id'], text:data['customer']['name'] })
    );
    $('#clientnamesearch').val(data['customer']['id']).trigger('change');
} catch (e) {
    console.error(e);
}
console.log('n')
console.log(data['customer']['name'])

              calculateTotals()
            window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" });

           document.getElementById('printdiv').hidden = true
                document.getElementById('saveInvoice').hidden = false



                },
                error: function(response) {
                    alert("{{ __('home.sorryerror') }}")

                }
                
            })
            
       
    });




        function createnewproductajax() {
            console.log('+++++++++++++++++++++++++++++++++create customer ++++++++++++++++++++++++++++++++');
            var url = " {{ URL::to('addnewProductajax') }}";
            console.log($('#product_notes').val())
            console.log($('#minmum_quantity_stock_alart').val())
            console.log($('#product_name_ar').val())
            console.log($('#product_code').val())
            console.log($('#Section').val())
            console.log($('#unit').val())
            console.log($('#product_location').val())
            var token_search = $("#token_search").val();
            if ($('#product_name_ar').val() == '') {
                alert("{{ __('supprocesses.product_name_ar') }}")
            } else if ($('#product_location_create').val() == '') {
                alert("{{ __('supprocesses.product_location') }}")
            } else {


                $.ajax({
                    url: url,
                    type: 'post',
                    cache: false,

                    data: {
                        _token: token_search,
                        product_notes: $('#product_notes').val() ?? '-',
                        minmum_quantity_stock_alart: $('#minmum_quantity_stock_alart').val(),
                        product_name_ar: $('#product_name_ar').val(),
                        product_name_en: $('#product_name_en').val(),
                        product_code: $('#product_code_create').val(),
                        Section: $('#Section').val(),
                        unit: $('#unit').val(),
                        product_location: $('#product_location_create').val(),
                        refnumber: $('#refnumber').val(),
                        product_group: $('#product_group').val(),
                        numberofpice: $('#quantity_create').val(),
                        cost_price: $('#cost_price').val(),
                        sale_price_create: $('#sale_price_create').val(),


                        success: function (data) {
                            $('#createcustomer').modal('hide');
                            $('#quantity_create').val(0)
                            $('#cost_price').val(0)
                            $('#sale_price_create').val(0)
                            $('#product_location').val('');
                            $('#product_name_ar').val('');
                            $('#product_notes').val('')
                            $('#product_code').val('')
                            $('#massagesave').modal().show();
                            setTimeout(() => {
                                $('#massagesave').modal('hide');

                            }, 1000);

                        },
                    }
                });







            }


        }

        function translateNameToArbic() {
            const checkbox = document.getElementById('translate_status');

            if (checkbox.checked) {


                var wordEnglish = $('#product_name_en').val();

                jQuery.ajax({
                    url: "https://translate.googleapis.com/translate_a/single?client=gtx&dt=t&sl=en&tl=ar&q=" +
                        wordEnglish,
                    type: 'get',
                    cache: false,

                    success: function (request_result) {
                        $('#product_name_ar').val(request_result[0][0][0])
                    },
                    error: function () {

                    }
                });

            }

        }





        $('select[name="numbershowstatus"]').on('change', function () {
            console.log('AJAX load   work 0000');

            var selectCustomer = $(this).val();
            $('#shownumberproduct').val(selectCustomer)


        })

        function translateNameToEnglish() {
            const checkbox = document.getElementById('translate_status');

            if (checkbox.checked) {


                var wordarbic = $('#product_name_ar').val();

                jQuery.ajax({
                    url: "https://translate.googleapis.com/translate_a/single?client=gtx&dt=t&sl=ar&tl=en&q=" +
                        wordarbic,
                    type: 'get',
                    cache: false,

                    success: function (request_result) {
                        $('#product_name_en').val(request_result[0][0][0])
                    },
                    error: function () {

                    }
                });

            }

        }


        function createnewcustomerajax() {


            console.log('+++++++++++++++++++++++++++++++++create customer ++++++++++++++++++++++++++++++++');
            var url = " {{ URL::to('createnewcustomerajax') }}";

            var token_search = $("#token_search").val();
            if ($('#name').val() == '') {
                alert("{{ __('home.enterclienname') }}")
            } else if ($('#buildnumber').val() == '') {
                alert("{{ __('home.buildnumber') }}")
            } else if ($('#plot_identification').val() == '') {
                alert("{{ __('home.plot_identification') }}")
            } else if ($('#postcode').val() == '') {
                alert("{{ __('home.postcode') }}")
            } else if ($('#StreetName').val() == '') {
                alert("{{ __('home.StreetName') }}")
            } else if ($('#city').val() == '') {
                alert("{{ __('home.city') }}")
            } else if ($('#sub_city').val() == '') {
                alert("{{ __('home.sub_city') }}")
            } else if ($('#TaxـNumber').val().length != 15) {
                alert('يجب ان يكون رقم الضريبي مكون من 15 رقم     \n    The tax number must consist of 15 digits')
            } else {

                $('#createcustomer').modal().hide();

                $.ajax({
                    url: url,
                    type: 'post',
                    cache: false,

                    data: {
                        _token: token_search,
                        name: $('#name').val(),
                        tax_no: $('#TaxـNumber').val(),
                        Balance: 0,
                        city: $('#city').val() ?? "client address",
                        phone: $('#phone').val(),
                        email: $('#email').val(),
                        notes: $('#product_notes').val(),
                        Limit_credit: $('#credit_limit').val(),
                        grace_period_in_days: $('#timeout_periodـinـdays').val(),
                        buildnumber: $('#buildnumber').val(),
                        plot_identification: $('#plot_identification').val(),
                        StreetName: $('#StreetName').val(),
                        sub_city: $('#sub_city').val(),
                        postcode: $('#postcode').val(),
                        CRN: $('#CRN').val(),
                    },


                    success: function (data) {
                        $('#phone').val('');
                        $('#TaxـNumber').val('');
                        $('#name').val('')
                        console.log('seccusss12111');
                        console.log(data)
                        $('#clientnamesearch').append($('<option >', {
                            value: data['id'],
                            text: data['name'] + data['tax_no']
                        }));


                        $('#massagesave').modal().show();
                        setTimeout(() => {
                            $('#massagesave').modal('hide');

                        }, 500);
                    },
                    error: function (response) {
                        alert("{{ __('home.sorryerror') }}")

                    }
                });







            }



        }
        $("#reciptprinter").click(function (e) {
            var url = " {{ URL::to('reciptprinter') }}";
            var token_search = $("#token_search").val();
            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                dataType: 'html',
                data: {
                    _token: token_search,
                    show_invoice_number: $('#show_invoice_number').val(),
                },
                success: function (data) {
                    console.log(data)
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
                error: function (response) {
                    console.log(response)
                    alert("{{ __('home.sorryerror') }}")

                }
            });
        });
        $(document).ready(function () {
            document.getElementById('printdiv').hidden = true

        })



        $("#formdata").on('submit', function (e) {
            e.preventDefault();
            $('#massagesave').modal().show();

            var url = " {{ URL::to('save_invoice_qutation') }}";
            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: new FormData(this),
                success: function (data) {
                    $('#show_invoice_number').val(data);

                    $('#OrderNoprint').val(data);
                    var a = document.getElementById('generate_pdf'); //or grab it by tagname etc
                    a.href = " {{ URL::to('generate_pdf_qoute') }}" + "/" + $('#OrderNoprint').val();


                    if (data >= 1) {


                        document.getElementById('printdiv').hidden = false
                        document.getElementById('saveInvoice').hidden = true


                        setTimeout(() => {
                            $('#massagesave').modal('hide');

                        }, 1000);
                    } else {
                        alert("{{ __('home.sorryerror') }}")
                    }


                },
                error(respose) {
                    console.log(respose)
                }



            })

        })

        function removeRow(btn) {
            btn.closest('tr').remove();
        }

        let rowCounter = 0;

        function openProductModal(index) {
            window.currentRow = index;
            $('#SearchProduct').modal().show();
            $('#searchaboutproduct').focus();

        }

        function addRow() {
            let table = document.getElementById('productsTableBody');
            let index = table.querySelectorAll('tr').length;

            let row = `
            <tr data-index="${index}">
                <td><input type="hidden" name="products[${index}][product_id]" class="product-id form-control"></td>
                <td class="align-middle text-center">${index + 1}</td>

                <td class="text-start">
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control product-code" placeholder="اختر منتج" readonly>
                        <button type="button" class="btn btn-sm btn-info p-1"
                                style="background-color: #FBA10F;font-size:13px;width:40px"
                                onclick="openProductModal(${index})">   <svg style="width: 16px;height:16px" xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-search" width="24" height="24"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                            <path d="M21 21l-6 -6"></path>
                                                        </svg></button>
                    </div>
                </td>

                <td class="text-start">
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control product-name" placeholder="اختر منتج" readonly>
                        <button type="button" class="btn btn-sm btn-info p-1"
                                style="background-color: #FBA10F;font-size:13px;width:40px"
                                onclick="openProductModal(${index})">   <svg style="width: 16px;height:16px" xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-search" width="24" height="24"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                            <path d="M21 21l-6 -6"></path>
                                                        </svg></button>
                    </div>
                </td>

                <td><input type="text" name="products[${index}][price]"
                        class="form-control product-price" value="0" min="0" oninput="calculateTotals()"></td>

                <td><input type="text" name="products[${index}][quentity]"
                        class="form-control product-quentity" oninput='calculateTotals()' value=1></td>

                <td><input type="text" name="products[${index}][totalprice_withodtax]"
                        class="form-control product-totalprice_withodtax"  readonly value="0" min="0" oninput="calculateTotals()"></td>

                <td><input type="text" name="products[${index}][discound]"
                        class="form-control product-discound" value="0" oninput='calculateTotals()' min="0"></td>

                <td><input type="text" name="products[${index}][tax]" class="form-control product-tax" value="0" readonly></td>

                <td><input type="text" class="form-control product-total" readonly value="0"></td>

                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">{{ __('home.delete') }}</button>
                </td>
            </tr>`;

            table.insertAdjacentHTML("beforeend", row);
            window.currentRow = index;
            $('#searchaboutproduct').focus();

            $('#SearchProduct').modal().show();
            $('#searchaboutproduct').focus();

        }

        $("#printReciept").click(function (e) {
            var url = " {{ URL::to('printInvoice') }}";
            var token_search = $("#token_search").val();
            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                dataType: 'html',
                data: {
                    _token: token_search,
                    show_invoice_number: $('#show_invoice_number').val(),
                },
                success: function (data) {
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
                error: function (response) {
                    console.log(response)
                    alert("{{ __('home.sorryerror') }}")

                }
            });
        });

        function calculateTotalDiscount() {
            avtsale = $('#avtValue').val();
            totalbefore_discount = document.getElementById('totalSum').value;
            let discountTotal = 0;


            document.querySelectorAll('#productsTableBody tr').forEach(r => {

                let discound = parseFloat(r.querySelector('.product-discound').value) || 0;
                discountTotal += discound;
            });
            discountTotal += $('#discound_on_invoice').val() * 1;

            let taxTotal = (totalbefore_discount - discountTotal) * avtsale;
            let grand = (totalbefore_discount - discountTotal) + taxTotal;
            document.getElementById('totaldiscound').value = discountTotal.toFixed(2);
            document.getElementById('totalTax').value = taxTotal.toFixed(2);
            document.getElementById('grandTotal').value = grand.toFixed(2);

        }

        function calculateTotals() {
            let total = 0,
                taxTotal = 0,
                discountTotal = 0,
                grand = 0;
            avtsale = $('#avtValue').val();

            document.querySelectorAll('#productsTableBody tr').forEach(r => {
                let qty = parseFloat(r.querySelector('.product-quentity').value) || 0;
                let price = parseFloat(r.querySelector('.product-price').value) || 0;
                let discound = parseFloat(r.querySelector('.product-discound').value) || 0;
                let subtotal = price * qty;
                let tax = ((price * qty) - discound) * avtsale;
                let totalRow = subtotal - discound + tax;
                r.querySelector('.product-totalprice_withodtax').value = subtotal.toFixed(2);
                r.querySelector('.product-tax').value = tax.toFixed(2);
                r.querySelector('.product-total').value = totalRow.toFixed(2);
                total += subtotal;
                taxTotal += tax;
                grand += totalRow;
                discountTotal += discound;
            });
            document.getElementById('totalSum').value = total.toFixed(2);
            document.getElementById('totaldiscound').value = discountTotal.toFixed(2);
            document.getElementById('totalTax').value = taxTotal.toFixed(2);
            document.getElementById('grandTotal').value = grand.toFixed(2);
        }

        function searchaboutproductfunction() {
            searchtext = $('#searchaboutproduct').val();
            branchs_id = $('#branchs_id').val();
            var token_search = $("#token_search").val();

            jQuery.ajax({
                url: "{{ URL::to('searchChooseProductpaginatenewSaleBypost')}}",
                type: 'post',
                cache: false,
                dataType: 'html',
                data: {
                    "_token": token_search,
                    "searchtext": searchtext,
                    "branchs_id": branchs_id,
                    "currentrow": window.currentRow,
                },
                success: function (data) {
                    $("#ajax_responce_serarchDiv").html(data);
                },

            });

        }

        $('#SearchProduct').on('show.bs.modal', function (event) {
            searchtext = '';
            branchs_id = $('#branchs_id').val();
            var token_search = $("#token_search").val();

            jQuery.ajax({
                url: "{{ URL::to('searchChooseProductpaginatenewSaleBypost')}}",
                type: 'post',
                cache: false,
                dataType: 'html',
                data: {
                    "_token": token_search,
                    "searchtext": searchtext,
                    "branchs_id": branchs_id,
                    "currentrow": window.currentRow,
                },
                success: function (data) {
                    $("#ajax_responce_serarchDiv").html(data);
                },

            });

        });
        $(document).on('click', '#ajax_pagination_in_search a', function (e) {
            e.preventDefault();
            var search_by_text = $("#searchaboutproduct").val();
            var url = $(this).attr("href");
            var token_search = $("#token_search").val();
            branchs_id = $('#branchs_id').val();

            jQuery.ajax({
                url: url,
                type: 'post',
                cache: false,
                dataType: 'html',
                data: {
                    "_token": token_search,
                    "searchtext": search_by_text,
                    "branchs_id": branchs_id,
                },
                success: function (data) {
                    $("#ajax_responce_serarchDiv").html(data);
                },
                error: function () {

                }
            });
        });
    const input = document.getElementById('searchaboutproduct');

input.addEventListener('blur', function () {
    setTimeout(() => input.focus(), 0);
});
        function chooseProduct(code, productcode, name, cost, sale_price, location, availablequantity, currentrow) {
            console.log(window.currentRow);

            let row = document.querySelector(`#productsTableBody tr[data-index='${currentrow}']`);
            row.querySelector('.product-id').value = code;
            row.querySelector('.product-name').value = name;
            row.querySelector('.product-code').value = productcode;
            row.querySelector('.product-price').value = sale_price;
            row.querySelector('.product-discound').value = 0;

            calculateTotals()
            window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" });

        }
    </script>

@endsection