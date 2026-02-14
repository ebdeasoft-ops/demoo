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
{{ __('home.Daily_record') }}@stop
@endsection
@section('page-header')
<div class="main-parent">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between parent-heading">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('home.Daily_record') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
                </span>
            </div>
        </div>
        <div class="row">
            
             <button  style=" height: 40px;font-weight:400 !important;
                                                 width: 100px;
                                                 font-size:13px" class="modal-effect btn btn-sm btn-info  button-eng" data-effect="effect-scale" data-toggle="modal" href="#deleteinvoicebyidmodale" title="تحديد"><i
                                    class="las"> حذف القيد  </i>
                                        <svg style="width:16px !important" class="svg-icon-buttons" viewBox="0 0 20 20">
                                            <path d="M17.927,5.828h-4.41l-1.929-1.961c-0.078-0.079-0.186-0.125-0.297-0.125H4.159c-0.229,0-0.417,0.188-0.417,0.417v1.669H2.073c-0.229,0-0.417,0.188-0.417,0.417v9.596c0,0.229,0.188,0.417,0.417,0.417h15.854c0.229,0,0.417-0.188,0.417-0.417V6.245C18.344,6.016,18.156,5.828,17.927,5.828 M4.577,4.577h6.539l1.231,1.251h-7.77V4.577z M17.51,15.424H2.491V6.663H17.51V15.424z"></path>
                                        </svg>
                                    </button>
                                    
                                    
                                    &nbsp;
           <button  style=" height: 40px;font-weight:400 !important;
                                                 width: 100px;
                                                 font-size:13px" class="modal-effect btn btn-sm btn-info  button-eng" data-effect="effect-scale" data-toggle="modal" href="#updateinvoicebyidmodale" title="تحديد"><i
                                    class="las"> تعديل القيد اليومي</i>
                                        <svg style="width:16px !important" class="svg-icon-buttons" viewBox="0 0 20 20">
                                            <path d="M17.927,5.828h-4.41l-1.929-1.961c-0.078-0.079-0.186-0.125-0.297-0.125H4.159c-0.229,0-0.417,0.188-0.417,0.417v1.669H2.073c-0.229,0-0.417,0.188-0.417,0.417v9.596c0,0.229,0.188,0.417,0.417,0.417h15.854c0.229,0,0.417-0.188,0.417-0.417V6.245C18.344,6.016,18.156,5.828,17.927,5.828 M4.577,4.577h6.539l1.231,1.251h-7.77V4.577z M17.51,15.424H2.491V6.663H17.51V15.424z"></path>
                                        </svg>
                                    </button>

                 
</div>
    </div>
    <!-- breadcrumb -->
    @endsection
    @section('content')
    @if (session()->has('nodataprint'))
    <div class="alert alert-warning  alert-dismissible fade show" role="alert">
        <br>
        <strong>{{ __('home.nodataprint') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
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

                    <form enctype="multipart/form-data" method="POST" role="search" name="form-name" id='formdata' autocomplete="off">
                        {{ csrf_field() }}


                        <input type="hidden" id="token_search" value="{{ csrf_token() }}">
<?php
$financial_accounts=App\Models\financial_accounts::get()

?>

                        <div class="row">
                            <div class="col-lg-2 mg-t-20 mg-lg-t-0" id="type">
                                <p class="mg-b-10">{{__('home.saerch_by_numberaccount_or_name')}} </p>
                                <select class="form-control select2" name="clientnamesearch_1" id="clientnamesearch_1" required>
                                    <option value="-" selected>
                                        {{ $type ?? __('home.acount_name') }}
                                    </option>

                                    @foreach ($financial_accounts as $section)
                                    <option value="{{ $section->id }}"> {{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div><!-- col-4 -->

                   

                            <div class="col-lg-2">
                                <label for="inputName" class="control-label parent-label"> {{ __('home.credit') }}
                                </label>
                                <input type="text" class="form-control parent-input" id="debit_1" name="debit_1" value=0 title="يرجي ادخال الكمية  " required onkeyup="moneyconvertToNumber()">
                            </div>
   <div class="col-lg-2">
                                <label for="inputName" class="control-label parent-label"> {{ __('home.debit') }}
                                </label>
                                <input type="text" class="form-control parent-input" id="credit_1" name="credit_1" value=0 title="يرجي ادخال الكمية  " required onkeyup="moneyconvertToNumber()">
                            </div>
    <div class="col-lg-2 parent-label" id="start_at">
                                <label for="exampleFormControlSelect1"> {{ __('home.exportTime') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div><input class="form-control parent-input fc-datepicker" value="{{ $start_at ?? '' }}" name="date" id="date" placeholder="YYYY-MM-DD" type="text" required>
                                </div>
                            </div>

                       
                            <div class="col-lg-2">
                                <label for="inputName" class="control-label parent-label">{{ __('home.notesClient') }} </label>
                                <input type="text" class="parent-input form-control" id="notes_1" name="notes_1" title="يرجي ادخال ملاحظات  ">
                            </div>
                            <div class="col-lg-2">
                                <label> {{__('home.attachments')}}</label>
                                <input autocomplete="off" onchange="readURL(this)" type="file" id="attachments_1" name="attachments_1" class="form-control">

                            </div>
                        </div>


                                        <input type="number" class="form-control " name="record_id" id="record_id" value=0 title=" رقم الفاتورة " readonly required hidden>

                            <br>

                        </div>

                        <div class="d-flex justify-content-center">

                            
                             <button type='submit' class="btn btn-success print-style p-1" id="button_1">
                                {{ __('home.Add') }}
                                <svg style="width: 20px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                    <path fill="none" d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z"></path>
                                </svg>
                            </button>
                            
                            
                      

                            <br>

                        </div>
                    </form>
                    <br>

            






      
      
            <div style="border-radius: 10px" class="card mg-b-20">
                <div class="card-header pb-0 p-4">
                    <div class="d-flex justify-content-between">
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table text-md-nowrap text-center our-table" width="100%" style="border: 2px solid rgba(0,0,0,.3);">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">{{ __('home.decoumentNo') }}</th>

                                    <th class="border-bottom-0"> {{ __('home.acount_name') }}</th>
                                    <th class="border-bottom-0">{{ __('home.credit') }}</th>
                                    <th class="border-bottom-0">{{ __('home.debit') }}</th>
                                    <th  class="border-bottom-0">{{ __('home.operations') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>

                            </tbody>
                        </table>
                        <br>

                        <div class="d-flex justify-content-center">


                            <div class="row  d-flex justify-content-end mt-3">
                                <form action="{{ '/' . ($page = 'print_daily_record') }}" method="POST" role="search" autocomplete="off">
                                    {{ csrf_field() }}



                                    <div class='col ' id="printdiv">
                                   
                                        <input type="number" class="form-control " name="record_id_print" id="record_id_print" value=0 title=" رقم الفاتورة " readonly required hidden>

        <button type='submit' class="btn btn-success p-1 px-2 fw-bolder" style="background-color: #419BB2;font-size:15px;width: 120px!important;height:30px" id="save_1">
                                {{ __('home.savedecoument') }}
                                <svg style="width: 20px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                    <path fill="none" d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z"></path>
                                </svg>
                            </button>
                            
                            
                            &nbsp;
                            &nbsp;
                                        <button style="background-color: #419BB2;font-size:15px;width: 120px!important;height:30px" type="submit" id='print_record' class="btn btn-success p-1 px-2 fw-bolder">
                                            {{ __('home.print') }}
                                            <svg style="width: 15px !important" class="svg-icon-buttons" viewBox="0 0 20 20">
                                                <path d="M17.453,12.691V7.723 M17.453,12.691V7.723 M1.719,12.691V7.723 M18.281,12.691V7.723 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M7.309,13.312h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,13.312,7.309,13.312 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M16.625,6.066h-1.449V3.168c0-0.228-0.186-0.414-0.414-0.414H5.238c-0.228,0-0.414,0.187-0.414,0.414v2.898H3.375c-0.913,0-1.656,0.743-1.656,1.656v4.969c0,0.913,0.743,1.656,1.656,1.656h1.449v2.484c0,0.228,0.187,0.414,0.414,0.414h9.523c0.229,0,0.414-0.187,0.414-0.414v-2.484h1.449c0.912,0,1.656-0.743,1.656-1.656V7.723C18.281,6.81,17.537,6.066,16.625,6.066 M5.652,3.582h8.695v2.484H5.652V3.582zM14.348,16.418H5.652v-4.969h8.695V16.418z M17.453,12.691c0,0.458-0.371,0.828-0.828,0.828h-1.449v-2.484c0-0.228-0.186-0.414-0.414-0.414H5.238c-0.228,0-0.414,0.186-0.414,0.414v2.484H3.375c-0.458,0-0.828-0.37-0.828-0.828V7.723c0-0.458,0.371-0.828,0.828-0.828h13.25c0.457,0,0.828,0.371,0.828,0.828V12.691z M7.309,13.312h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,13.312,7.309,13.312M7.309,15.383h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,15.383,7.309,15.383 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555"></path>
                                            </svg>
                                        </button>






                                    </div>


                                </form>
                            </div>
                            <br>
                        </div>
                        <br />
                        
                           <div class="col-xl-12">
            <div class="card mg-م-20">
                      <div id="AVT_Div2" class="col-lg-2">
                     <label for="inputName" class="control-label parent-label"> {{ __('home.decoumentNo') }}</label>
                     <input type="number"  class="form-control parent-input" id="search_by_decoumentNo" name="search_by_decoumentNo" onkeyup="search_by_decoumentNo_function()" title="{{ __('supprocesses.TaxـNumber') }}">
                  </div>
                                    <div class="table-responsive " id="ajax_responce_allinvoicesDiv">
                                    <br>

                                    
                                        <div>



                                        </div>
                                        <br>

                                    </div>
                                </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- row closed -->
    </div>
    <!-- Container closed -->
</div>
<!-- main-content closed -->
</div>
<!-- edit -->
<div class="modal fade" id="increaseProduct" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">    <div style="margin: 5% !important;" class="modal-dialog modal-special" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('home.updatedecoument') }}</h5>
                <button type="button" class="close choose-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="hidden" name="transactionId" id="transactionId" value="">

                    </div>



            <div class="row">
          <div class="col-lg-4">
                                <p for="inputName" class="control-label parent-label"> {{__('home.saerch_by_numberaccount_or_name')}}</p>
                                <select style="width:100%!important" class="form-control select2" name="clientnamesearch_update" id="clientnamesearch_update" >
                                <option value="0"> {{__('home.acount_name')}}</option>
                                    @foreach (App\Models\financial_accounts::get() as $section)
                                    <option value="{{ $section->id }}"> {{ $section->name }} ({{ $section->account_number }})</option>
                                    @endforeach
                                </select>
                            </div>
          <div class="col-lg-4">
                                <label for="inputName" class="control-label parent-label"> {{ __('home.credit') }}
                                </label>
                                <input type="text" class="form-control parent-input" id="debit_update" name="debit_update" value=0 title="يرجي ادخال الكمية  " required onkeyup="set_zero_write_depit()">
                            </div>
   <div class="col-lg-4">
                                <label for="inputName" class="control-label parent-label"> {{ __('home.debit') }}
                                </label>
                                <input type="text" class="form-control parent-input" id="credit_update" name="credit_update" value=0 title="يرجي ادخال الكمية  " required onkeyup="set_zero_write_credit()">
                            </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('home.cancel')}}</button>
            <button id="updatedecoument" name="updatedecoument" data-dismiss="modal" class="btn btn-danger">{{ __('home.confirm') }}</button>
        </div>

        </form>
    </div>
</div>
</div>



  <div class="modal p-3" id="updateinvoicebyidmodale">
        <div style="margin: 0 9% !important;" class="modal-dialog modal-dialog-centered modal-special" role="document">
            <div class="modal-content modal-content-demo p-3">
                <form>
                    <div class="modal-header">
                        <h6 class="modal-title"> {{ __('home.update_decument') }} </h6><button aria-label="Close" class="close close-special" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    {{ csrf_field() }}
                    <div class="row mb-1">
                        <div class="col-lg-6 col-md-6 col-md-4 mb-2">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label"> {{ __('home.decoumentNo') }}</label>
                            <input style="height:32px" type="text" class="form-control parent-input" id="updateinvoicebyid" name="name" title="{{ __('supprocesses.name') }}" required>
                        </div>


                    </div>


                    <br>
                    <div class="d-flex justify-content-center">
                        <button style="background-color: #419BB2" class="btn btn-primary p-1" data-dismiss="modal" id="getinvoiceupdate">
                            {{ __('home.search') }}
                            <svg style="width: 20px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                <path fill="none" d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z"></path>
                            </svg>
                        </button>
                    </div>
            </div>

        </div>
    </div>
</div>
      
      
        <div class="modal p-3" id="deleteinvoicebyidmodale">
        <div style="margin: 0 9% !important;" class="modal-dialog modal-dialog-centered modal-special" role="document">
            <div class="modal-content modal-content-demo p-3">
                <form>
                    <div class="modal-header">
                        <h6 class="modal-title"> {{ __('home.Are_you_sure_delete') }} </h6><button aria-label="Close" class="close close-special" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    {{ csrf_field() }}
                    <div class="row mb-1">
                        <div class="col-lg-6 col-md-6 col-md-4 mb-2">
                            <label style="font-size: 12px;" for="inputName" class="control-label parent-label"> {{ __('home.decoumentNo') }}</label>
                            <input style="height:32px" type="text" class="form-control parent-input" id="deleteinvoicebyid" name="name" title="{{ __('supprocesses.name') }}" required>
                        </div>


                    </div>


                    <br>
                            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('home.cancel') }}</button>
                <button id="delete_quotation_function" name="delete_quotation_function" data-dismiss="modal" class="btn btn-danger">{{ __('home.confirm') }}</button>
            </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('home.Are_you_sure_delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ url(Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() . '/' . ($page = 'updatePurchase')) }}" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    <input style="height:32px" type="text" class="form-control parent-input" id="delete_record_byid" name="delete_record_byid" title="{{ __('supprocesses.name') }}" hidden>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">{{ __('home.Are_you_sure_delete') }}</label>
                    </div>
            </div>
            <div class="modal-footer">
                <button id="delete_record_by_id" name="delete_record_byid" class="btn btn-primary">{{ __('home.confirm') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('home.cancel') }}</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<!-- Internal Data tables -->

<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
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
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)

        var id = button.data('id')
      
        var modal = $(this)
        modal.find('.modal-body #delete_record_byid').val(id);


    })
        $("#delete_quotation_function").click(function(e) {

console.log( " {{URL::to('get_And_Delete_delyrecord')}}"   + "/" + $('#deleteinvoicebyid').val())
            var selectCustomer = $('#delete_id').val();
        if (selectCustomer != '') {
            $.ajax({
                url: " {{URL::to('get_And_Delete_delyrecord')}}"   + "/" + $('#deleteinvoicebyid').val(),
                type: "GET",
                dataType: "html",
                success: function(products) {
                location.reload();

                },
            });
        } else {
        
        }

        });
          
 $("#delete_record_by_id").click(function(e) {
            event.preventDefault();
            var url = " {{ URL::to('delete_record_by_id') }}" + "/" + $('#delete_record_byid').val();
            console.log(url)
            jQuery.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                cache: false,

                    success: function(data) {
                        
                        console.log('----------------------------------------------------')
                        console.log(data)
                        console.log('----------------------------------------------------')
                       
                        let table = document.getElementById("example");
                        var tableHeaderRowCount = 1;

                        var rowCount = table.rows.length;

                        for (var i = tableHeaderRowCount; i < rowCount; i++) {
                            table.deleteRow(tableHeaderRowCount);
                        }
                        let row = table.insertRow(-1); // We are adding at the end
                        
                        depit_total=0;
                        credit_total=0;
                        
                        
                    data['items'].forEach(async (product) =>{
                                                        
                                                      let row = table.insertRow(-1); // We are adding at the end
                              
                        update = ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id=';
                        update = update.concat(product['id'], '  ', ' data-depit=', product['depit'], '  ', ' data-account_id=', product['account_id'],  '  ', ' data-credit=', product['credit'], '  ',
                            '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>') 
                            
                              text1 =' <a style="width:40px;height:20px;" class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id='
                        result1 = text1.concat(product['id'], "  ",'  data-toggle="modal"   href="#exampleModal2"   title="حذف"><i class="las la-trash"></i></a>')   
                                                        
                        let c1 = row.insertCell(0);
                        let c2 = row.insertCell(1);
                        let c4 = row.insertCell(2);
                        let c6 = row.insertCell(3);
                        let c7 = row.insertCell(4);
                        c1.innerText = data['id']
                        c2.innerText = product['name']
                        c4.innerText = product['depit'].toFixed(2)
                        c6.innerText = product['credit'].toFixed(2)
                        c7.innerHTML = update+' - '+result1
                        depit_total=depit_total+ (product['depit']*1);
                        credit_total=credit_total+(product['credit']*1);
                        
                         })
                    
                         let row1 = table.insertRow(-1); 
                        let c11 = row1.insertCell(0);
                        let c12 = row1.insertCell(1);
                        let c13 = row1.insertCell(2);
                        let c14 = row1.insertCell(3);
                        let c15 = row1.insertCell(4);
                        c11.innerText ="-";
                        c12.innerText ="{{__('home.total')}}";
                        c13.innerText = depit_total;
                        c14.innerText = credit_total;
                        c15.innerText = "-";


                        $('#debit_1').val(0)
                        $('#credit_1').val(0)
                        $('#record_id').val(data['id'])
                        $('#record_id_print').val(data['id'])

                 

                        setTimeout(() => {
                            $('#loading').modal('hide');

                        }, 500);
                    },
                    error: function(response) {
                        alert("{{ __('home.sorryerror') }}")

                    }
                })
            
       })
       
       
       
       
 $("#getinvoiceupdate").click(function(e) {
            event.preventDefault();
            var url = " {{ URL::to('getAndUpdate_delyrecord') }}" + "/" + $('#updateinvoicebyid').val();
            console.log(url)
            jQuery.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                cache: false,

                    success: function(data) {
                        
                        console.log('----------------------------------------------------')
                        console.log(data)
                        console.log('----------------------------------------------------')
                       
                        let table = document.getElementById("example");
                        var tableHeaderRowCount = 1;

                        var rowCount = table.rows.length;

                        for (var i = tableHeaderRowCount; i < rowCount; i++) {
                            table.deleteRow(tableHeaderRowCount);
                        }
                        let row = table.insertRow(-1); // We are adding at the end
                        
                        depit_total=0;
                        credit_total=0;
                        
                        
                    data['items'].forEach(async (product) =>{
                                                        
                                                      let row = table.insertRow(-1); // We are adding at the end
                              
                        update = ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id=';
                        update = update.concat(product['id'], '  ', ' data-depit=', product['depit'], '  ', ' data-account_id=', product['account_id'],  '  ', ' data-credit=', product['credit'], '  ',
                            '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>') 
                            
                              text1 =' <a style="width:40px;height:20px;" class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id='
                        result1 = text1.concat(product['id'], "  ",'  data-toggle="modal"   href="#exampleModal2"   title="حذف"><i class="las la-trash"></i></a>')   
                                                        
                        let c1 = row.insertCell(0);
                        let c2 = row.insertCell(1);
                        let c4 = row.insertCell(2);
                        let c6 = row.insertCell(3);
                        let c7 = row.insertCell(4);
                        c1.innerText = data['id']
                        c2.innerText = product['name']
                        c4.innerText = product['depit'].toFixed(2)
                        c6.innerText = product['credit'].toFixed(2)
                        c7.innerHTML = update+' - '+result1
                        depit_total=depit_total+ (product['depit']*1);
                        credit_total=credit_total+(product['credit']*1);
                        
                         })
                    
                         let row1 = table.insertRow(-1); 
                        let c11 = row1.insertCell(0);
                        let c12 = row1.insertCell(1);
                        let c13 = row1.insertCell(2);
                        let c14 = row1.insertCell(3);
                        let c15 = row1.insertCell(4);
                        c11.innerText ="-";
                        c12.innerText ="{{__('home.total')}}";
                        c13.innerText = depit_total;
                        c14.innerText = credit_total;
                        c15.innerText = "-";


                        $('#debit_1').val(0)
                        $('#credit_1').val(0)
                        $('#record_id').val(data['id'])
                        $('#record_id_print').val(data['id'])

                 

                        setTimeout(() => {
                            $('#loading').modal('hide');

                        }, 500);
                    },
                    error: function(response) {
                        alert("{{ __('home.sorryerror') }}")

                    }
                })
            
       })
       
       
       
       
       
    var date = $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();



    $('#increaseProduct').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)

        var id = button.data('id')
        var account_id = button.data('account_id')
        var credit = button.data('credit')
        var depit = button.data('depit')
        var modal = $(this)

                    $('#clientnamesearch_update').val(account_id).change();


        modal.find('.modal-body #transactionId').val(id);
        modal.find('.modal-body #credit_update').val(credit);
        modal.find('.modal-body #debit_update').val(depit);

    })
</script>



<script>


function search_by_decoumentNo_function(){
    if($("#search_by_decoumentNo").val()==''){
        
             $.ajax({
                url: " {{URL::to('get_all_kid_yaomy_jax')}}",
                type: "GET",
                dataType: "html",
                success: function(products) {
                    $("#ajax_responce_allinvoicesDiv").html(products);


                },
            });

        
    }else{
     $.ajax({
                url: " {{URL::to('search_by_decoumentNo_kid_yomy')}}/"+$("#search_by_decoumentNo").val(),
                type: "GET",
                dataType: "html",
                success: function(products) {
                    $("#ajax_responce_allinvoicesDiv").html(products);


                },
            }); 
    }
}




    $(document).on('click', '#ajax_pagination_in_search a ', function(e) {
        e.preventDefault();
        var search_by_text = $("#date").val();
        var url = $(this).attr("href");
        var token_search = $("#token_search").val();

        jQuery.ajax({
            url: url,
            type: 'get',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token_search
            },
            success: function(data) {
                $("#ajax_responce_allinvoicesDiv").html(data);
            },
            error: function() {

            }
        });
    });


function set_zero_write_depit(){
         $("#credit_update").val(0);

    
}

function set_zero_write_credit(){
             $("#debit_update").val(0);

    
}

    $(document).ready(function() {
                   $.ajax({
                url: " {{URL::to('get_all_kid_yaomy_jax')}}",
                type: "GET",
                dataType: "html",
                success: function(products) {
                    $("#ajax_responce_allinvoicesDiv").html(products);


                },
            });
    document.getElementById('print_record').style.visibility = 'hidden';

        $(function() {
            var timeout = 4000; // in miliseconds (3*1000)
            $('.alert').delay(timeout).fadeOut(500);
        });





        $("#updatedecoument").click(function(e) {

            var url = " {{ URL::to('updatedelyrecord') }}";
            var token_search = $("#token_search").val();
            {
                console.log($('#transactionId').val())
                $.ajax({
                    url: url,
                    type: 'post',
                    cache: false,

                    data: {
                        _token: token_search,
                        transactionId: $('#transactionId').val(),
                        credit_update: $('#credit_update').val(),
                        debit_update: $('#debit_update').val(),
                        clientnamesearch_update: $('#clientnamesearch_update').val(),



                    },


                    success: function(data) {
                        
                        console.log('----------------------------------------------------')
                        console.log(data)
                        console.log('----------------------------------------------------')
                       
                        let table = document.getElementById("example");
                        var tableHeaderRowCount = 1;

                        var rowCount = table.rows.length;

                        for (var i = tableHeaderRowCount; i < rowCount; i++) {
                            table.deleteRow(tableHeaderRowCount);
                        }
                        let row = table.insertRow(-1); // We are adding at the end
                        
                        depit_total=0;
                        credit_total=0;
                        
                        
                    data['items'].forEach(async (product) =>{
                                                        
                                                      let row = table.insertRow(-1); // We are adding at the end
                              
                        update = ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id=';
                        update = update.concat(product['id'], '  ', ' data-depit=', product['depit'], '  ', '  ', ' data-credit=', product['credit'], '  ',
                            '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>') 
                                      text1 =' <a style="width:40px;height:20px;" class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id='
                        result1 = text1.concat(product['id'], "  ",'  data-toggle="modal"   href="#exampleModal2"   title="حذف"><i class="las la-trash"></i></a>')                       
                        let c1 = row.insertCell(0);
                        let c2 = row.insertCell(1);
                        let c4 = row.insertCell(2);
                        let c6 = row.insertCell(3);
                        let c7 = row.insertCell(4);
                        c1.innerText = data['id']
                        c2.innerText = product['name']
                        c4.innerText = product['depit'].toFixed(2)
                        c6.innerText = product['credit'].toFixed(2)
                        c7.innerHTML = update+' - '+result1
                        depit_total=depit_total+ (product['depit']*1);
                        credit_total=credit_total+(product['credit']*1);
                        
                         })
                    
                         let row1 = table.insertRow(-1); 
                        let c11 = row1.insertCell(0);
                        let c12 = row1.insertCell(1);
                        let c13 = row1.insertCell(2);
                        let c14 = row1.insertCell(3);
                        let c15 = row1.insertCell(4);
                        c11.innerText ="-";
                        c12.innerText ="{{__('home.total')}}";
                        c13.innerText = depit_total;
                        c14.innerText = credit_total;
                        c15.innerText = "-";


                        $('#debit_1').val(0)
                        $('#credit_1').val(0)
                        $('#record_id').val(data['id'])
                        $('#record_id_print').val(data['id'])

                 

                        setTimeout(() => {
                            $('#loading').modal('hide');

                        }, 500);
                    },
                    error: function(response) {
                        console.log(response)
                        alert("{{ __('home.sorryerror') }}")

                    }
                })




            }



        })
        
        
        
        
         $("#save_1").click(function(e) {
            event.preventDefault();
            var url = " {{ URL::to('save_Daily_record') }}" + "/" + $('#record_id').val();
            console.log(url)
            jQuery.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                cache: false,

                success: function(data) {
                    if(data[0]==1){
                        
                        alert(data[1])

                        document.getElementById('print_record').style.visibility = 'visible';
                        document.getElementById('save_1').style.visibility = 'hidden';

                    }else
                    {
                        
                        alert(data[1])
                    }
                    
                }
                
            })
             
         })
                    
                    
                    
                    
                    
                    


        $("#formdata").on('submit', function(e) {
            e.preventDefault();
            $('#loading').modal().show();
            var url = "{{ URL::to('create_daily_record') }}";
            var token_search = $("#token_search").val();
            if ($('#clientnamesearch_1').val() == '-') {
                alert("{{__('home.saerch_by_numberaccount_or_name')}}")
            }else if ($('#credit_1').val() == '') {
                alert("{{__('home.should')}}")

            } else if ($('#debit_1').val() == '') {
                alert("{{__('home.should')}}")

            }else if ($('#date').val() == 0) {
                alert("{{__('home.exportTime')}}")

            } else {

                $.ajax({
                    url: url,
                    type: 'post',
                    cache: false,

                    contentType: false,
                    processData: false,
                    data: new FormData(this),


                    success: function(data) {
                        
                        console.log('----------------------------------------------------')
                        console.log(data)
                        console.log('----------------------------------------------------')
                       
                        let table = document.getElementById("example");
                        var tableHeaderRowCount = 1;

                        var rowCount = table.rows.length;

                        for (var i = tableHeaderRowCount; i < rowCount; i++) {
                            table.deleteRow(tableHeaderRowCount);
                        }
                        let row = table.insertRow(-1); // We are adding at the end
                        
                        depit_total=0;
                        credit_total=0;
                        
                    data['items'].forEach(async (product) =>{
                                                        
                                                      let row = table.insertRow(-1); // We are adding at the end
                              
                        update = ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id=';
                        update = update.concat(product['id'], '  ', ' data-depit=', product['depit'], '  ', '  ', ' data-account_id=', product['account_id'], '  ', '  ', ' data-credit=', product['credit'], '  ',
                            '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>') 
                            text1 =' <a style="width:40px;height:20px;" class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id='
                        result1 = text1.concat(product['id'], "  ",'  data-toggle="modal"   href="#exampleModal2"   title="حذف"><i class="las la-trash"></i></a>')                       
                        let c1 = row.insertCell(0);
                        let c2 = row.insertCell(1);
                        let c4 = row.insertCell(2);
                        let c6 = row.insertCell(3);
                        let c7 = row.insertCell(4);
                        c1.innerText = data['id']
                        c2.innerText = product['name']
                        c4.innerText = product['depit'].toFixed(2)
                        c6.innerText = product['credit'].toFixed(2)
                        c7.innerHTML = update+' - '+result1
                        depit_total=depit_total+ (product['depit']*1);
                        credit_total=credit_total+(product['credit']*1);
                        
                        
                        
            
                         })

                        let row1 = table.insertRow(-1); 
                        let c11 = row1.insertCell(0);
                        let c12 = row1.insertCell(1);
                        let c13 = row1.insertCell(2);
                        let c14 = row1.insertCell(3);
                        let c15 = row1.insertCell(4);
                        c11.innerText ="-";
                        c12.innerText ="{{__('home.total')}}";
                        c13.innerText = depit_total;
                        c14.innerText = credit_total;
                        c15.innerText = "-";


                        $('#debit_1').val(0)
                        $('#credit_1').val(0)
                        $('#record_id').val(data['id'])
                        $('#record_id_print').val(data['id'])

                        console.log(depit_total)
                        console.log(credit_total)
                   


                        

                        setTimeout(() => {
                            $('#loading').modal('hide');

                        }, 500);
                    },
                    error: function(response) {
                        console.log(response['responseText'])
                        alert("{{ __('home.sorryerror') }}")

                    }
                })




            }



        })

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

                        $('#clientNosearch').val('0');

                        $('#clientName').val(data['name']);
                        $('#address').val(data['address']);
                        $('#phonenumber').val(data['phone']);
                        $('#notes').val(data['notes']);

                        $('#creditlimit').val(data['Limit_credit']);
                        $('#balance').val(data['Balance']);

                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });



    $('select[name="clientNosearch"]').on('change', function() {
        console.log('AJAX load   work 0000');

        var selectclientid = $(this).val();
        if (selectclientid) {
            console.log('AJAX load   work');
            console.log(selectclientid);

            $.ajax({
                url: "{{ URL::to('getcustomer') }}/" + selectclientid,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log("success");
                    console.log(data['name']);
                    $('#clientName').val(data['name']);
                    $('#clientnamesearch').val('');
                    $('#address').val(data['address']);
                    $('#phonenumber').val(data['phone']);
                    $('#notes').val(data['notes']);

                    $('#creditlimit').val(data['Limit_credit']);
                    $('#balance').val(data['Balance']);

                },
            });
        } else {
            console.log('AJAX load did not work');
        }

    });
</script>

<script>
    function moneyconvertToNumber() {
        var input = document.getElementById("cashreceived");
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

</script>


@endsection