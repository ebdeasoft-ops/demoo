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

{{-- <style>
        tr:nth-child(even) {
            background-color: #dde2ef !important;
            
            color: white;
        }
    </style> --}}

<style>
.body_calculator {
    font-family: Arial, sans-serif;
    position: fixed;
    top: initial;
    bottom: 0;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    width: 390px;
    background-color: #f4f4f4;
}

.calculator {
    border: 2px solid #ccc;
    border-radius: 8px;
    padding: 20px;
    background-color: white;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    width: 360px;
}

#display {
    width: 100%;
    height: 40px;
    text-align: right;
    font-size: 24px;
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.buttons {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

.button {
    padding: 20px;
    font-size: 20px;
    border: none;
    background-color: #f0f0f0;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.button:hover {
    background-color: #ddd;
}

button:active {
    background-color: #ccc;
}

/* Basic styling for loading screen */
#loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    color: white;
    font-size: 24px;
    display: none;
}

#loading-animation {
    border: 4px solid white;
    border-radius: 50%;
    border-top: 4px solid #3498db;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
@section('title')
{{ __('home.sales') }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="main-parent">
    <div style="justify-content: space-between !important" class="breadcrumb-header parent-heading">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="conte  nt-title mb-0 my-auto">{{ __('home.sales') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                </span>
            </div>
        </div>
    </div><!-- col-4 -->
    @if (session()->has('newcustomer'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <br>

        <strong>{{ session()->get('newcustomer') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if (session()->has('nodataprint'))
    <div class="alert alert-warning  alert-dismissible fade show" role="alert">
        <br>
        <strong>{{ __('home.nodataprint') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session()->has('edit'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <br>
        <strong>{{ session()->get('edit') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif


    <!-- <div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{ __('home.sales') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
            </span>
        </div>
    </div>
</div> -->
    <!-- breadcrumb -->

    @endsection
    @section('content')
    <center>
        <div id="loading-screen">
            <div id="loading-animation"></div>
            &nbsp; <p> جارٍ إرسال الفاتورة، يرجى الانتظار <br>Invoice is being sent, please wait</p>
        </div>
    </center>


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
                    <div class="my-auto">

                        <div class=" d-flex justify-content-between">
                            <div class="choose-product m-1 mt-3">
                                <button style="background-color: #FBA10F;font-size:13px;width:128px"
                                    class="modal-effect btn btn-sm btn-info p-1" data-effect="effect-scale"
                                    data-toggle="modal" href="#SearchProduct" title="تحديد">
                                    {{ __('home.chooose product') }}
                                    <i style=" height: 100;
                                                 
                                                 font-size:13px" class="las"></i>
                                    <svg style="width: 16px;height:16px" xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-search" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                        <path d="M21 21l-6 -6"></path>
                                    </svg>
                                </button>

                                &nbsp;





                            </div>



                            <input hidden autocomplete="off" type="text" class="form-control parent-input"
                                id="show_cost_profit" name="show_cost_profit" value="1">









                            <div style="flex-direction: row;border-radius:5px" class="card justify-content-around row ">
                                <div class="choose-product">
                                    <button style="background-color:white;"
                                        class="modal-effect btn btn-sm btn-info p-2 m-1 button-eng"
                                        data-effect="effect-scale" data-toggle="modal" href="#calculter_modale"
                                        title="تحديد"><i style=" height: 100;font-weight:400 !important;
                                                 font-size:13px" class="las"> </i>
                                        <svg height="40px" width="67px" version="1.1" id="Layer_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                                            xml:space="preserve" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g transform="translate(1 1)">
                                                    <path style="fill:#FFDD;"
                                                        d="M369.347,502.467H140.653c-21.333,0-38.4-18.773-38.4-42.667V50.2 c0-23.893,17.067-42.667,38.4-42.667H370.2c21.333,0,38.4,18.773,38.4,42.667v409.6 C407.747,483.693,390.68,502.467,369.347,502.467">
                                                    </path>
                                                    <path style="fill:#FFFFFF;"
                                                        d="M102.253,459.8V50.2c0-23.893,17.067-42.667,38.4-42.667H127c-23.893,0-42.667,18.773-42.667,42.667 v409.6c0,23.893,18.773,42.667,42.667,42.667h13.653C119.32,502.467,102.253,483.693,102.253,459.8">
                                                    </path>
                                                    <path style="fill:#FD98000;"
                                                        d="M383,7.533h-13.653c21.333,0,38.4,18.773,38.4,42.667v409.6c0,23.893-17.067,42.667-38.4,42.667H383 c23.893,0,42.667-18.773,42.667-42.667V50.2C425.667,26.307,406.893,7.533,383,7.533">
                                                    </path>
                                                    <path style="fill:#54C9FD;"
                                                        d="M118.467,195.267h256v-153.6h-256V195.267z"></path>
                                                    <path style="fill:#33A9F8;"
                                                        d="M374.467,195.267h17.067v-153.6h-17.067V195.267z"></path>
                                                    <g>
                                                        <path style="fill:#00000;"
                                                            d="M176.493,263.533h-30.72c-5.12,0-10.24-5.12-10.24-10.24v-12.8c0-5.973,5.12-11.093,10.24-11.093 h29.867c5.973,0,10.24,5.12,10.24,10.24v12.8C186.733,258.413,181.613,263.533,176.493,263.533">
                                                        </path>
                                                        <path style="fill:#00000;"
                                                            d="M270.36,263.533h-29.867c-5.973,0-10.24-5.12-10.24-10.24v-12.8c0-5.973,5.12-10.24,10.24-10.24 h29.867c5.973,0,10.24,5.12,10.24,10.24v12.8C280.6,258.413,275.48,263.533,270.36,263.533">
                                                        </path>
                                                        <path style="fill:#00000;"
                                                            d="M364.227,263.533H334.36c-5.973,0-10.24-5.12-10.24-10.24v-12.8c0-5.973,5.12-10.24,10.24-10.24 h29.867c5.973,0,10.24,5.12,10.24,10.24v12.8C374.467,258.413,369.347,263.533,364.227,263.533">
                                                        </path>
                                                        <path style="fill:#00000;"
                                                            d="M364.227,331.8H334.36c-5.973,0-10.24-5.12-10.24-10.24v-12.8c0-5.973,5.12-10.24,10.24-10.24 h29.867c5.973,0,10.24,5.12,10.24,10.24v12.8C374.467,326.68,369.347,331.8,364.227,331.8">
                                                        </path>
                                                        <path style="fill:#00000;"
                                                            d="M270.36,331.8h-29.867c-5.973,0-10.24-5.12-10.24-10.24v-12.8c0-5.973,5.12-10.24,10.24-10.24 h29.867c5.973,0,10.24,5.12,10.24,10.24v12.8C280.6,326.68,275.48,331.8,270.36,331.8">
                                                        </path>
                                                        <path style="fill:#00000;"
                                                            d="M176.493,331.8h-30.72c-5.12,0-10.24-5.12-10.24-10.24v-12.8c0-5.973,5.12-11.093,10.24-11.093 h29.867c5.973,0,10.24,5.12,10.24,10.24v12.8C186.733,326.68,181.613,331.8,176.493,331.8">
                                                        </path>
                                                        <path style="fill:#00000;"
                                                            d="M176.493,400.067h-30.72c-5.12,0-10.24-5.12-10.24-10.24v-12.8c0-5.973,5.12-11.093,10.24-11.093 h29.867c5.973,0,10.24,5.12,10.24,10.24v12.8C186.733,394.947,181.613,400.067,176.493,400.067">
                                                        </path>
                                                        <path style="fill:#00000;"
                                                            d="M270.36,400.067h-29.867c-5.973,0-10.24-5.12-10.24-10.24v-12.8c0-5.973,5.12-10.24,10.24-10.24 h29.867c5.973,0,10.24,5.12,10.24,10.24v12.8C280.6,394.947,275.48,400.067,270.36,400.067">
                                                        </path>
                                                        <path style="fill:#00000;"
                                                            d="M364.227,400.067H334.36c-5.973,0-10.24-5.12-10.24-10.24v-12.8c0-5.973,5.12-10.24,10.24-10.24 h29.867c5.973,0,10.24,5.12,10.24,10.24v12.8C374.467,394.947,369.347,400.067,364.227,400.067">
                                                        </path>
                                                        <path style="fill:#00000;"
                                                            d="M364.227,468.333H334.36c-5.973,0-10.24-5.12-10.24-10.24v-12.8c0-5.973,5.12-10.24,10.24-10.24 h29.867c5.973,0,10.24,5.12,10.24,10.24v12.8C374.467,463.213,369.347,468.333,364.227,468.333">
                                                        </path>
                                                        <path style="fill:#00000;"
                                                            d="M270.36,468.333h-29.867c-5.973,0-10.24-5.12-10.24-10.24v-12.8c0-5.973,5.12-10.24,10.24-10.24 h29.867c5.973,0,10.24,5.12,10.24,10.24v12.8C280.6,463.213,275.48,468.333,270.36,468.333">
                                                        </path>
                                                        <path style="fill:#00000;"
                                                            d="M176.493,468.333h-30.72c-5.12,0-10.24-5.12-10.24-10.24v-12.8c0-5.973,5.12-11.093,10.24-11.093 h29.867c5.973,0,10.24,5.12,10.24,10.24v12.8C186.733,463.213,181.613,468.333,176.493,468.333">
                                                        </path>
                                                    </g>
                                                    <path
                                                        d="M383,511H127c-28.16,0-51.2-23.04-51.2-51.2V50.2C75.8,22.04,98.84-1,127-1h256c28.16,0,51.2,23.04,51.2,51.2v409.6 C434.2,487.96,411.16,511,383,511z M127,16.067c-18.773,0-34.133,15.36-34.133,34.133v409.6c0,18.773,15.36,34.133,34.133,34.133 h256c18.773,0,34.133-15.36,34.133-34.133V50.2c0-18.773-15.36-34.133-34.133-34.133H127z">
                                                    </path>
                                                    <path
                                                        d="M391.533,203.8H118.467c-5.12,0-8.533-3.413-8.533-8.533v-153.6c0-5.12,3.413-8.533,8.533-8.533h273.067 c5.12,0,8.533,3.413,8.533,8.533v153.6C400.067,200.387,396.653,203.8,391.533,203.8z M127,186.733h256V50.2H127V186.733z">
                                                    </path>
                                                    <path
                                                        d="M176.493,272.067h-30.72c-10.24,0-18.773-8.533-18.773-18.773v-12.8c0-11.093,8.533-19.627,18.773-19.627h29.867 c10.24,0,18.773,8.533,18.773,18.773v12.8C195.267,263.533,186.733,272.067,176.493,272.067z M145.773,237.933 c-0.853,0-1.707,0.853-1.707,1.707v12.8c0,1.707,0.853,2.56,1.707,2.56h29.867c0.853,0,1.707-0.853,1.707-1.707v-12.8 c0-0.853-0.853-1.707-1.707-1.707h-29.867V237.933z">
                                                    </path>
                                                    <path
                                                        d="M270.36,272.067h-29.867c-11.093,0-19.627-8.533-19.627-18.773v-12.8c0-10.24,8.533-18.773,18.773-18.773h29.867 c10.24,0,18.773,8.533,18.773,18.773v12.8C289.133,263.533,280.6,272.067,270.36,272.067z M239.64,237.933 c-0.853,0-1.707,0.853-1.707,1.707v12.8c0,0.853,0.853,1.707,1.707,1.707h29.867c0.853,0,1.707-0.853,1.707-1.707v-12.8 c0-0.853-0.853-1.707-1.707-1.707H239.64z">
                                                    </path>
                                                    <path
                                                        d="M364.227,272.067H334.36c-11.093,0-19.627-8.533-19.627-18.773v-12.8c0-10.24,8.533-18.773,18.773-18.773h29.867 c10.24,0,18.773,8.533,18.773,18.773v12.8C383,263.533,374.467,272.067,364.227,272.067z M333.507,237.933 c-0.853,0-1.707,0.853-1.707,1.707v12.8c0,0.853,0.853,1.707,1.707,1.707h29.867c0.853,0,1.707-0.853,1.707-1.707v-12.8 c0-0.853-0.853-1.707-1.707-1.707H333.507z">
                                                    </path>
                                                    <path
                                                        d="M364.227,340.333H334.36c-11.093,0-19.627-8.533-19.627-18.773v-12.8c0-10.24,8.533-18.773,18.773-18.773h29.867 c10.24,0,18.773,8.533,18.773,18.773v12.8C383,331.8,374.467,340.333,364.227,340.333z M333.507,306.2 c-0.853,0-1.707,0.853-1.707,1.707v12.8c0,0.853,0.853,1.707,1.707,1.707h29.867c0.853,0,1.707-0.853,1.707-1.707v-12.8 c0-0.853-0.853-1.707-1.707-1.707H333.507z">
                                                    </path>
                                                    <path
                                                        d="M270.36,340.333h-29.867c-11.093,0-19.627-8.533-19.627-18.773v-12.8c0-10.24,8.533-18.773,18.773-18.773h29.867 c10.24,0,18.773,8.533,18.773,18.773v12.8C289.133,331.8,280.6,340.333,270.36,340.333z M239.64,306.2 c-0.853,0-1.707,0.853-1.707,1.707v12.8c0,0.853,0.853,1.707,1.707,1.707h29.867c0.853,0,1.707-0.853,1.707-1.707v-12.8 c0-0.853-0.853-1.707-1.707-1.707H239.64z">
                                                    </path>
                                                    <path
                                                        d="M176.493,340.333h-30.72c-10.24,0-18.773-8.533-18.773-18.773v-12.8c0-11.093,8.533-19.627,18.773-19.627h29.867 c10.24,0,18.773,8.533,18.773,18.773v12.8C195.267,331.8,186.733,340.333,176.493,340.333z M145.773,306.2 c-0.853,0-1.707,0.853-1.707,1.707v12.8c0,1.707,0.853,2.56,1.707,2.56h29.867c0.853,0,1.707-0.853,1.707-1.707v-12.8 c0-0.853-0.853-1.707-1.707-1.707h-29.867V306.2z">
                                                    </path>
                                                    <path
                                                        d="M176.493,408.6h-30.72c-10.24,0-18.773-8.533-18.773-18.773v-12.8c0-11.093,8.533-19.627,18.773-19.627h29.867 c10.24,0,18.773,8.533,18.773,18.773v12.8C195.267,400.067,186.733,408.6,176.493,408.6z M145.773,374.467 c-0.853,0-1.707,0.853-1.707,1.707v12.8c0,1.707,0.853,2.56,1.707,2.56h29.867c0.853,0,1.707-0.853,1.707-1.707v-12.8 c0-0.853-0.853-1.707-1.707-1.707h-29.867V374.467z">
                                                    </path>
                                                    <path
                                                        d="M270.36,408.6h-29.867c-11.093,0-19.627-8.533-19.627-18.773v-12.8c0-10.24,8.533-18.773,18.773-18.773h29.867 c10.24,0,18.773,8.533,18.773,18.773v12.8C289.133,400.067,280.6,408.6,270.36,408.6z M239.64,374.467 c-0.853,0-1.707,0.853-1.707,1.707v12.8c0,0.853,0.853,1.707,1.707,1.707h29.867c0.853,0,1.707-0.853,1.707-1.707v-12.8 c0-0.853-0.853-1.707-1.707-1.707H239.64z">
                                                    </path>
                                                    <path
                                                        d="M364.227,408.6H334.36c-11.093,0-19.627-8.533-19.627-18.773v-12.8c0-10.24,8.533-18.773,18.773-18.773h29.867 c10.24,0,18.773,8.533,18.773,18.773v12.8C383,400.067,374.467,408.6,364.227,408.6z M333.507,374.467 c-0.853,0-1.707,0.853-1.707,1.707v12.8c0,0.853,0.853,1.707,1.707,1.707h29.867c0.853,0,1.707-0.853,1.707-1.707v-12.8 c0-0.853-0.853-1.707-1.707-1.707H333.507z">
                                                    </path>
                                                    <path
                                                        d="M364.227,476.867H334.36c-11.093,0-19.627-8.533-19.627-18.773v-12.8c0-10.24,8.533-18.773,18.773-18.773h29.867 c10.24,0,18.773,8.533,18.773,18.773v12.8C383,468.333,374.467,476.867,364.227,476.867z M333.507,442.733 c-0.853,0-1.707,0.853-1.707,1.707v12.8c0,0.853,0.853,1.707,1.707,1.707h29.867c0.853,0,1.707-0.853,1.707-1.707v-12.8 c0-0.853-0.853-1.707-1.707-1.707H333.507z">
                                                    </path>
                                                    <path
                                                        d="M270.36,476.867h-29.867c-11.093,0-19.627-8.533-19.627-18.773v-12.8c0-10.24,8.533-18.773,18.773-18.773h29.867 c10.24,0,18.773,8.533,18.773,18.773v12.8C289.133,468.333,280.6,476.867,270.36,476.867z M239.64,442.733 c-0.853,0-1.707,0.853-1.707,1.707v12.8c0,0.853,0.853,1.707,1.707,1.707h29.867c0.853,0,1.707-0.853,1.707-1.707v-12.8 c0-0.853-0.853-1.707-1.707-1.707H239.64z">
                                                    </path>
                                                    <path
                                                        d="M176.493,476.867h-30.72c-10.24,0-18.773-8.533-18.773-18.773v-12.8c0-11.093,8.533-19.627,18.773-19.627h29.867 c10.24,0,18.773,8.533,18.773,18.773v12.8C195.267,468.333,186.733,476.867,176.493,476.867z M145.773,442.733 c-0.853,0-1.707,0.853-1.707,1.707v12.8c0,1.707,0.853,2.56,1.707,2.56h29.867c0.853,0,1.707-0.853,1.707-1.707v-12.8 c0-0.853-0.853-1.707-1.707-1.707h-29.867V442.733z">
                                                    </path>
                                                    <path
                                                        d="M241.347,161.133h-5.973c-12.8,0-22.187-10.24-22.187-22.187V98.84c-0.853-12.8,9.387-23.04,21.333-23.04h5.973 c12.8,0,22.187,10.24,22.187,22.187v40.107C263.533,150.893,253.293,161.133,241.347,161.133z M234.52,92.867 c-3.413,0-5.12,2.56-5.12,5.12v40.107c0,3.413,2.56,5.12,5.12,5.12h5.973c3.413,0,5.12-2.56,5.12-5.12V97.987 c0-3.413-2.56-5.12-5.12-5.12H234.52z">
                                                    </path>
                                                    <path
                                                        d="M343.747,161.133h-5.973c-12.8,0-22.187-10.24-22.187-22.187V98.84c-0.853-12.8,9.387-23.04,21.333-23.04h5.973 c12.8,0,22.187,10.24,22.187,22.187v40.107C365.933,150.893,355.693,161.133,343.747,161.133z M336.92,92.867 c-3.413,0-5.12,2.56-5.12,5.12v40.107c0,3.413,2.56,5.12,5.12,5.12h5.973c3.413,0,5.12-2.56,5.12-5.12V97.987 c0-3.413-2.56-5.12-5.12-5.12H336.92z">
                                                    </path>
                                                    <path
                                                        d="M297.667,152.6c0,5.12-3.413,8.533-8.533,8.533c-5.12,0-8.533-3.413-8.533-8.533c0-5.12,3.413-8.533,8.533-8.533 C294.253,144.067,297.667,148.333,297.667,152.6">
                                                    </path>
                                                    <path
                                                        d="M161.133,118.467c-2.56,0-4.267-0.853-5.973-2.56c-3.413-3.413-3.413-8.533,0-11.947l25.6-25.6 c3.413-3.413,8.533-3.413,11.947,0s3.413,8.533,0,11.947l-25.6,25.6C165.4,117.613,163.693,118.467,161.133,118.467z">
                                                    </path>
                                                    <path
                                                        d="M186.733,161.133c-5.12,0-8.533-3.413-8.533-8.533V84.333c0-5.12,3.413-8.533,8.533-8.533c5.12,0,8.533,3.413,8.533,8.533 V152.6C195.267,157.72,191.853,161.133,186.733,161.133z">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg> </button>
                                </div>
                                     <div style="flex-direction: row;border-radius:5px" class="card justify-content-around row ">
                                             <div class="last-sales" style=" font-size:13px;">
                                <select class="form-control select2"  style=" font-size:18px;" name="numbershowstatus" id="numbershowstatus" required>
                                  <option style=" font-size:18px;" value=1 >
                                        {{__('home.shownumberselect') }}
                                    </option>
                                    <option style=" font-size:18px;" value=0 >
                                        {{__('home.notshow') }}
                                    </option>
  
                               
                                </select>
                            </div>
                                <div class="last-sales">
                                    <a style="color:white;background-color: #23395D;border-radius:5px;font-size:11px;width:165px;padding:9px 6px"
                                        class="btn btn-info m-1"
                                        href="{{ url('/' . ($page = 'product_mix')) }}">{{ __('home.product_mix') }}
                                        <svg style="width:16px !important" class="svg-icon-buttons" viewBox="0 0 20 20">
                                            <path
                                                d="M17.927,5.828h-4.41l-1.929-1.961c-0.078-0.079-0.186-0.125-0.297-0.125H4.159c-0.229,0-0.417,0.188-0.417,0.417v1.669H2.073c-0.229,0-0.417,0.188-0.417,0.417v9.596c0,0.229,0.188,0.417,0.417,0.417h15.854c0.229,0,0.417-0.188,0.417-0.417V6.245C18.344,6.016,18.156,5.828,17.927,5.828 M4.577,4.577h6.539l1.231,1.251h-7.77V4.577z M17.51,15.424H2.491V6.663H17.51V15.424z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                                <div class="choose-product">
                                    <button style="background-color: #23395D;"
                                        class="modal-effect btn btn-sm btn-info p-2 m-1 button-eng"
                                        data-effect="effect-scale" data-toggle="modal" href="#createcustomer"
                                        title="تحديد"><i style=" height: 100;font-weight:400 !important;
                                                 width: 65px;
                                                 font-size:13px" class="las"> {{ __('home.addnewcustomer') }}</i>
                                        <svg style="width: 18px;height:18px" xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-user-plus" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                            <path d="M16 19h6"></path>
                                            <path d="M19 16v6"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                        </svg>
                                    </button>
                                </div>


                                <div class="choose-product">
                                    <button style="background-color: #23395D;"
                                        class="modal-effect btn btn-sm btn-info p-2 m-1 button-eng"
                                        data-effect="effect-scale" data-toggle="modal"
                                        onclick="display_appear_function()" title="تحديد"><i style=" height: 100;font-weight:400 !important;
                                                 width: 65px;
                                                 font-size:13px" class="las"> {{ __('home.display_appear') }}</i>

                                    </button>
                                </div>
                                <div class="choose-product">

                                    <button style="background-color: #23395D;"
                                        class="modal-effect btn btn-sm btn-info p-2 m-1 button-eng"
                                        data-effect="effect-scale" data-toggle="modal" href="#createproduct"
                                        title="تحديد"><i style=" height: 50;font-weight:400 !important;
                                                 width: 65px;
                                                 font-size:13px" class="las"> {{ __('supprocesses.addproduct') }}</i>

                                    </button>



                                </div>

                                @can('sales return')

                                <div class="choose-product">
                                    <button style="background-color: green;"
                                        class="modal-effect btn btn-sm btn-info p-2 m-1 button-eng"
                                        data-effect="effect-scale" data-toggle="modal" href="#updateinvoicebyidmodale"
                                        title="تحديد"><i style=" height: 100;font-weight:400 !important;
                                                 width: 65px;
                                                 font-size:13px" class="las"> {{ __('home.updateinvoicebyid') }}</i>
                                        <svg style="width:16px !important" class="svg-icon-buttons" viewBox="0 0 20 20">
                                            <path
                                                d="M17.927,5.828h-4.41l-1.929-1.961c-0.078-0.079-0.186-0.125-0.297-0.125H4.159c-0.229,0-0.417,0.188-0.417,0.417v1.669H2.073c-0.229,0-0.417,0.188-0.417,0.417v9.596c0,0.229,0.188,0.417,0.417,0.417h15.854c0.229,0,0.417-0.188,0.417-0.417V6.245C18.344,6.016,18.156,5.828,17.927,5.828 M4.577,4.577h6.539l1.231,1.251h-7.77V4.577z M17.51,15.424H2.491V6.663H17.51V15.424z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                @endcan
                                <div class="last-sales">
                                    <a style="color:white;background-color: #23395D;border-radius:5px;font-size:11px;width:165px;padding:9px 6px"
                                        class="btn btn-info m-1"
                                        href="{{ url('/' . ($page = 'previousSalesInvoices')) }}">{{ __('home.previousSalesInvoices') }}
                                        <svg style="width:16px !important" class="svg-icon-buttons" viewBox="0 0 20 20">
                                            <path
                                                d="M17.927,5.828h-4.41l-1.929-1.961c-0.078-0.079-0.186-0.125-0.297-0.125H4.159c-0.229,0-0.417,0.188-0.417,0.417v1.669H2.073c-0.229,0-0.417,0.188-0.417,0.417v9.596c0,0.229,0.188,0.417,0.417,0.417h15.854c0.229,0,0.417-0.188,0.417-0.417V6.245C18.344,6.016,18.156,5.828,17.927,5.828 M4.577,4.577h6.539l1.231,1.251h-7.77V4.577z M17.51,15.424H2.491V6.663H17.51V15.424z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>

                    <?php
                            $avtSaleRate = App\Models\Avt::find(1);
                            $avtSaleRate = $avtSaleRate->AVT;
                            ?>
                    <div style="border-radius: 10px" class="card p-3 my-3">
                        <div class="row mg-lg-b-10">


                            <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label"> {{ __('home.product') }}
                                </label>
                                <input type="text" autocomplete="off" class="form-control parent-input"
                                    id="product_name" name="product_name" title="  يرجي ادخال رقم المنتج  " readonly>
                            </div>


                            <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label"> {{ __('home.productNo') }}
                                </label>
                                <input autocomplete="off" type="text" class="form-control parent-input"
                                    id="product_code" name="product_code" onkeyup="getproduct()" dir=ltr
                                    title="  يرجي ادخال رقم المنتج  ">
                            </div>
     <div class="col-lg-1 mg-t-10 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label"> {{ __('home.quantity') }}
                                </label>
                                <input type="number" class="form-control parent-input" id="quantity" name="quantity"
                                    title="يرجي ادخال الكمية  " value=1 onkeyup="checkquentity()" required>
                            </div>
                            <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('home.saleperpice') }}</label>
                                <input autocomplete="off" type="text" class="form-control parent-input"
                                    id="priceWithTax" name="priceWithTax" onkeyup="changePriceWithTax()" required>
                            </div>
                            <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('home.sellingproduct without tax') }}</label>
                                <input readonly autocomplete="off" type="text" class="form-control parent-input"
                                    id="product_price" name="product_price"
                                    onkeyup="changeAvtValue('{{ $avtSaleRate }}')" required>
                            </div>
                       
                            <div class="col-lg-1 mg-t-10 mg-lg-t-0">
                                <label for="inputName"
                                    class="control-label parent-label">{{ __('home.unit_pice') }}</label>

                                <select class="form-control select2" name="unit_pice" id="unit_pice">
                                    <option value="{{__('home.unit_PICE')}}"> {{__('home.unit_PICE')}} </option>
                                    <option value="{{__('home.unit_barmil')}}"> {{__('home.unit_barmil')}} </option>
                                    <option value="{{ __('home.unit_karton')}}"> {{__('home.unit_karton')}} </option>
                                    <option value="{{ __('home.unit_takm')}}"> {{__('home.unit_takm')}} </option>
                                    <option value="{{ __('home.unit_galon')}}"> {{__('home.unit_galon')}}</option>
                                    <option value="{{ __('home.unit_LETER')}}"> {{__('home.unit_LETER')}}</option>
                                    <option id="kg_unit" value="{{ __('home.unit_KG')}}"> {{__('home.unit_KG')}}</option>
                                </select>
                            </div><!-- col-4 -->

                            <input type="text" class="form-control " id="avtValue" name="avtValue"
                                value="{{$avtSaleRate}}" hidden>

                            <div class="col-lg-1 mg-t-10 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('home.discount') }}</label>
                                <input autocomplete="off" type="text" class="form-control parent-input"
                                    id="product_price_after_dis" value=0 name="product_price_after_dis"
                                    onkeyup="checkdiscount_rate_allow()">
                            </div>

                            <div class="col-lg-1">
                                <label for="inputName" class="control-label parent-label"> {{ __('home.avt') }} </label>
                                <input autocomplete="off" type="text" class="form-control parent-input" id="avt"
                                    name="avt" title="يرجي ادخال الكمية  " value="{{ $avtSaleRate }}" readonly>
                            </div>

                         <input class="form-control parent-input fc-datepicker" value="0" name="date"
                                        id="date" placeholder="YYYY-MM-DD" type="text" hidden>
                        




                        </div>

                        <div class="row mg-lg-b-10">



                            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('home.lastpricecustomer') }}</label>
                                <select class="form-control parent-input " name="last_supplier_cost"
                                    id="last_supplier_cost">

                                </select>
                            </div>





                            <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('home.availablequantity') }}
                                </label>
                                <input autocomplete="off" type="text" class="form-control parent-input"
                                    id="avaliable_quentity" name="avaliable_quentity" readonly>
                            </div>



                            <div id="div_show_cost" class="col-lg-2 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('home.purchaseproductwithouttax') }}</label>
                                <input autocomplete="off" type="text" class="form-control parent-input "
                                    id="purchase_price" name="purchase_price" readonly required>
                            </div>





                            <div id="div_show_profit" class="col-lg-2 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label"> {{ __('home.profit') }}
                                </label>
                                <input autocomplete="off" type="text" class="form-control parent-input" id="profit"
                                    name="profit" value=0 readonly>
                            </div>
                            <div id="div_show_total_profit" class="col-lg-2 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label"> {{ __('home.total_profit') }}
                                </label>
                                <input autocomplete="off" type="text" class="form-control parent-input"
                                    id="total_profit" name="total_profit" readonly>
                            </div>
                        </div>







                        <div class='row'>
                            <div>

                                <input name="pay" id='pay' value="Cash" hidden=true>
                                <input name="showInvoiceNumber" id='showInvoiceNumber'   value="{{$invoiceId}}" hidden=true>


                            </div>
                            <div class="col-lg-4 mg-lg-t-10">
                                <label for="inputName"
                                    class="control-label parent-label">{{ __('home.chooseclient') }}</label>

                                <select class="form-control select2" name="clientnamesearch" id="clientnamesearch">

                                    <option value=0>.</option>

                                    @foreach (App\Models\customers::get() as $customer)
                                    <option value="{{ $customer->id }}">
                                       {{ App::getLocale()=='ar'? $customer->name.' - '. $customer->tax_no: $customer->comp_name.' - '. $customer->tax_no}} </option>
                                    @endforeach
                                </select>
                            </div><!-- col-4 -->
                            <div class="col-lg-2 mg-t-10">
                                <label for="inputName" class="control-label parent-label"> {{ __('home.creditlimit') }}
                                </label>
                                <input type="number" class="form-control parent-input" id="creditlimit"
                                    name="creditlimit" title="يرجي ادخال الكمية  "
                                    value="{{ $data['customer']->Limit_credit ?? '0' }}" readonly required>
                            </div>
                            <div class="col-lg-1 mg-t-10">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('home.current balance') }}
                                </label>
                                <input autocomplete="off" type="number" class="form-control parent-input" id="balance"
                                    name="balance" title="يرجي ادخال الكمية  "
                                    value="{{ $data['customer']->Balance ?? '0' }}" readonly required>
                            </div>
                                <div class="col-lg-1 mg-t-10">
                                <label for="inputName" class="control-label parent-label">P.O
                                </label>
                                <input autocomplete="off" type="text" class="form-control parent-input" id="p_o"
                                    name="notes"    
                                    value="- ">
                            </div>
                            <div class="col-lg-4 mg-t-10">
                                <label for="inputName" class="control-label parent-label">{{ __('home.notesClient') }}
                                </label>
                                <input autocomplete="off" type="text" class="form-control parent-input" id="notes"
                                    name="notes" title="يرجي ادخال ملاحظات   " onchange="makenoteoninvoice()"
                                    value="- ">
                            </div>
                            <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                <input type="text" hidden=true class="form-control" id="invoice_number"   value="{{$invoiceId}}"
                                    name="invoice_number" value="{{ $data['invoice_id'] ?? '' }}">
                                <input type="text" hidden=true class="form-control" id="productNo" name="productNo  ">
                                <input type="text" hidden=true class="form-control" id="saveinvice" name="saveinvice"
                                    value=0>
                                <input type="text" hidden=true class="form-control" id="totalvalueinvoice"
                                    name="totalvalueinvoice" value=0>
                                <input hidden=true class="form-control" id="branchs_id" name="branchs_id"
                                    value="{{Auth()->user()->branchs_id}}">
                                <input hidden=true class="form-control" id="user_id" name="user_id"
                                    value="{{Auth()->user()->discount_allow_limit}}">
                                <?php
                                
                                $rate_discount=App\Models\system_setting::find(1);
                                $rate_system=$rate_discount->discount_on_invoice;
                                ?>
                                <input hidden=true class="form-control" id="rate_system" name="rate_system"
                                    value="{{$rate_system}}">
 <input hidden=true class="form-control" id="phone" name="phone"
                                   >
                            </div>
                            <br>

                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="d-flex justify-content-center">
                                <button id="button_1" name="button_1" class="btn btn-success print-style p-2">
                                    {{ __('home.Add') }}
                                    <svg style="width: 22px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                        <path fill="none"
                                            d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z">
                                        </path>
                                    </svg>
                                </button>
                            </div>



                            </form>




                            <br>




                        </div>
                        <?php $i = 0; ?>

                        <div class="col-lg-2">
                            <label for="inputName" class="control-label parent-label"> {{ __('home.Invoice_no') }}
                            </label>
                            <input autocomplete="off" readonly type="text" class="form-control parent-input"
                                id="invoice_show_mo" name="invoice_show_mo" onkeyup="convertToNumberpurchasersPrice()">
                        </div>

                        <br>

                        <table id="example" class="table our-table border mb-0 table-responsive text-center"
                            style="border: 1px solid black;border-collapse: collapse !important;">
                            <col style="width:2%">
                            <col style="width:14%">
                            <col style="width:21%">
                            <col style="width:9%">
                            <col style="width:6%">
                            <col style="width:6%">
                            <col style="width:6%">
                            <col style="width:6%">
                            <col style="width:7%">
                            <col style="width:7%">
                            <col style="width:15%">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th>{{ __('home.productNo') }} </th>
                                    <th>{{ __('home.product') }}</th>
                                    <th> {{ __('home.productprice') }} </th>
                                    <th>{{ __('home.quantity') }}</th>
                                    <th>{{ __('home.reamingquantity') }}</th>
                                    <th>{{ __('home.price') }}</th>
                                    <th>{{ __('home.discount') }}</th>
                                    <th>{{ __('home.addedValue') }}</th>

                                    <th>{{ __('home.total') }}</th>
                                    <th>{{ __('home.operations') }}</th>
                                </tr>
                            </thead>

                            <body style="color: black">
                                <tr style="color: black">
                                    <td style="color:black">-</td>
                                    <td style="color:black">-</td>
                                    <td style="color:black">-</td>
                                    <td style="color:black">-</td>
                                    <td style="color:black">-</td>
                                    <td style="color:black">-</td>
                                    <td style="color:black">-</td>
                                    <td style="color:black">-</td>
                                    <td style="color:black">-</td>
                                    <td style="color:black">-</td>
                                    <td style="color:black">-</td>
                                </tr>

                            </body>
                        </table>


                        <div class="table-responsive mg-t-30">
                            <div class="row">

                                <div class="col-lg-3 mg-t-10 mg-lg-t-0">
                                    <label for="inputName" class="control-label parent-label">
                                        {{ __('home.entertotalafterdescount') }}
                                    </label>
                                    <input autocomplete="off" class="form-control parent-input" id="totaldicount"
                                        name="totaldicount" type="number" onchange="makeDiscountInvoice()">
                                </div>

                                <div class="col-lg-2 mg-t-10 mg-lg-t-0">
                                    <br>
                                    <button style="font-size: 15px; width: 150px;height: 35px;"
                                        class="btn btn-danger p-1 mt-2" onclick="cancelDiscountInvoice()">
                                        {{ __('home.canceldiscount') }}
                                        <svg class="svg-icon-buttons" style="width: 15 !important;height: 15 !important"
                                            viewBox="0 0 20 20">
                                            <path fill="none"
                                                d="M12.71,7.291c-0.15-0.15-0.393-0.15-0.542,0L10,9.458L7.833,7.291c-0.15-0.15-0.392-0.15-0.542,0c-0.149,0.149-0.149,0.392,0,0.541L9.458,10l-2.168,2.167c-0.149,0.15-0.149,0.393,0,0.542c0.15,0.149,0.392,0.149,0.542,0L10,10.542l2.168,2.167c0.149,0.149,0.392,0.149,0.542,0c0.148-0.149,0.148-0.392,0-0.542L10.542,10l2.168-2.168C12.858,7.683,12.858,7.44,12.71,7.291z M10,1.188c-4.867,0-8.812,3.946-8.812,8.812c0,4.867,3.945,8.812,8.812,8.812s8.812-3.945,8.812-8.812C18.812,5.133,14.867,1.188,10,1.188z M10,18.046c-4.444,0-8.046-3.603-8.046-8.046c0-4.444,3.603-8.046,8.046-8.046c4.443,0,8.046,3.602,8.046,8.046C18.046,14.443,14.443,18.046,10,18.046z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>


                            </div>

                            <br>
                            <div class="table-padding">
                                <table class="table border text-md-nowrap mb-0 w-100 text-center our-table mb-2"
                                    id="tableTotalPrice" name="tableTotalPrice" width="50%">
                                    <col style="width:15%">
                                    <col style="width:15%">
                                    <col style="width:15%">
                                    <col style="width:15%">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">{{ __('home.the amount') }}</th>
                                            <th class="border-bottom-0">{{ __('home.discount') }} </th>
                                            <th class="border-bottom-0">{{ __('home.addedValue') }}</th>
                                            <th class="border-bottom-0">{{ __('home.total') }} </th>

                                        </tr>
                                    </thead>

                                    <body>

                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </body>

                                </table>
                            </div>

                        </div>
                        <br>
                        <div class="d-flex justify-content-center">
                            <button style="background-color: #419BB2" id="saveInvoice" name="saveInvoice"
                                class="btn btn-success p-1">
                                {{ __('home.invoice_save') }}
                                <svg style="width: 20px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                    <path fill="none"
                                        d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z">
                                    </path>
                                </svg>
                            </button>
                            &nbsp;
                            
                               <a style="background-color: #419BB2;font-size:15px;width: 120px!important;height:30px"
                                    class="btn btn-success p-1 px-2 fw-bolder" id="pending_invoice"
                                    >{{ __('home.pending_invoice') }}&nbsp;   <svg style="width: 20px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                    <path fill="none"
                                        d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z">
                                    </path>
                                </svg></i></a>

                        </div>
                        <div class="row  d-flex justify-content-end mt-3">


                            <form action="{{ '/' . ($page = 'returnAll') }}" method="POST" role="search"
                                autocomplete="off">
                                {{ csrf_field() }}


                                <input type="number" class="form-control "   value="{{$invoiceId}}" name="invoice_no_delete_All"
                                    id="invoice_no_delete_All" title=" رقم الفاتورة " readonly required=true hidden>
                                <input class="form-control " name="pagename" id="pagename" readonly
                                    value="products.sales" hidden>

                                <div class="col" id="returnAlldiv">




                                </div>






                            </form>
                            <div class=" justify-content-end" id="printdiv">
                                <input type="number" class="form-control " name="show_invoice_number"  value="{{$invoiceId}}"
                                    id="show_invoice_number" title=" رقم الفاتو  رة " readonly required hidden>
                                    
<a style="width: 60px;height: 30px;bottom: 40px;right: 15px;background-color: #25d366;color: #FFF;border-radius: 40px;
  text-align: center;font-size: 30px;box-shadow: 2px 2px 3px #999;z-index: 60;"    id="send_whats_app" target="_blank">
      <i class="bx bxl-whatsapp my-float"></i>
    </a>
                                <a style="background-color: #419BB2;font-size:15px;width: 120px!important;height:30px"
                                    class="btn btn-success p-1 px-2 fw-bolder" id="generate_pdf"
                                    target="_blank">{{ __('home.dwonloadpdf') }}&nbsp;<i
                                        class="fa-solid fa-download"></i></i></a>


                                <button
                                    style="background-color: #419BB2;font-size:15px;width: 120px!important;height:30px"
                                    id="printReciept" class="btn btn-success p-1 px-2 fw-bolder">
                                    {{ __('home.print') }}
                                    <svg style="width: 15px !important" class="svg-icon-buttons" viewBox="0 0 20 20">
                                        <path
                                            d="M17.453,12.691V7.723 M17.453,12.691V7.723 M1.719,12.691V7.723 M18.281,12.691V7.723 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M7.309,13.312h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,13.312,7.309,13.312 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M16.625,6.066h-1.449V3.168c0-0.228-0.186-0.414-0.414-0.414H5.238c-0.228,0-0.414,0.187-0.414,0.414v2.898H3.375c-0.913,0-1.656,0.743-1.656,1.656v4.969c0,0.913,0.743,1.656,1.656,1.656h1.449v2.484c0,0.228,0.187,0.414,0.414,0.414h9.523c0.229,0,0.414-0.187,0.414-0.414v-2.484h1.449c0.912,0,1.656-0.743,1.656-1.656V7.723C18.281,6.81,17.537,6.066,16.625,6.066 M5.652,3.582h8.695v2.484H5.652V3.582zM14.348,16.418H5.652v-4.969h8.695V16.418z M17.453,12.691c0,0.458-0.371,0.828-0.828,0.828h-1.449v-2.484c0-0.228-0.186-0.414-0.414-0.414H5.238c-0.228,0-0.414,0.186-0.414,0.414v2.484H3.375c-0.458,0-0.828-0.37-0.828-0.828V7.723c0-0.458,0.371-0.828,0.828-0.828h13.25c0.457,0,0.828,0.371,0.828,0.828V12.691z M7.309,13.312h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,13.312,7.309,13.312M7.309,15.383h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,15.383,7.309,15.383 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555">
                                        </path>
                                    </svg>
                                </button>



                                <button
                                    style="background-color: #419BB2;font-size:15px;width: 120px!important;height:30px"
                                    id="reciptprinter" class="btn btn-success p-1 px-2 fw-bolder">
                                    {{ __('home.reciptprinter') }}
                                    <svg style="width: 15px !important" class="svg-icon-buttons" viewBox="0 0 20 20">
                                        <path
                                            d="M17.453,12.691V7.723 M17.453,12.691V7.723 M1.719,12.691V7.723 M18.281,12.691V7.723 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M7.309,13.312h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,13.312,7.309,13.312 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M16.625,6.066h-1.449V3.168c0-0.228-0.186-0.414-0.414-0.414H5.238c-0.228,0-0.414,0.187-0.414,0.414v2.898H3.375c-0.913,0-1.656,0.743-1.656,1.656v4.969c0,0.913,0.743,1.656,1.656,1.656h1.449v2.484c0,0.228,0.187,0.414,0.414,0.414h9.523c0.229,0,0.414-0.187,0.414-0.414v-2.484h1.449c0.912,0,1.656-0.743,1.656-1.656V7.723C18.281,6.81,17.537,6.066,16.625,6.066 M5.652,3.582h8.695v2.484H5.652V3.582zM14.348,16.418H5.652v-4.969h8.695V16.418z M17.453,12.691c0,0.458-0.371,0.828-0.828,0.828h-1.449v-2.484c0-0.228-0.186-0.414-0.414-0.414H5.238c-0.228,0-0.414,0.186-0.414,0.414v2.484H3.375c-0.458,0-0.828-0.37-0.828-0.828V7.723c0-0.458,0.371-0.828,0.828-0.828h13.25c0.457,0,0.828,0.371,0.828,0.828V12.691z M7.309,13.312h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,13.312,7.309,13.312M7.309,15.383h5.383c0.229,0,0.414-0.187,0.414-0.414s-0.186-0.414-0.414-0.414H7.309c-0.228,0-0.414,0.187-0.414,0.414S7.081,15.383,7.309,15.383 M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484 M12.691,12.484H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,12.484,12.691,12.484M12.691,14.555H7.309c-0.228,0-0.414,0.187-0.414,0.414s0.187,0.414,0.414,0.414h5.383c0.229,0,0.414-0.187,0.414-0.414S12.92,14.555,12.691,14.555">
                                        </path>
                                    </svg>
                                </button>

                           

                            </div>

                        </div>

                    </div>

                </div>









                <!-- row closed -->
            </div>
            <!-- Container closed -->
        </div>
        <!--search  -->


        <div class="modal p-3" id="createproduct">
            <div style="margin: 0 9% !important;" class="modal-dialog modal-dialog-centered modal-special"
                role="document">
                <div class="modal-content modal-content-demo p-3">
                    <form>
                        <div class="modal-header">
                            <h6 class="modal-title"> {{ __('supprocesses.addproduct') }} </h6><button aria-label="Close"
                                class="close close-special" data-dismiss="modal" type="button"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        {{ csrf_field() }}
                        <div class="row mb-2">
                            <div class="col mb-2">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('supprocesses.product_name_ar') }}</label>
                                <input autocomplete=off type="text" class="form-control parent-input"
                                    id="product_name_ar" name="product_name_ar"
                                    title="{{ __('supprocesses.product_name_ar') }}" onkeyup="translateNameToEnglish()"
                                    required>
                            </div>


                            <div class="col mb-2">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('supprocesses.product_name_en') }}</label>
                                <input autocomplete=off type="text" class="form-control parent-input"
                                    id="product_name_en" name="product_name_en"
                                    title="{{ __('supprocesses.product_name_en') }}" onkeyup="translateNameToArbic()"
                                    required>
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
                                    @if(Auth()->user()->branch->id!=$section->id)
                                    <option value="{{ $section->id }}"> {{ $section->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 mb-2">
                                <label for="inputName"
                                    class="control-label parent-label">{{ __('home.groups') }}</label>
                                <select style="width:100%!important" name="product_group" id="product_group"
                                    class="form-control select2">
                                    <!--placeholder-->
                                    @foreach (App\Models\products_group::get() as $section)
                                    <option value="{{ $section->id }}"> {{ $section->group_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 mb-2">
                                <label for="inputName"
                                    class="control-label parent-label">{{ __('home.MAINproduct') }}</label>
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
                                <input autocomplete="off" type="text" class="form-control parent-input" id="cost_price" name="cost_price" value=0 onkeyup="convertToNumberpurchasersPrice()">
                            </div>
                            <div class="col-lg-4">
                                <label for="inputName" class="control-label parent-label" required>{{ __('home.salepice') }} </label>
                                <input autocomplete="off" type="text" class="form-control parent-input" id="sale_price_create" value=0  name="sale_price_create" onkeyup="convertToNumbersalePrice()">
                            </div>   
                            <div class="col-lg-4">
                                <label for="inputName" class="control-label parent-label" required>{{ __('home.quantity') }} </label>
                                <input autocomplete="off" type="text" class="form-control parent-input" id="quantity_create" value=0   name="quantity_create" onkeyup="convertToNumbersalePrice()">
                            </div>

</div>



                        {{-- 5 --}}
                        <div class="row mb-2">
                            <div class="col-lg-4 mb-2" style="direction: ltr !important;">

                                <label for="inputName" class="control-label parent-label">
                                    {{ __('supprocesses.product_location') }}</label>
                                <input dir="ltr" style="direction:LTR !important ;text-align:start!important;"
                                    type="text" class="form-control parent-input" id="product_location_create"
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
                                <input type="text" class="form-control parent-input" id="product_notes"
                                    name="product_notes" title="{{ __('supprocesses.product_notes') }}">
                            </div>

                            <div class="col-lg-4 mb-2">
                                <input type="text" class="form-control parent-input" id="product_name_en"
                                    name="product_name_en" title=" {{ __('supprocesses.product_name_en') }}" hidden>
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






        {{-- Update ( 24/4/2023 ) --}}

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
                                    <input autocomplete="off" dir="ltr" type="text" autofocus
                                        class="form-control parent-input"
                                        placeholder="{{ __('home.Search By Name or Product Number') }}"
                                        id="searchaboutproduct" name="searchaboutproduct"
                                        onkeyup="searchaboutproductfunction()" autofocus>
                                </div>
                                <div class="col-lg-3 mb-2">
                                    <label for="inputName"
                                        class="control-label parent-label">{{ __('home.groups') }}</label>
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
                                <table class="table text-md-nowrap text-center our-table" id="SearchProductTable"
                                    width="100%" style="border: 2px solid rgba(0,0,0,.3);">
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
                                            <th style="font-size: 15px" class="border-bottom-0"
                                                style="text-align:center">{{__('home.product')}}</th>
                                            <th style="font-size: 15px" class="border-bottom-0"
                                                style="text-align:center">{{__('home.branch')}}</th>
                                            <th style="font-size: 15px" class="border-bottom-0"
                                                style="text-align:center">{{__('home.productlocation')}}</th>

                                            <th style="font-size: 15px" class="border-bottom-0">{{__('home.quantity')}}
                                            </th>
                                            <th style="font-size: 13px" class="border-bottom-0">
                                                {{__('home.purchaseproductwithouttax')}}</th>
                                            <th style="font-size: 13px" class="border-bottom-0">
                                                {{__('home.sellingproduct without tax')}}</th>
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
                            {{-- <button id="added_product" name="added_product" id="added_product" class="btn btn-primary">{{__('home.confirm')}}</button>
                            --}}
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{__('home.cancel')}}</button>
                        </div>

                    </div>


                </div>
            </div>

        </div>


        {{-- End Update ( 24/4/2023 ) --}}



        <!-- edit -->
        <div class="modal fade" id="increaseProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div style="margin: 5% !important;" class="modal-dialog modal-special" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('home.addtoSales') }}</h5>
                        <button type="button" class="close choose-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form
                            action="{{ url(Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() . '/' . ($page = 'updatePurchase')) }}"
                            method="post" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="hidden" name="id_update" id="id_update" value="">
                                <label for="recipient-name" class="col-form-label"> {{ __('home.product') }}
                                </label>
                                <input class="form-control" name="product_name_update" id="product_name_update"
                                    readonly>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label parent-label">
                                        {{ __('home.saleperpice') }}</label>
                                    <input autocomplete="off" type="text" class="form-control parent-input"
                                        id="priceWithTax_update" name="priceWithTax_update"
                                        onchange="changePriceWithTaxUpdate()"
                                        onkeyup="convertToNumberPricewithTaxSale()" required>
                                </div>
                                <div class="col">
                                    <label for="inputName" class="control-label parent-label">
                                        {{ __('home.sellingproduct without tax') }}</label>
                                    <input type="text" class="form-control parent-input" id="product_price_update"
                                        name="product_price_update"
                                        onchange="changeAvtValueupdatewithodtaxupdate('{{ $avtSaleRate }}')"
                                        onkeyup="changeAvtValuempdale()" required>
                                </div>
                                <div class="col">
                                    <label for="inputName" class="control-label parent-label"> {{ __('home.avt') }}
                                    </label>
                                    <input type="text" class="form-control parent-input" id="avt_update"
                                        name="avt_update" title="يرجي ادخال الكمية  " value="{{ $avtSaleRate }}"
                                        readonly>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col">
                                    <label for="inputName" class="control-label parent-label">
                                        {{ __('home.discount') }}</label>
                                    <input type="text" class="form-control parent-input"
                                        id="product_price_after_dis_update" value=0
                                        name="product_price_after_dis_update"
                                        onkeyup="checkdiscount_rate_allow_update()">
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label parent-label"> {{ __('home.quantity') }}
                                    </label>
                                    <input type="text" class="form-control parent-input" id="quantity_update"
                                        name="quantity_update" title="يرجي ادخال الكمية  " value=1 required>
                                </div>
                            </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{__('home.cancel')}}</button>
                        <button id="updateproductalldata" name="updateproductalldata"
                            class="btn btn-danger">{{ __('home.confirm') }}</button>
                    </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"> {{ __('home.Retrieveall') }} </h6><button aria-label="Close"
                            class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form
                        action="{{ url(Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() . '/' . ($page = 'EditInvoices')) }}"
                        method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>{{ __('home.Are_you_sure') }}</p><br>
                            <input type="hidden" name="id_delete" id="id_delete">
                            <input type="hidden" name="return_quentity_delete" id="return_quentity_delete">
                            <input class="form-control parent-input" name="product_name" id="product_name" type="text"
                                readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('home.cancel') }}</button>
                            <button id="deleteproduct" name="deleteproduct"
                                class="btn btn-danger">{{ __('home.confirm') }}</button>
                        </div>
                </div>
                </form>
            </div>
        </div>


        <div class="modal" class="body_calculator" style="position: fixed;
top: 0;right: 40%;left:35%;justify-content: center;width:400px;" id="calculter_modale" dir=ltr>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-body">


                        <div class="calculator">
                            <input type="text" id="display">
                            <div class="buttons">
                                <button class="button" onclick="appendToDisplay('1')">1</button>
                                <button class="button" onclick="appendToDisplay('2')">2</button>
                                <button class="button" onclick="appendToDisplay('3')">3</button>
                                <button class="button" onclick="appendToDisplay('+')">+</button>

                                <button class="button" onclick="appendToDisplay('4')">4</button>
                                <button class="button" onclick="appendToDisplay('5')">5</button>
                                <button class="button" onclick="appendToDisplay('6')">6</button>
                                <button class="button" onclick="appendToDisplay('-')">-</button>

                                <button class="button" onclick="appendToDisplay('7')">7</button>
                                <button class="button" onclick="appendToDisplay('8')">8</button>
                                <button class="button" onclick="appendToDisplay('9')">9</button>
                                <button class="button" onclick="appendToDisplay('*')">*</button>

                                <button class="button" onclick="appendToDisplay('0')">0</button>
                                <button class="button" onclick="appendToDisplay('.')">.</button>
                                <button class="button" onclick="calculate()">=</button>
                                <button class="button" onclick="appendToDisplay('/')">/</button>

                                <button class="button" onclick="clearDisplay()">C</button>
                                <button class="button" onclick="appendToDisplay('0')">0</button>
                                <button class="button" onclick="calculate()">=</button>
                                <button type="button" class="btn btn-danger"
                                    data-dismiss="modal">{{ __('home.cancel') }}</button>


                            </div>
                        </div>

                    </div>
                </div>


            </div>


        </div>


        <!-- enter payments -->
        <div class="modal" id="paymentmethod">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"> {{ __('home.paymentmethod') }} </h6>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label style="font-size:16px"
                                class="control-label parent-label">&nbsp;&nbsp;{{ __('home.total') }} :&nbsp; </label>
                            <label style="font-size:20px" id="totalvalue">0</label>
                            <label style="font-size:15px" class="control-label parent-label">&nbsp;{{ __('home.SAR') }}
                                &nbsp;&nbsp;&nbsp;&nbsp; </label>
                            <br>


                        </div>
                        <div class=" col">
                            <label> {{ __('home.paymentmethod') }} </label>
                            <br>

                            <select class="form-control" name="paymodal" id='paymodal' required>

                                <option id="cash_id" value="Cash"> {{ __('report.cash') }}</option>
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
                                <input type="text" class="form-control parent-input" name="cashamount" id="cashamount"
                                    onkeyup="calcCash()" readonly value=0>
                            </div>

                            <div class="col">

                                <label class="control-label parent-label">{{ __('report.shabka') }}</label>
                                <input type="text" class="form-control parent-input" name="bankamount" id="bankamount"
                                    readonly value=0>
                            </div>

                            <div class="col">

                                <label class="control-label parent-label">{{ __('home.Bank_transfer') }}</label>
                                <input type="text" class="form-control parent-input" name="Bank_transfer"
                                    id="Bank_transfer" readonly value=0>
                            </div>
                            <div class="col">

                                <label class="control-label parent-label">{{ __('report.credit') }}</label><br>
                                <input type="text" class="form-control parent-input" name="creaditamount"
                                    id="creaditamount" readonly value=0>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('home.cancel') }}</button>
                        <button id="confirmpayment" name="confirmpayment" data-dismiss="modal"
                            class="btn btn-danger">{{ __('home.confirm') }}</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- delete -->

    </div>
</div>
{{-- End Update ( 241/4/2023 ) --}}
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





<div class="modal fade product-selection"
    style="background-color: rgba(0, 0, 0, 0)!important;color: rgba(0, 0, 0, 0)!important;" id="loading" name="loading"
    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" dir='rtl' aria-hidden="true">
    <div class="modal-dialog modal-xl"
        style="background-color: rgba(0, 0, 0, 0)!important;color: rgba(0, 0, 0, 0)!important;" role="document">
        <div class="modal-content">

            <div class="modal-body" style="justify-content: center;">


                <center><img style="width:250px;height:250px;" class="custom_img"
                        src="{{ asset('assets/admin/uploads/loading.png') }}">

                </center>




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
                                    <input type="number" class="parent-input form-control" id="balance" name="balance"
                                        title="يرجي ادخال الكمية  " value="{{ $data['customer']->Balance ?? '0' }}"
                                        >
                                </div> -->
                </div>

                {{-- 2 --}}
                <div class="row mb-1">
                    <div class="col-lg-3 col-md-3">
                        <label style="font-size: 12px;" for="inputName" class="control-label parent-label">
                            {{ __('supprocesses.timeout_periodـinـdays') }}</label>
                        <input style="height:32px" type="number" class="form-control parent-input"
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
                        <input style="height:32px" type="text" class="form-control parent-input" id="CRN"
                            name="CRN" onkeyup="TaxـNumberConvert() "value=0  title="{{ __('supprocesses.TaxـNumber') }}">
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
                            title="{{ __('home.postcode') }}" value='11461' required>
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


{{-- End Update ( 24/4/2023 ) --}}
<div class="modal fade product-selection" id="main_product2" name="main_product2" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" dir='rtl' aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="table-responsive" id="ajax_responce_main_product_Div2">


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




<!-- main-content closed -->

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
let display = document.getElementById("display");

function appendToDisplay(value) {
    display.value += value;
}

function clearDisplay() {
    display.value = '';
}

function calculate() {
    try {
        display.value = eval(display.value);
    } catch (e) {
        display.value = 'Error';
    }
}
$("#calculter").click(function(e) {

    $('#calculter_modale').modal().show();

})
</script>
<script>
$("#sendzatca").click(function(e) {
    document.getElementById('loading-screen').style.display = 'block'; // show loading screen

    var url = " {{ URL::to('sendzatca_fromsale') }}" + '/' + $('#show_invoice_number').val();
    console.log(url)
    document.getElementById('sendzatca').hidden = true

    token_search = $('#token_search').val();
    $.ajax({
        url: url,
        type: 'GET',
        cache: false,
        dataType: "html",



        success: function(data) {

            if (data == 1) {
                document.getElementById('loading-screen').style.display =
                'none'; // Hide loading screen

                var audio = new Audio('/sounds/done.mp3');
                audio.play();
                document.getElementById('dwonloadxml').hidden = false
                document.getElementById('sendzatca').hidden = true
                $('#massagesave').modal().show();
                setTimeout(() => {
                    $('#massagesave').modal('hide');

                }, 1000);
            } else {
                $('#massagesave').modal('hide');

                alert(data)
                document.getElementById('sendzatca').hidden = false

            }
        },
        error: function(response) {
            console.log(response)

        }
    });


});

$("#dwonloadxml").click(function(e) {
    var url = " {{ URL::to('dwonloadxml') }}" + '/' + $('#show_invoice_number').val();
    console.log(url)

    window.open(url, '_blank');

})

$('select[name="product_group"]').on('change', function() {
    var selectclientid = $(this).val();
    var token_search = $("#token_search").val();
    if (selectclientid) {
        $.ajax({
            url: "{{ URL::to('product_sale_group_ajax') }}",
            type: 'post',
            cache: false,
            dataType: 'html',
            data: {
                "_token": token_search,
                "group_id": selectclientid,
            },
            success: function(products) {
                $("#ajax_responce_serarchDiv").html(products);

            },

            error: function(response) {
                console.log(response)
            }
        });
    } else {
        console.log('AJAX load did not work');
    }
});

function translateNameToArbic() {
    var wordEnglish = $('#product_name_en').val();

    jQuery.ajax({
        url: "https://translate.googleapis.com/translate_a/single?client=gtx&dt=t&sl=en&tl=ar&q=" + wordEnglish,
        type: 'get',
        cache: false,

        success: function(request_result) {
            $('#product_name_ar').val(request_result[0][0][0])
        },
        error: function() {

        }
    });


}

function translateNameToEnglish() {
    var wordarbic = $('#product_name_ar').val();

    jQuery.ajax({
        url: "https://translate.googleapis.com/translate_a/single?client=gtx&dt=t&sl=ar&tl=en&q=" + wordarbic,
        type: 'get',
        cache: false,

        success: function(request_result) {
            $('#product_name_en').val(request_result[0][0][0])
        },
        error: function() {

        }
    });


}

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


                success: function(data) {
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




$(document).on('click', '#ajax_pagination_in_search a', function(e) {
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
        success: function(data) {
            $("#ajax_responce_serarchDiv").html(data);
        },
        error: function() {

        }
    });
});

//     function checkquentity() {
//         if($('#quantity').val()*1<=$('#avaliable_quentity').val()*1){

//         }else
//         {
//                       $('#product_name').val('');
//         $('#product_location').val('');
//         $('#avaliable_quentity').val('');
//         $('#quantity').val('');
//         $('#product_price').val(''); 
//         $('#purchase_price').val('');
//         avtsale = $('#avtValue').val();
//         $('#avt').val('');
//         $('#priceWithTax').val();
// alert('يجب ان تكون  كمية المنتج المدخلة اصغر او تساوي الكمية المتوفرة في المخزون شكرا    \n. Sorry, the amount sold must be less than or equal to the quantity available in stock.')
//         }

//     }


function getproduct() {
    searchtext = $('#product_code').val();
    branchs_id = $('#branchs_id').val();

    if (searchtext != '') {

        jQuery.ajax({
            url: " {{URL::to('detproductbycode')}}/" + searchtext + "/" + branchs_id,
            type: 'get',
            cache: false,
            dataType: "json",


            success: function(data) {

                name = data['product_name']
                location1 = data['Product_Location']
                availablequantity = data['numberofpice']
                price = data['purchasingـprice']
                sale_price = data['sale_price']
                code = data['id']
                $("#productNo").val(code);

                $('#product_name').val(name);
                $('#product_location').val(location1);
                $('#avaliable_quentity').val(availablequantity);
                $('#quantity').val(1);
                $('#product_price').val(sale_price);
                $('#purchase_price').val(price);
                avtsale = $('#avtValue').val();
                $('#avt').val((sale_price * avtsale).toFixed(2));
                $('#priceWithTax').val(((sale_price * avtsale) + (sale_price * 1)).toFixed(2));

                $.ajax({
                    url: "{{ URL::to('/getlastprice') }}/" + $("#productNo").val() + "/" + $(
                        '#clientnamesearch').val(),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data)
                        if (data == 0) {
                            $('#lastpricecustomer').val('Not Found');

                        } else {
                            $('#lastpricecustomer').val(data);

                        }

                    }
                })
            },
            error: function() {

            }
        });
    }

}





document.addEventListener('keydown', (e) => {
    if ((e.key.toLowerCase() === 'z' || e.key == 'ئ')) {
        event.preventDefault();


        show_cost_profit = $('#show_cost_profit').val();
        if (show_cost_profit == 1) {
            document.getElementById('div_show_cost').hidden = false;
            document.getElementById('div_show_profit').hidden = false;
            document.getElementById('div_show_total_profit').hidden = false;
            $('#show_cost_profit').val(0)

        } else if (show_cost_profit == 0) {

            document.getElementById('div_show_cost').hidden = true;
            document.getElementById('div_show_profit').hidden = true;
            document.getElementById('div_show_total_profit').hidden = true;
            $('#show_cost_profit').val(1)


        } else {

        }
    }
})

function display_appear_function() {




    show_cost_profit = $('#show_cost_profit').val();
    if (show_cost_profit == 1) {
        document.getElementById('div_show_cost').hidden = false;
        document.getElementById('div_show_profit').hidden = false;
        document.getElementById('div_show_total_profit').hidden = false;
        $('#show_cost_profit').val(0)

    } else if (show_cost_profit == 0) {

        document.getElementById('div_show_cost').hidden = true;
        document.getElementById('div_show_profit').hidden = true;
        document.getElementById('div_show_total_profit').hidden = true;
        $('#show_cost_profit').val(1)


    } else {

    }
}

function replaceproductorginal(id) {
    branchs_id = $('#branchs_id').val();
    console.log(branchs_id)
    console.log(" {{URL::to('replaceproducts')}}/" + branchs_id + "/" + id)
    jQuery.ajax({
        url: " {{URL::to('replaceproducts')}}/" + branchs_id + "/" + id,
        type: 'get',
        dataType: 'html',
        cache: false,

        success: function(data) {
            console.log('done')

            $('#main_product2').modal().show();

            $("#ajax_responce_main_product_Div2").html(data);

        },
        error: function() {

        }
    });


}





document.addEventListener('keydown', (e) => {
    if (e.ctrlKey && (e.key.toLowerCase() === 'Q' || e.key == 'ض')) {
         {
            branchs_id = $('#branchs_id').val();
            id = $('#productNo').val()
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

    }

})



document.addEventListener('keydown', (e) => {
    if (event.keyCode === 13) {
        event.preventDefault();
        var url = $(this).attr('data-action');
        let table = document.getElementById("example");


        var token_search = $("#token_search").val();

        console.log(" {{ URL::to('AddInvoices') }}");

        var url = " {{ URL::to('AddInvoices') }}";
        token_search = $('#token_search').val();
        productNo = $('#productNo').val();
        invoice_number = $('#invoice_number').val();
        product_name = $('#product_name').val();
        product_price_after_dis = $('#product_price_after_dis').val();
        quantity = $('#quantity').val();
        avaliablequantity = $('#avaliable_quentity').val();
        pay = $('#paymodal').val();
        clientnamesearch = $('#clientnamesearch').val();
        creditlimit = $('#creditlimit').val();
        purchase_price = $('#purchase_price').val();
                P_O = $('#P_O').val();

        if ($('#clientnamesearch').val() == 0) {

            alert("{{ __('home.chooseclient') }}")

        } else {

            if ($('#saveinvice').val() == 1) {
                document.getElementById('printdiv').hidden = true
                document.getElementById('returnAlldiv').hidden = true
                $('#Bank_transfer').val(0)
                $('#creaditamount').val(0)
                $('#bankamount').val(0)
                $('#cashamount').val(0)
                            $("#paymodal").val("Cash").change();


                $.ajax({
                    url: url,
                    type: 'post',
                    cache: false,

                    data: {
                        _token: token_search,
                        productNo: $('#productNo').val(),
                        invoice_number: null,
                        product_name: $('#product_name').val(),
                       product_price_after_dis:  ($('#product_price_after_dis').val()),
                        quantity: $('#quantity').val(),
                        pay: $('#paymodal').val(),
                        clientnamesearch: $('#clientnamesearch').val(),
                        creditlimit: $('#creditlimit').val(),
                        product_price: $('#product_price').val(),
                        purchase_price: $('#purchase_price').val(),
                        note: $('#notes').val() ?? '-',
                        unit_pice: $('#unit_pice').val(),
P_O:P_O


                    },


                    success: function(data) {
                        $('#saveinvice').val(2)
                        $('#product_code').val('');
                        $('#total_profit').val(data['total_profit']);

                        // const map =(JSON.parse(response));
                        if (data[0] == "notfount") {
                            alert("{{ __('home.stocknotAvailable') }}");
                        } else {



                            $('#show_invoice_number').val(data['invoice_number'])
                            $('#invoice_number').val(data['invoice_number']);
                            $('#showInvoiceNumber').val(data['invoice_number']);
                            $('#invoice_no_delete_All').val(data['invoice_number']);



                            var tableHeaderRowCount = 1;

                            var rowCount = table.rows.length;

                            for (var i = tableHeaderRowCount; i < rowCount; i++) {
                                table.deleteRow(tableHeaderRowCount);
                            }
                            count1 = 0;
                            added_value_total = 0;
                            total_sales = 0;

                            data['product'].forEach(async (product) => {


                                sales_id = product['id'],
                                    count1 = product['count'],
                                    product_code = product['Product_Code']
                                product_name = product['product_name']
                                quentity = product['quantity']
                                price = product['Unit_Price']
                                discount = product['Discount_Value']
                                addedvalue = product['Added_Value']
                                reamingquantity = product['reamingquantity']
                                total = product['Unit_Price'] * product[
                                        'quantity'] + product['Added_Value'] *
                                    product['quantity']
                                added_value_total = added_value_total + (
                                    product['Added_Value'] * product[
                                        'quantity'])
                                total_sales = total_sales + (price * product[
                                    'quantity'])
                                console.log(product_name);
                                text1 =
                                    '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                                result = text1.concat("onclick=", "decreaseProduct(",
                                    sales_id, ",", "1",
                                    ")>",
                                    '<i " class="las la-minus"></i>',
                                    "</button> ")
                                product_name_update = product_name.replaceAll(" ", "?")
                                text2 =
                                    ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                                result2 = text2.concat(sales_id, "  ",
                                    "data-section_name=", product_name_update,
                                    "  ", "data-return_quentity=", quentity, '  ',
                                    '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                                )

                                update =
                                    ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                                update = update.concat(sales_id, "  ",
                                    "data-section_name=", product_name_update, "  ",
                                    "data-section_price=", price, "  ",
                                    "data-section_discount=", discount,
                                    "  ", "data-return_quentity=", quentity, '  ',
                                    '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                                )
                                text3 =
                                    '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                                result3 = text3.concat("onclick=", "increaseProduct(",
                                    sales_id, ",", "1",
                                    ")>",
                                    '<i class="las la-plus"></i>',
                                    "</button> ")

                                if (quentity > 0) {


                                    let table = document.getElementById("example");
                                    let row = table.insertRow(-
                                    1); // We are adding at the end

                                    let c1 = row.insertCell(0);
                                    let c2 = row.insertCell(1);
                                    let c3 = row.insertCell(2);
                                    let c4 = row.insertCell(3);
                                    let c5 = row.insertCell(4);
                                    let c6 = row.insertCell(5);
                                    let c7 = row.insertCell(6);
                                    let c8 = row.insertCell(7);
                                    let c9 = row.insertCell(8);
                                    let c10 = row.insertCell(9);
                                    let c11 = row.insertCell(10);

                                    // Add data to c1 and c2

                                    c1.innerText = count1
                                    c2.innerHTML = ' <span dir=ltr>' + product_code +
                                        '</span>'
                                    c3.innerText = product_name
                                    c4.innerText = ((Math.round(price * 100) / 100)
                                        .toFixed(2))
                                    c5.innerText = quentity
                                    c6.innerText = product['reamingquantity']
                                    c7.innerText = ((Math.round((price * quentity) *
                                        100) / 100).toFixed(2))
                                    c8.innerText = ((Math.round(discount * 100) / 100)
                                        .toFixed(2))
                                    tax = Math.round(((price * quentity) - discount) *
                                        0.15 * 100) / 100
                                    c9.innerText = tax
                                    c10.innerText = Math.round(((price * quentity) +
                                        tax - discount) * 100) / 100
                                    c11.innerHTML = result + ' ' + result3 + ' ' + ' ' +
                                        update + result2






                                }


                            });


                            //    update3/3/2023


                            let tableTotalPrice = document.getElementById(
                                "tableTotalPrice");
                            var tableHeaderRowCount = 1;

                            var rowCount = tableTotalPrice.rows.length;

                            for (var i = tableHeaderRowCount; i < rowCount; i++) {
                                tableTotalPrice.deleteRow(tableHeaderRowCount);
                            }
                            let row = tableTotalPrice.insertRow(-
                                1); // We are adding at the end

                            let c1 = row.insertCell(0);
                            let c2 = row.insertCell(1);
                            let c3 = row.insertCell(2);
                            let c4 = row.insertCell(3);


                            // Add data to c1 and c2


                            c1.innerText = (Math.round(data['invoicetotal_price'] * 100) / 100)
                                .toFixed(2);
                            c2.innerText = (Math.round(data['invoicetotal_addedvalue'] * 100) / 100)
                                .toFixed(2);
                            c3.innerText = (Math.round(data['invoicetotal_discount'] * 100) / 100)
                                .toFixed(2);
                            c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;



                            document.getElementById('totalvalue').innerHTML = ((Math.round(data[
                                'invoicetotal_price'] * 100) / 100).toFixed(2) * 1) + ((Math
                                    .round(data['invoicetotal_addedvalue'] * 100) / 100)
                                .toFixed(2) * 1);
                            ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(2) * 1) +
                            ((Math.round(data['invoicetotal_addedvalue'] * 100) / 100).toFixed(2) *
                                1);
                            $('#totalvalueinvoice').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))

                            $('#totalvalueinvoice').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))
                            if ($('#pay').val() == "Cash") {
                                $('#cashamount').val((Math.round((data['invoicetotal_addedvalue'] +
                                    data['invoicetotal_price']) * 100) / 100).toFixed(2))
                            } else if (('#pay').val() == "Shabka") {
                                $('#bankamount').val((Math.round((data['invoicetotal_addedvalue'] +
                                    data['invoicetotal_price']) * 100) / 100).toFixed(2))

                            } else {
                                $('#creaditamount').val((Math.round((data[
                                    'invoicetotal_addedvalue'] + data[
                                        'invoicetotal_price']) * 100) / 100).toFixed(2))

                            }


                            var rowCount = table.rows.length;

                            for (var i = 0; i < rowCount; i++) {
                                var data = table.rows[i].innerText.innerText;
                                console.log('end');

                            }




                            $('#product_name').val('');
                            $('#product_price_after_dis').val(0);
                            $('#quantity').val(1);
                            $('#avaliable_quentity').val('');
                            $('#product_location').val('');
                            $('#product_price').val('');
                            $('#purchase_price').val('');
                            $('#productNo').val("__('home.searchbyproductnumber')");
                            $('#priceWithTax').val('');

                        }

                        $('#saveinvice').val(0);



                    },
                    error: function(response) {
                        alert("{{ __('home.sorryerror') }}")

                    }
                });
            } else if (product_name == '') {
                alert("{{ __('home.pleaseChooseProduct') }}")

            } else {
                $.ajax({
                    url: url,
                    type: 'post',
                    cache: false,

                    data: {
                        _token: token_search,
                        productNo: $('#productNo').val(),
                        invoice_number: $('#invoice_number').val(),
                        product_name: $('#product_name').val(),
                        product_price_after_dis:  ($('#product_price_after_dis').val()),
                        quantity: $('#quantity').val(),
                        pay: $('#paymodal').val(),
                        clientnamesearch: $('#clientnamesearch').val(),
                        creditlimit: $('#creditlimit').val(),
                        product_price: $('#product_price').val(),
                        purchase_price: $('#purchase_price').val(),
                        note: $('#notes').val() ?? '-',
                        unit_pice: $('#unit_pice').val(),
P_O:P_O


                    },


                    success: function(data) {
                        $('#saveinvice').val(2)
                        $('#product_code').val('');
                        $('#total_profit').val(data['total_profit']);

                        // const map =(JSON.parse(response));
                        if (data[0] == "notfount") {
                            alert("{{ __('home.stocknotAvailable') }}");
                        } else {



                            $('#show_invoice_number').val(data['invoice_number'])
                            $('#invoice_number').val(data['invoice_number']);
                            $('#showInvoiceNumber').val(data['invoice_number']);
                            $('#invoice_no_delete_All').val(data['invoice_number']);



                            var tableHeaderRowCount = 1;

                            var rowCount = table.rows.length;

                            for (var i = tableHeaderRowCount; i < rowCount; i++) {
                                table.deleteRow(tableHeaderRowCount);
                            }
                            count1 = 0;
                            added_value_total = 0;
                            total_sales = 0;

                            data['product'].forEach(async (product) => {


                                sales_id = product['id'],
                                    count1 = product['count'],
                                    product_code = product['Product_Code']
                                product_name = product['product_name']
                                quentity = product['quantity']
                                price = product['Unit_Price']
                                discount = product['Discount_Value']
                                addedvalue = product['Added_Value']
                                reamingquantity = product['reamingquantity']
                                total = product['Unit_Price'] * product[
                                        'quantity'] + product['Added_Value'] *
                                    product['quantity']
                                added_value_total = added_value_total + (
                                    product['Added_Value'] * product[
                                        'quantity'])
                                total_sales = total_sales + (price * product[
                                    'quantity'])
                                console.log(product_name);
                                text1 =
                                    '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                                result = text1.concat("onclick=", "decreaseProduct(",
                                    sales_id, ",", "1",
                                    ")>",
                                    '<i " class="las la-minus"></i>',
                                    "</button> ")
                                product_name_update = product_name.replaceAll(" ", "?")
                                text2 =
                                    ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                                result2 = text2.concat(sales_id, "  ",
                                    "data-section_name=", product_name_update,
                                    "  ", "data-return_quentity=", quentity, '  ',
                                    '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                                )

                                update =
                                    ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                                update = update.concat(sales_id, "  ",
                                    "data-section_name=", product_name_update, "  ",
                                    "data-section_price=", price, "  ",
                                    "data-section_discount=", discount,
                                    "  ", "data-return_quentity=", quentity, '  ',
                                    '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                                )
                                text3 =
                                    '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                                result3 = text3.concat("onclick=", "increaseProduct(",
                                    sales_id, ",", "1",
                                    ")>",
                                    '<i class="las la-plus"></i>',
                                    "</button> ")

                                if (quentity > 0) {


                                    let table = document.getElementById("example");
                                    let row = table.insertRow(-
                                    1); // We are adding at the end
                                    let c1 = row.insertCell(0);
                                    let c2 = row.insertCell(1);
                                    let c3 = row.insertCell(2);
                                    let c4 = row.insertCell(3);
                                    let c5 = row.insertCell(4);
                                    let c6 = row.insertCell(5);
                                    let c7 = row.insertCell(6);
                                    let c8 = row.insertCell(7);
                                    let c9 = row.insertCell(8);
                                    let c10 = row.insertCell(9);
                                    let c11 = row.insertCell(10);

                                    // Add data to c1 and c2

                                    c1.innerText = count1
                                    c2.innerHTML = ' <span dir=ltr>' + product_code +
                                        '</span>'
                                    c3.innerText = product_name
                                    c4.innerText = ((Math.round(price * 100) / 100)
                                        .toFixed(2))
                                    c5.innerText = quentity
                                    c6.innerText = product['reamingquantity']
                                    c7.innerText = ((Math.round((price * quentity) *
                                        100) / 100).toFixed(2))
                                    c8.innerText = ((Math.round(discount * 100) / 100)
                                        .toFixed(2))
                                    tax = Math.round(((price * quentity) - discount) *
                                        0.15 * 100) / 100
                                    c9.innerText = tax
                                    c10.innerText = Math.round(((price * quentity) +
                                        tax - discount) * 100) / 100
                                    c11.innerHTML = result + ' ' + result3 + ' ' + ' ' +
                                        update + result2








                                }


                            });


                            //    update3/3/2023


                            let tableTotalPrice = document.getElementById(
                                "tableTotalPrice");
                            var tableHeaderRowCount = 1;

                            var rowCount = tableTotalPrice.rows.length;

                            for (var i = tableHeaderRowCount; i < rowCount; i++) {
                                tableTotalPrice.deleteRow(tableHeaderRowCount);
                            }
                            let row = tableTotalPrice.insertRow(-
                                1); // We are adding at the end

                            let c1 = row.insertCell(0);
                            let c2 = row.insertCell(1);
                            let c3 = row.insertCell(2);
                            let c4 = row.insertCell(3);


                            // Add data to c1 and c2


                            c1.innerText = (Math.round(data['invoicetotal_price'] * 100) / 100)
                                .toFixed(2);
                            c2.innerText = (Math.round(data['invoicetotal_addedvalue'] * 100) / 100)
                                .toFixed(2);
                            c3.innerText = (Math.round(data['invoicetotal_discount'] * 100) / 100)
                                .toFixed(2);
                                                     c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;


                            document.getElementById('totalvalue').innerHTML = ((Math.round(data[
                                'invoicetotal_price'] * 100) / 100).toFixed(2) * 1) + ((Math
                                    .round(data['invoicetotal_addedvalue'] * 100) / 100)
                                .toFixed(2) * 1);
                            ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(2) * 1) +
                            ((Math.round(data['invoicetotal_addedvalue'] * 100) / 100).toFixed(2) *
                                1);
                            $('#totalvalueinvoice').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))

                            $('#totalvalueinvoice').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))
                            if ($('#pay').val() == "Cash") {
                                $('#cashamount').val((Math.round((data['invoicetotal_addedvalue'] +
                                    data['invoicetotal_price']) * 100) / 100).toFixed(2))
                            } else if (('#pay').val() == "Shabka") {
                                $('#bankamount').val((Math.round((data['invoicetotal_addedvalue'] +
                                    data['invoicetotal_price']) * 100) / 100).toFixed(2))

                            } else {
                                $('#creaditamount').val((Math.round((data[
                                    'invoicetotal_addedvalue'] + data[
                                        'invoicetotal_price']) * 100) / 100).toFixed(2))

                            }


                            var rowCount = table.rows.length;

                            for (var i = 0; i < rowCount; i++) {
                                var data = table.rows[i].innerText.innerText;
                                console.log('end');

                            }




                            $('#product_name').val('');
                            $('#product_price_after_dis').val(0);
                            $('#quantity').val(1);
                            $('#avaliable_quentity').val('');
                            $('#product_location').val('');
                            $('#product_price').val('');
                            $('#purchase_price').val('');
                            $('#productNo').val("__('home.searchbyproductnumber')");
                            $('#priceWithTax').val('');

                        }

                        $('#saveinvice').val(0);



                    },
                    error: function(response) {
                        alert("{{ __('home.sorryerror') }}")

                    }
                });
            }
        }
        document.getElementById("product_code").focus();
        $('#product_name').val('');
        $('#product_price_after_dis').val(0);
        $('#quantity').val(1);
        $('#avaliable_quentity').val('');
        $('#product_location').val('');
        $('#product_price').val('');
        $('#purchase_price').val('');
        $('#productNo').val("__('home.searchbyproductnumber')");
        $('#priceWithTax').val('');
        $('#product_code').val('')


    }
});

function doc_keyUp(e) {

    // this would test for whichever key is 40 (down arrow) and the ctrl key at the same time
    if (e.keyCode == '38') {
        // call your function to do the thing

        $('#SearchProduct').modal().show();

    }
}
// register the handler 
document.addEventListener('keyup', doc_keyUp, false);




$('#SearchProduct').on('shown.bs.modal', function() {

    $('#searchaboutproduct').focus();
    $('#searchaboutproduct').val($('#product_code').val());
    $('#searchaboutproduct').keyup()



})





var date = $('.fc-datepicker').datepicker({
    dateFormat: 'yy-mm-dd'
}).val();

$("#printReciept").click(function(e) {
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
        success: function(data) {
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
        error: function(response) {
            alert("{{ __('home.sorryerror') }}")

        }
    });
});
</script>
<script>
function TaxـNumberConvert() {
    var input = document.getElementById("TaxـNumber");
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
var barcode = '';
var interval;
document.addEventListener('keydown', function(evt) {
    if (interval)
        clearInterval(interval);
    if (evt.code == 'Enter') {
        if (barcode)
            handleBarcode(barcode);
        barcode = '';
        return;
    }
    if (evt.key != 'Shift')
        barcode += evt.key;
    interval = setInterval(() => barcode = '', 20);
});

function handleBarcode(scanned_barcode) {
    token_search = $('#token_search').val();
    invoice_number = $('#invoice_number').val();
    var url = " {{ URL::to('getByCode') }}"
    pay = $('#pay').val();
    clientnamesearch = $('#clientnamesearch').val();
    $.ajax({
        url: url,
        type: "post",
        dataType: "json",
        data: {
            _token: token_search,
            Code: scanned_barcode,
            invoice_number: $('#invoice_number').val(),
            quantity: 1,
            pay: $('#pay').val(),
            clientnamesearch: $('#clientnamesearch').val(),
            note: $('#notes').val() ?? '-',


        },
        success: function(data) {
            let table = document.getElementById("example");

            $('#product_code').val('');

            // const map =(JSON.parse(response));
            if (data[0] == "notfount") {
                alert("{{ __('home.stocknotAvailable') }}");
            } else {



                $('#show_invoice_number').val(data['invoice_number'])
                $('#invoice_number').val(data['invoice_number']);
                $('#showInvoiceNumber').val(data['invoice_number']);
                $('#invoice_no_delete_All').val(data['invoice_number']);



                var tableHeaderRowCount = 1;

                var rowCount = table.rows.length;

                for (var i = tableHeaderRowCount; i < rowCount; i++) {
                    table.deleteRow(tableHeaderRowCount);
                }
                count1 = 0;
                added_value_total = 0;
                total_sales = 0;

                data['product'].forEach(async (product) => {


                    sales_id = product['id'],
                        count1 = product['count'],
                        product_code = product['Product_Code']
                    product_name = product['product_name']
                    quentity = product['quantity']
                    price = product['Unit_Price']
                    discount = product['Discount_Value']
                    addedvalue = product['Added_Value']
                    total = product['Unit_Price'] * product[
                            'quantity'] + product['Added_Value'] *
                        product['quantity']
                    added_value_total = added_value_total + (
                        product['Added_Value'] * product[
                            'quantity'])
                    total_sales = total_sales + (price * product[
                        'quantity'])
                    console.log(product_name);
                    text1 =
                        '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                    result = text1.concat("onclick=", "decreaseProduct(", sales_id, ",", "1",
                        ")>",
                        '<i " class="las la-minus"></i>',
                        "</button> ")
                    product_name_update = product_name.replaceAll(" ", "?")
                    text2 =
                        ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                    result2 = text2.concat(sales_id, "  ", "data-section_name=",
                        product_name_update,
                        "  ", "data-return_quentity=", quentity, '  ',
                        '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                    )

                    update =
                        ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                    update = update.concat(sales_id, "  ", "data-section_name=",
                        product_name_update, "  ", "data-section_price=", price, "  ",
                        "data-section_discount=", discount,
                        "  ", "data-return_quentity=", quentity, '  ',
                        '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                    )
                    text3 =
                        '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                    result3 = text3.concat("onclick=", "increaseProduct(", sales_id, ",", "1",
                        ")>",
                        '<i class="las la-plus"></i>',
                        "</button> ")

                    if (quentity > 0) {


                        let table = document.getElementById("example");
                        let row = table.insertRow(-1); // We are adding at the end
                        let c1 = row.insertCell(0);
                        let c2 = row.insertCell(1);
                        let c3 = row.insertCell(2);
                        let c4 = row.insertCell(3);
                        let c5 = row.insertCell(4);
                        let c6 = row.insertCell(5);
                        let c7 = row.insertCell(6);
                        let c8 = row.insertCell(7);
                        let c9 = row.insertCell(8);
                        let c10 = row.insertCell(9);
                        let c11 = row.insertCell(10);

                        // Add data to c1 and c2

                        c1.innerText = count1
                        c2.innerHTML = ' <span dir=ltr>' + product_code + '</span>'
                        c3.innerText = product_name
                        c4.innerText = ((Math.round(price * 100) / 100).toFixed(2))
                        c5.innerText = quentity
                        c6.innerText = product['reamingquantity']
                        c7.innerText = ((Math.round((price * quentity) * 100) / 100).toFixed(
                            2))
                        c8.innerText = ((Math.round(discount * 100) / 100).toFixed(2))
                        tax = Math.round(((price * quentity) - discount) * 0.15 * 100) / 100
                        c9.innerText = tax
                        c10.innerText = Math.round(((price * quentity) + tax - discount) *
                            100) / 100
                        c11.innerHTML = result + ' ' + result3 + ' ' + ' ' + update + result2






                    }


                });


                //    update3/3/2023


                let tableTotalPrice = document.getElementById(
                    "tableTotalPrice");
                var tableHeaderRowCount = 1;

                var rowCount = tableTotalPrice.rows.length;

                for (var i = tableHeaderRowCount; i < rowCount; i++) {
                    tableTotalPrice.deleteRow(tableHeaderRowCount);
                }
                let row = tableTotalPrice.insertRow(-
                    1); // We are adding at the end

                let c1 = row.insertCell(0);
                let c2 = row.insertCell(1);
                let c3 = row.insertCell(2);
                let c4 = row.insertCell(3);


                // Add data to c1 and c2


                c1.innerText = (Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(2);
                c2.innerText = (Math.round(data['invoicetotal_addedvalue'] * 100) / 100).toFixed(2);
                c3.innerText = (Math.round(data['invoicetotal_discount'] * 100) / 100).toFixed(2);
                                         c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;



                document.getElementById('totalvalue').innerHTML = ((Math.round(data['invoicetotal_price'] *
                    100) / 100).toFixed(2) * 1) + ((Math.round(data['invoicetotal_addedvalue'] * 100) /
                    100).toFixed(2) * 1);
                ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(2) * 1) + ((Math.round(data[
                    'invoicetotal_addedvalue'] * 100) / 100).toFixed(2) * 1).toString() +
                    "{{ __('home.SAR') }}";
                $('#totalvalueinvoice').val((Math.round((data['invoicetotal_addedvalue'] + data[
                    'invoicetotal_price']) * 100) / 100).toFixed(2))

                if ($('#pay').val() == "Cash") {
                    $('#cashamount').val((Math.round((data['invoicetotal_addedvalue'] + data[
                        'invoicetotal_price']) * 100) / 100).toFixed(2))
                } else if (('#pay').val() == "Shabka") {
                    $('#bankamount').val((Math.round((data['invoicetotal_addedvalue'] + data[
                        'invoicetotal_price']) * 100) / 100).toFixed(2))

                } else {
                    $('#creaditamount').val((Math.round((data['invoicetotal_addedvalue'] + data[
                        'invoicetotal_price']) * 100) / 100).toFixed(2))

                }


                var rowCount = table.rows.length;

                for (var i = 0; i < rowCount; i++) {
                    var data = table.rows[i].innerText.innerText;
                    console.log('end');

                }




                $('#product_name').val('');
                $('#product_price_after_dis').val(0);
                $('#quantity').val(1);
                $('#avaliable_quentity').val('');
                $('#product_location').val('');
                $('#product_price').val('');
                $('#purchase_price').val('');
                $('#productNo').val("__('home.searchbyproductnumber')");
                $('#priceWithTax').val('');

            }




        },
        error: function(response) {
            alert("{{ __('home.sorryerror') }}")

        }
    })
}
</script>
<script>
$('#increaseProduct').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var section_name = button.data('section_name')
    var return_quentity = button.data('return_quentity')
    var price = button.data('section_price')
    var discount = button.data('section_discount')
    var modal = $(this)
    section_name = section_name.replaceAll("?", " ")

    avtsale = $('#avtValue').val();

    modal.find('.modal-body #id_update').val(id);
    modal.find('.modal-body #product_name_update').val(section_name);
    modal.find('.modal-body #product_price_update').val(price);
    modal.find('.modal-body #avt_update').val((Math.round((price * avtsale) * 1000, 2) / 1000).toFixed(2));
    modal.find('.modal-body #quantity_update').val(return_quentity);
    modal.find('.modal-body #product_price_after_dis_update').val(discount);
    modal.find('.modal-body #priceWithTax_update').val(((price * 1) + Math.round((price * avtsale) * 1000, 2) /
        1000).toFixed(2));
})
</script>

<script>
function credit_limitConvert() {
    var input = document.getElementById("credit_limit");
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
function phoneConvert() {
    var input = document.getElementById("phone");
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
var date = $('.fc-datepicker').datepicker({
    dateFormat: 'yy-mm-dd'
}).val();


$("#reciptprinter").click(function(e) {
    reciptprinter
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
        success: function(data) {
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
        error: function(response) {
            console.log(response)
            alert("{{ __('home.sorryerror') }}")

        }
    });
});
</script>

<script>
function convertToNumber() {
    var input = document.getElementById("product_price_after_dis");
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
function quantityconvertToNumber() {
    var input = document.getElementById("quantity");
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
function changeAvtValue(avt) {

    avt = $('#avtValue').val();
    price = $('#product_price').val();
    $('#avt').val((Math.round((price * avt) * 100) / 100).toFixed(2));
    $('#priceWithTax').val(((price * 1) + Math.round((price * avt) * 100) / 100).toFixed(2));

    cost = $('#purchase_price').val()
    quantity = $('#quantity').val()

    $('#profit').val(Math.round(((price - cost) * quantity * 100), 2) / 100)


}

function changeAvtValueupdatewithodtax(avt) {

    avt = $('#avtValue').val();
    price = $('#product_price').val();
    $('#priceWithTax_update').val(((Math.round((price * avt) * 100) / 100) + price * 1).toFixed(2));
    $('#avt').val((Math.round((price * avt) * 100) / 100).toFixed(2));



}

function changeAvtValueupdatewithodtaxupdate(avt) {

    avt = $('#avtValue').val();
    price = $('#product_price_update').val();
    $('#priceWithTax_update').val((Math.round((price * avt) * 100) / 100 + (price * 1)).toFixed(2));
    $('#avt').val(Math.round((price * avt) * 100) / 100);



}
</script>

<script>
function changeAvtValuempdale(avt) {
    price = $('#product_price_update').val();
    avt = $('#avtValue').val();

    $('#avt_update').val(Math.round((price * avt) * 100) / 100);



}
</script>

{{-- Update ( 24/4/2023 ) --}}



<script>
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
        },
        success: function(data) {
            $("#ajax_responce_serarchDiv").html(data);
        },

    });

}
</script>

{{-- End Update ( 24/4/2023 ) --}}




{{-- Update ( 24/4/2023 ) --}}

<script>



function chooseProduct(code, productcode, name, price, sale_price, location, availablequantity) {
    $('#SearchProduct').modal().hide();
    $('#searchaboutproduct').val('');
    name = name.replaceAll("<", " ");
    name = name.replaceAll("?", " ");
    location = location.replaceAll("<", " ");
    productcode = productcode.replaceAll("<", " ");
    productcode = productcode.replaceAll("?", " ");
    $("#productNo").val(code);
    $('#product_name').val(name);
    $('#product_location').val(location);
    $('#avaliable_quentity').val(availablequantity);
    $('#quantity').val(1);
    $('#product_code').val(productcode);

    $('#product_price').val(sale_price);
    console.log('2----2')
    
    
let mainString = name;
let subString = "COPPER WIRE";
if (mainString.indexOf(subString) !== -1) {
                         $('#unit_pice').val('kg').change();

        
    }

    console.log("{{ URL::to('/getlastprice') }}/" + $("#productNo").val() + "/" + $('#clientnamesearch').val());
    $.ajax({
        url: "{{ URL::to('/getlastprice') }}/" + $("#productNo").val() + "/" + $('#clientnamesearch').val(),
        type: "GET",
        dataType: "json",
        success: function(data) {
            $("#last_supplier_cost").empty();

            data.forEach(async (product) => {

                $('#last_supplier_cost').append($('<option>', {
                    value: 1,
                    text: "{{ __('home.Invoice_no') }}" + " : " + product[
                            'invoiceid'] + " ** " + product['date'] + " **  " +
                        product['cost'] + " " + "{{ __('home.SAR') }}"
                }));
            })

        }
    })





    $('#purchase_price').val(price);
    avtsale = $('#avtValue').val();
    $('#avt').val((sale_price * avtsale).toFixed(2));
    $('#priceWithTax').val(((sale_price * avtsale) + (sale_price * 1)).toFixed(2));

    document.getElementById("priceWithTax").focus();

}
</script>

{{-- End Update ( 24/4/2023 ) --}}

<script>
$('#modaldemo9').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var return_quentity = button.data('return_quentity')
    var section_name = button.data('section_name')
    section_name = section_name.replaceAll("?", " ")
    var modal = $(this)
    modal.find('.modal-body #id_delete').val(id);
    modal.find('.modal-body #return_quentity_delete').val(return_quentity);
    modal.find('.modal-body #product_name').val(section_name);
    console.log('lololoooo')
})
</script>

<script>
function makenoteoninvoice() {


    invoiceId = $('#showInvoiceNumber').val()
    note = $('#notes').val()
    if ($('#saveinvice').val() == 1) {
        alert("{{ __('home.recentsave') }}")

    } else {
        $.ajax({
            url: "{{ URL::to('/makenoteoninvoice') }}/" + invoiceId + "/" + note,
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log("success");
                if (data) {

                } else {
                    alert("{{ __('home.sorryerror') }}")
                }
            },
        });
    }







}










function makeDiscountInvoice() {


    invoiceId = $('#showInvoiceNumber').val()
    totaldicount = $('#totaldicount').val()
    $('#totaldicount').val('')
    console.log("{{ URL::to('/makeTotalDiscont') }}/" + invoiceId + "/" + totaldicount)
    if ($('#saveinvice').val() == 1) {
        alert("{{ __('home.recentsave') }}")

    } else {
        $.ajax({
            url: "{{ URL::to('/makeTotalDiscont') }}/" + invoiceId + "/" + totaldicount,
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log("success");
                if (data && data['discount'] != 0) {

                    let tableTotalPrice = document.getElementById("tableTotalPrice");
                    var tableHeaderRowCount = 1;

                    var rowCount = tableTotalPrice.rows.length;

                    for (var i = tableHeaderRowCount; i < rowCount; i++) {
                        tableTotalPrice.deleteRow(tableHeaderRowCount);
                    }
                    let row = tableTotalPrice.insertRow(-1); // We are adding at the end

                    let c1 = row.insertCell(0);
                    let c2 = row.insertCell(1);
                    let c3 = row.insertCell(2);
                    let c4 = row.insertCell(3);


                    // Add data to c1 and c2
                    discount = data['discount']
                    c1.innerText = (Math.round(data['totalprice'] * 100) / 100).toFixed(2),
                        c2.innerText = (Math.round(data['discount'] * 100) / 100).toFixed(2),
                        c3.innerText = (Math.round(data['addedvalueafterdiscount'] * 100) / 100).toFixed(2),
                        totaldiscountvalue = data['totalprice'] + data['addedvalueafterdiscount'];
                    c4.innerText = totaldiscountvalue.toFixed(2);

                    document.getElementById('totalvalue').innerHTML = totaldiscountvalue.toFixed(2);

                    $('#totalvalueinvoice').val(totaldiscountvalue.toFixed(2))
                    if ($('#pay').val() == "Cash") {
                        $('#cashamount').val(totaldiscountvalue.toFixed(2))
                    } else if (('#pay').val() == "Shabka") {
                        $('#bankamount').val(totaldiscountvalue.toFixed(2))

                    } else {
                        $('#creaditamount').val(totaldiscountvalue.toFixed(2))

                    }



                } else {
                    alert("{{ __('home.sorryerror') }}")
                }
            },
        });
    }







}









function cancelDiscountInvoice() {


    invoiceId = $('#showInvoiceNumber').val()
    totaldicount = $('#totaldicount').val()
    $('#totaldicount').val('')
    console.log("{{ URL::to('/cancelInvoiceDiscont') }}/" + invoiceId)
    $.ajax({
        url: "{{ URL::to('/cancelInvoiceDiscont') }}/" + invoiceId,
        type: "GET",
        dataType: "json",
        success: function(data) {
            console.log("success cancel discount");
            console.log(data);
            if (data) {

                let tableTotalPrice = document.getElementById("tableTotalPrice");
                var tableHeaderRowCount = 1;

                var rowCount = tableTotalPrice.rows.length;

                for (var i = tableHeaderRowCount; i < rowCount; i++) {
                    tableTotalPrice.deleteRow(tableHeaderRowCount);
                }

                let row = tableTotalPrice.insertRow(-1); // We are adding at the end

                let c1 = row.insertCell(0);
                let c2 = row.insertCell(1);
                let c3 = row.insertCell(2);
                let c4 = row.insertCell(3);

                // Add data to c1 and c2
                discount = data['discount']
                c1.innerText = (Math.round(data['totalprice'] * 100) / 100).toFixed(2),
                    c2.innerText = (Math.round(data['discount'] * 100) / 100).toFixed(2),
                    c3.innerText =(Math.round(data['addedvalueafterdiscount'] * 100) / 100).toFixed(2) ,
                    totaldiscountvalue = data['totalprice'] + data['addedvalueafterdiscount'];
                c4.innerText = (Math.round(totaldiscountvalue * 100) / 100).toFixed(2);




                document.getElementById('totalvalue').innerHTML = totaldiscountvalue.toFixed(2);

                $('#totalvalueinvoice').val(totaldiscountvalue.toFixed(2))
                if ($('#pay').val() == "Cash") {
                    $('#cashamount').val(totaldiscountvalue.toFixed(2))
                } else if (('#pay').val() == "Shabka") {
                    $('#bankamount').val(totaldiscountvalue.toFixed(2))

                } else {
                    $('#creaditamount').val(totaldiscountvalue.toFixed(2))

                }





            } else {
                alert("{{ __('home.sorryerror') }}")
            }
        },
    });








}






function convertToNumberPriceSale() {
    var input = document.getElementById("product_price");
    var val = toEnglishNumber(input.value)
    input.value = val;
}

function convertToNumberPricewithTaxSale() {
    var input = document.getElementById("priceWithTax");
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
$('#exampleModal2').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var section_name = button.data('section_name')
    var return_quentity = button.data('return_quentity')
    var modal = $(this)
    modal.find('.modal-body #id').val(id);
    modal.find('.modal-body #product_name').val(section_name);
    modal.find('.modal-body #return_quentity').val(return_quentity);
})
</script>
<script>
function changePriceWithTax() {
    console.log("erweeweeweww - - - - -")
    price = $('#priceWithTax').val();

    avtvalue = (price * 100) / 115
    rountavt = Math.round((avtvalue * 100), 2) / 100;

    $('#avt').val(Math.round(((price - rountavt) * 100), 2) / 100);
    $('#product_price').val(rountavt.toFixed(2));


    cost = $('#purchase_price').val()
    quantity = $('#quantity').val()
    $('#profit').val(Math.round(((rountavt - cost) * quantity * 100), 2) / 100)



}

function changePriceWithTaxUpdate() {
    console.log("erweeweeweww - - - - -")
    price = $('#priceWithTax_update').val();

    avtvalue = (price * 100) / 115
    rountavt = Math.round((avtvalue * 100), 2) / 100;

    $('#avt_update').val(Math.round(((price - rountavt) * 100), 2) / 100);
    $('#product_price_update').val(rountavt.toFixed(2));




}
</script>
<script>
$('#modaldemo9').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var return_quentity = button.data('return_quentity')
    var section_name = button.data('section_name')
    section_name = section_name.replaceAll("?", " ")

    console.log('return_quentity')
    console.log('section_name')
    console.log(id)
    console.log(return_quentity)
    console.log('lololoooo')
    var modal = $(this)
    modal.find('.modal-body #id_delete').val(id);
    modal.find('.modal-body #return_quentity_delete').val(return_quentity);
    modal.find('.modal-body #product_name').val(section_name);
    console.log('lololoooo')
})
</script>




<script>
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


            success: function(data) {
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
            error: function(response) {
                alert("{{ __('home.sorryerror') }}")

            }
        });







    }



}
</script>


<script>
function decreaseProduct(id, decreaseCunatity) {
    event.preventDefault();
    $('#loading').modal().show();

    var url = $(this).attr('data-action');
    let table = document.getElementById("example");


    var token_search = $("#token_search").val();
    console.log(token_search);

    var url = " {{ URL::to('EditInvoices') }}";
    token_search = $('#token_search').val();
    id = id;
    return_quentity = decreaseCunatity;
    console.log('+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++');
    console.log(id);
    console.log(return_quentity);

    if ($('#saveinvice').val() == 1) {
        alert("{{ __('home.notupadteaftersave') }}")

    } else {
        $.ajax({
            url: url,
            type: 'post',
            cache: false,

            data: {
                _token: token_search,
                id: id,
                return_quentity: decreaseCunatity,
            },


            success: function(data) {

                console.log(data)
                var tableHeaderRowCount = 1;

                var rowCount = table.rows.length;

                for (var i = tableHeaderRowCount; i < rowCount; i++) {
                    table.deleteRow(tableHeaderRowCount);
                }
                i = 0;
                added_value_total = 0;
                total_sales = 0;
                total_amount = 0;
                data['product'].forEach(async (product) => {


                    sales_id = product['id'],
                        count1 = product['count'],
                        product_code = product['Product_Code']
                    product_name = product['product_name']
                    quentity = product['quantity']
                    price = product['Unit_Price']
                    discount = product['Discount_Value']
                    addedvalue = product['Added_Value']
                    total = product['Unit_Price'] * product['quantity'] + product[
                        'Added_Value'] * product['quantity']
                    added_value_total = added_value_total + (product['Added_Value'] * product[
                        'quantity'])
                    total_sales = total_sales + (price * product['quantity'])

                    console.log(product_name);

                    text1 =
                        '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                    result = text1.concat("onclick=", "decreaseProduct(", sales_id, ",", "1",
                        ")>",
                        '<i class="las la-minus"></i>',
                        "</button> ")
                    product_name_update = product_name.replaceAll(" ", "?")
                    text2 =
                        ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                    result2 = text2.concat(sales_id, "  ", "data-section_name=",
                        product_name_update,
                        "  ", "data-return_quentity=", quentity, '  ',
                        '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                    )

                    update =
                        ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                    update = update.concat(sales_id, "  ", "data-section_name=",
                        product_name_update, "  ", "data-section_price=", price, "  ",
                        "data-section_discount=", discount,
                        "  ", "data-return_quentity=", quentity, '  ',
                        '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                    )
                    text3 =
                        '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                    result3 = text3.concat("onclick=", "increaseProduct(", sales_id, ",", "1",
                        ")>",
                        '<i class="las la-plus"></i>',
                        "</button> ")

                    if (quentity > 0) {


                        let table = document.getElementById("example");
                        let row = table.insertRow(-1); // We are adding at the end
                        let c1 = row.insertCell(0);
                        let c2 = row.insertCell(1);
                        let c3 = row.insertCell(2);
                        let c4 = row.insertCell(3);
                        let c5 = row.insertCell(4);
                        let c6 = row.insertCell(5);
                        let c7 = row.insertCell(6);
                        let c8 = row.insertCell(7);
                        let c9 = row.insertCell(8);
                        let c10 = row.insertCell(9);
                        let c11 = row.insertCell(10);

                        // Add data to c1 and c2

                        c1.innerText = count1
                        c2.innerHTML = ' <span dir=ltr>' + product_code + '</span>'
                        c3.innerText = product_name
                        c4.innerText = ((Math.round(price * 100) / 100).toFixed(2))
                        c5.innerText = quentity
                        c6.innerText = product['reamingquantity']
                        c7.innerText = ((Math.round((price * quentity) * 100) / 100).toFixed(
                            2))
                        c8.innerText = ((Math.round(discount * 100) / 100).toFixed(2))
                        tax = Math.round(((price * quentity) - discount) * 0.15 * 100) / 100
                        c9.innerText = tax
                        c10.innerText = Math.round(((price * quentity) + tax - discount) *
                            100) / 100
                        c11.innerHTML = result + ' ' + result3 + ' ' + ' ' + update + result2



                    }


                });


                //    update3/3/2023

                let tableTotalPrice = document.getElementById("tableTotalPrice");
                var tableHeaderRowCount = 1;

                var rowCount = tableTotalPrice.rows.length;

                for (var i = tableHeaderRowCount; i < rowCount; i++) {
                    tableTotalPrice.deleteRow(tableHeaderRowCount);
                }
                let row = tableTotalPrice.insertRow(-1); // We are adding at the end

                let c1 = row.insertCell(0);
                let c2 = row.insertCell(1);
                let c3 = row.insertCell(2);
                let c4 = row.insertCell(3);


                // Add data to c1 and c2

 c1.innerText = (Math.round((data['invoicetotal_price']+data['invoicetotal_discount'] ) * 100) /100).toFixed(2);
                            c2.innerText =(Math.round(data['invoicetotal_discount'] *100) / 100).toFixed(2);
                            c3.innerText = (Math.round(data['invoicetotal_addedvalue'] *100) / 100).toFixed(2); 
                            c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;


                document.getElementById('totalvalue').innerHTML = ((Math.round(data['invoicetotal_price'] *
                    100) / 100).toFixed(2) * 1) + ((Math.round(data['invoicetotal_addedvalue'] * 100) /
                    100).toFixed(2) * 1);
                ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(2) * 1) + ((Math.round(data[
                    'invoicetotal_addedvalue'] * 100) / 100).toFixed(2) * 1).toString() +
                    "{{ __('home.SAR') }}";
                $('#totalvalueinvoice').val((Math.round((data['invoicetotal_addedvalue'] + data[
                    'invoicetotal_price']) * 100) / 100).toFixed(2))

                if ($('#pay').val() == "Cash") {
                    $('#cashamount').val((Math.round((data['invoicetotal_addedvalue'] + data[
                        'invoicetotal_price']) * 100) / 100).toFixed(2))
                } else if (('#pay').val() == "Shabka") {
                    $('#bankamount').val((Math.round((data['invoicetotal_addedvalue'] + data[
                        'invoicetotal_price']) * 100) / 100).toFixed(2))

                } else {
                    $('#creaditamount').val((Math.round((data['invoicetotal_addedvalue'] + data[
                        'invoicetotal_price']) * 100) / 100).toFixed(2))

                }


                setTimeout(() => {
                    $('#loading').modal('hide');

                }, 500);



            },
            error: function(response) {
                alert("{{ __('home.sorryerror') }}")

            }
        });
    }
}
</script>

<script>
//increaseproduct

function calcCash() {
    var selectCustomer = $('#paymodal').val();

    if (selectCustomer == 'Partition') {
        $('#bankamount').val(($('#totalvalueinvoice').val() * 1) - ($('#cashamount').val() * 1))
    }
}

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

function checkdiscount_rate_allow_update() {

    user_id = $('#user_id').val()
    discount_value = $('#product_price_after_dis_update').val()
    priceWithTax = $('#priceWithTax_update').val()

    if (user_id) {
        rate_system = $('#rate_system').val()
        rate = (discount_value / priceWithTax) * 100;
        if (rate > rate_system) {
            $('#product_price_after_dis_update').val(0)
            alert('يجب الالتزام بنسبة الخصم المسموحة لك \n You must adhere to the discount percentage allowed to you.')
        } else {

        }

    } else {


    }

}

function checkdiscount_rate_allow() {

    user_id = $('#user_id').val()

    discount_value = $('#product_price_after_dis').val()
    priceWithTax = $('#priceWithTax').val()
    rate_system = $('#rate_system').val()

    if (user_id) {
        rate = (discount_value / priceWithTax) * 100;
        if (rate > rate_system) {
            $('#product_price_after_dis').val(0)

            alert('يجب الالتزام بنسبة الخصم المسموحة لك \n You must adhere to the discount percentage allowed to you.')
        } else {

        }

    } else {



    }

}


function increaseProduct(id, increasequantity) {
    event.preventDefault();
    $('#loading').modal().show();


    let table = document.getElementById("example");


    var token_search = $("#token_search").val();
    console.log(token_search);

    var url = " {{ URL::to('increaseProduct') }}";
    token_search = $('#token_search').val();

    if ($('#saveinvice').val() == 1) {
        alert("{{ __('home.notupadteaftersave') }}")

    } else {
        $.ajax({
            url: url,
            type: 'post',
            cache: false,

            data: {
                _token: token_search,
                id: id,
                increasequantity: increasequantity,
            },


            success: function(data) {

                console.log('loading')
                console.log('seccusss12111');
                added_value_total = 0;
                total_sales = 0;
                console.log(data)
                console.log(data[0] == "notfount")
                if (data[0] == "notfount") {
                    alert("{{ __('home.stocknotAvailable') }}");
                } else {
                    var tableHeaderRowCount = 1;

                    var rowCount = table.rows.length;
                    for (var i = tableHeaderRowCount; i < rowCount; i++) {
                        table.deleteRow(tableHeaderRowCount);
                    }

                    data['product'].forEach(async (product) => {


                        sales_id = product['id'],
                            count1 = product['count'],
                            product_code = product['Product_Code']
                        product_name = product['product_name']
                        quentity = product['quantity']
                        price = product['Unit_Price']
                        discount = product['Discount_Value']
                        addedvalue = product['Added_Value']
                        total = product['Unit_Price'] * product['quantity'] + product[
                            'Added_Value'] * product['quantity']
                        added_value_total = added_value_total + (product['Added_Value'] *
                            product['quantity'])
                        total_sales = total_sales + (price * product['quantity'])
                        console.log(product_name);

                        text1 =
                            '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                        result = text1.concat("onclick=", "decreaseProduct(", sales_id, ",",
                            "1",
                            ")>",
                            '<i class="las la-minus"></i>',
                            "</button> ")
                        product_name_update = product_name.replaceAll(" ", "?")
                        text2 =
                            ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                        result2 = text2.concat(sales_id, "  ", "data-section_name=",
                            product_name_update,
                            "  ", "data-return_quentity=", quentity, '  ',
                            '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                        )

                        update =
                            ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                        update = update.concat(sales_id, "  ", "data-section_name=",
                            product_name_update, "  ", "data-section_price=", price, "  ",
                            "data-section_discount=", discount,
                            "  ", "data-return_quentity=", quentity, '  ',
                            '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                        )
                        text3 =
                            '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                        result3 = text3.concat("onclick=", "increaseProduct(", sales_id, ",",
                            "1",
                            ")>",
                            '<i class="las la-plus"></i>',
                            "</button> ")

                        if (quentity > 0) {


                            let table = document.getElementById("example");
                            let row = table.insertRow(-1); // We are adding at the end

                            let c1 = row.insertCell(0);
                            let c2 = row.insertCell(1);
                            let c3 = row.insertCell(2);
                            let c4 = row.insertCell(3);
                            let c5 = row.insertCell(4);
                            let c6 = row.insertCell(5);
                            let c7 = row.insertCell(6);
                            let c8 = row.insertCell(7);
                            let c9 = row.insertCell(8);
                            let c10 = row.insertCell(9);
                            let c11 = row.insertCell(10);

                            // Add data to c1 and c2

                            c1.innerText = count1
                            c2.innerHTML = ' <span dir=ltr>' + product_code + '</span>'
                            c3.innerText = product_name
                            c4.innerText = ((Math.round(price * 100) / 100).toFixed(2))
                            c5.innerText = quentity
                            c6.innerText = product['reamingquantity']
                            c7.innerText = ((Math.round((price * quentity) * 100) / 100)
                                .toFixed(2))
                            c8.innerText = ((Math.round(discount * 100) / 100).toFixed(2))
                            tax = Math.round(((price * quentity) - discount) * 0.15 * 100) / 100
                            c9.innerText = tax
                            c10.innerText = Math.round(((price * quentity) + tax - discount) *
                                100) / 100
                            c11.innerHTML = result + ' ' + result3 + ' ' + ' ' + update +
                                result2


                        }


                    });


                    //    update3/3/2023


                    let tableTotalPrice = document.getElementById("tableTotalPrice");
                    var tableHeaderRowCount = 1;

                    var rowCount = tableTotalPrice.rows.length;

                    for (var i = tableHeaderRowCount; i < rowCount; i++) {
                        tableTotalPrice.deleteRow(tableHeaderRowCount);
                    }
                    let row = tableTotalPrice.insertRow(-1); // We are adding at the end

                    let c1 = row.insertCell(0);
                    let c2 = row.insertCell(1);
                    let c3 = row.insertCell(2);
                    let c4 = row.insertCell(3);


                    // Add data to c1 and c2

                  c1.innerText = (Math.round((data['invoicetotal_price']+data['invoicetotal_discount'] ) * 100) /100).toFixed(2);
                            c2.innerText =(Math.round(data['invoicetotal_discount'] *100) / 100).toFixed(2);
                            c3.innerText = (Math.round(data['invoicetotal_addedvalue'] *100) / 100).toFixed(2); 
                            c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;


                    document.getElementById('totalvalue').innerHTML = ((Math.round(data[
                        'invoicetotal_price'] * 100) / 100).toFixed(2) * 1) + ((Math.round(data[
                        'invoicetotal_addedvalue'] * 100) / 100).toFixed(2) * 1);
                    ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(2) * 1) + ((Math.round(
                        data['invoicetotal_addedvalue'] * 100) / 100).toFixed(2) * 1).toString() +
                        "{{ __('home.SAR') }}";
                    $('#totalvalueinvoice').val((Math.round((data['invoicetotal_addedvalue'] + data[
                        'invoicetotal_price']) * 100) / 100).toFixed(2))

                    if ($('#pay').val() == "Cash") {
                        $('#cashamount').val((Math.round((data['invoicetotal_addedvalue'] + data[
                            'invoicetotal_price']) * 100) / 100).toFixed(2))
                    } else if (('#pay').val() == "Shabka") {
                        $('#bankamount').val((Math.round((data['invoicetotal_addedvalue'] + data[
                            'invoicetotal_price']) * 100) / 100).toFixed(2))

                    } else {
                        $('#creaditamount').val((Math.round((data['invoicetotal_addedvalue'] + data[
                            'invoicetotal_price']) * 100) / 100).toFixed(2))

                    }



                    // var rowCount = table.rows.length;

                    // for (var i = 0; i < rowCount; i++) {
                    //     var data = table.rows[i].innerText.innerText;
                    //     console.log('end');

                    // }


                }
                setTimeout(() => {
                    $('#loading').modal('hide');

                }, 500);
            },
            error: function(response) {
                alert("{{ __('home.sorryerror') }}")

            }
        });
    }
}


$('#SearchProduct').on('show.bs.modal', function(event) {
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
        },
        success: function(data) {
            $("#ajax_responce_serarchDiv").html(data);
        },

    });

})


//endincrease product
</script>
<script>
$(document).ready(function() {
    console.log("{{ URL::to('get_invoice_peeding')}}"+'/'+ $('#invoice_number').val())
                     $.ajax({
                    url:  "{{ URL::to('get_invoice_peeding')}}"+'/'+ $('#invoice_number').val(),
                    type: 'get',
                    cache: false,

                   


                    success: function(data) {
                        $('#saveinvice').val(2)
                        $('#product_code').val('');

                    {
                            $('#total_profit').val(data['total_profit']);
                            $('#show_invoice_number').val(data['invoice_number'])
                            $('#invoice_number').val(data['invoice_number']);
                            $('#showInvoiceNumber').val(data['invoice_number']);
                            $('#invoice_no_delete_All').val(data['invoice_number']);

 var a = document.getElementById('pending_invoice'); //or grab it by tagname etc
                            a.href = "{{ URL::to('pending_invoice') }}" + "/" + data['invoice_number'];
       
       console.log('/*/*/*/*/')
       console.log( "{{ URL::to('pending_invoice') }}" + "/" + data['invoice_number'])

        let table = document.getElementById("example");

                            var tableHeaderRowCount = 1;

                            var rowCount = table.rows.length;

                            for (var i = tableHeaderRowCount; i < rowCount; i++) {
                                table.deleteRow(tableHeaderRowCount);
                            }
                            count1 = 0;
                            added_value_total = 0;
                            total_sales = 0;

                            data['product'].forEach(async (product) => {


                                sales_id = product['id'],
                                    count1 = product['count'],
                                    product_code = product['Product_Code']
                                product_name = product['product_name']
                                quentity = product['quantity']
                                price = product['Unit_Price']
                                discount = product['Discount_Value']
                                addedvalue = product['Added_Value']
                                reamingquantity = product['reamingquantity']
                                total = product['Unit_Price'] * product[
                                        'quantity'] + product['Added_Value'] *
                                    product['quantity']
                                added_value_total = added_value_total + (
                                    product['Added_Value'] * product[
                                        'quantity'])
                                total_sales = total_sales + (price * product[
                                    'quantity'])
                                console.log(product_name);
                                text1 =
                                    '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                                result = text1.concat("onclick=",
                                    "decreaseProduct(", sales_id, ",", "1",
                                    ")>",
                                    '<i " class="las la-minus"></i>',
                                    "</button> ")
                                product_name_update = product_name.replaceAll(
                                    " ", "?")
                                text2 =
                                    ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                                result2 = text2.concat(sales_id, "  ",
                                    "data-section_name=",
                                    product_name_update,
                                    "  ", "data-return_quentity=", quentity,
                                    '  ',
                                    '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                                )

                                update =
                                    ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                                update = update.concat(sales_id, "  ",
                                    "data-section_name=",
                                    product_name_update, "  ",
                                    "data-section_price=", price, "  ",
                                    "data-section_discount=", discount,
                                    "  ", "data-return_quentity=", quentity,
                                    '  ',
                                    '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                                )
                                text3 =
                                    '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                                result3 = text3.concat("onclick=",
                                    "increaseProduct(", sales_id, ",", "1",
                                    ")>",
                                    '<i class="las la-plus"></i>',
                                    "</button> ")

                                if (quentity > 0) {


                                    let table = document.getElementById(
                                        "example");
                                    let row = table.insertRow(-
                                    1); // We are adding at the end

                                    let c1 = row.insertCell(0);
                                    let c2 = row.insertCell(1);
                                    let c3 = row.insertCell(2);
                                    let c4 = row.insertCell(3);
                                    let c5 = row.insertCell(4);
                                    let c6 = row.insertCell(5);
                                    let c7 = row.insertCell(6);
                                    let c8 = row.insertCell(7);
                                    let c9 = row.insertCell(8);
                                    let c10 = row.insertCell(9);
                                    let c11 = row.insertCell(10);

                                    // Add data to c1 and c2

                                    c1.innerText = count1
                                    c2.innerHTML = ' <span dir=ltr>' +
                                        product_code + '</span>'
                                    c3.innerText = product_name
                                    c4.innerText = ((Math.round(price * 100) /
                                        100).toFixed(2))
                                    c5.innerText = quentity
                                    c6.innerText = product['reamingquantity']
                                    c7.innerText = ((Math.round((price *
                                            quentity) * 100) / 100)
                                        .toFixed(2))
                                    c8.innerText = ((Math.round(discount *
                                        100) / 100).toFixed(2))
                                    tax = Math.round(((price * quentity) -
                                        discount) * 0.15 * 100) / 100
                                    c9.innerText = tax
                                    c10.innerText = Math.round(((price *
                                            quentity) + tax - discount) *
                                        100) / 100
                                    c11.innerHTML = result + ' ' + result3 +
                                        ' ' + ' ' + update + result2





                                }


                            });


                            //    update3/3/2023


                            let tableTotalPrice = document.getElementById("tableTotalPrice");
                            var tableHeaderRowCount = 1;

                            var rowCount = tableTotalPrice.rows.length;

                            for (var i = tableHeaderRowCount; i < rowCount; i++) {
                                tableTotalPrice.deleteRow(tableHeaderRowCount);
                            }
                            let row = tableTotalPrice.insertRow(-
                                1); // We are adding at the end

                            let c1 = row.insertCell(0);
                            let c2 = row.insertCell(1);
                            let c3 = row.insertCell(2);
                            let c4 = row.insertCell(3);


                            // Add data to c1 and c2


                 
                            c1.innerText = (Math.round((data['invoicetotal_price']+data['invoicetotal_discount'] ) * 100) /100).toFixed(2);
                            c2.innerText =(Math.round(data['invoicetotal_discount'] *100) / 100).toFixed(2);
                            c3.innerText = (Math.round(data['invoicetotal_addedvalue'] *100) / 100).toFixed(2); 
                            c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;



                            document.getElementById('totalvalue').innerHTML = ((Math.round(
                                    data['invoicetotal_price'] * 100) / 100).toFixed(
                                2) * 1) + ((Math.round(data['invoicetotal_addedvalue'] *
                                100) / 100).toFixed(2) * 1);
                            ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(
                                2) * 1) + ((Math.round(data['invoicetotal_addedvalue'] *
                                100) / 100).toFixed(2) * 1);
                            $('#totalvalueinvoice').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                'invoicetotal_price']) * 100) / 100).toFixed(2))

                            $('#totalvalueinvoice').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                'invoicetotal_price']) * 100) / 100).toFixed(2))
                            if ($('#pay').val() == "Cash") {
                                $('#cashamount').val((Math.round((data[
                                    'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))
                            } else if (('#pay').val() == "Shabka") {
                                $('#bankamount').val((Math.round((data[
                                    'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))

                            } else {
                                $('#creaditamount').val((Math.round((data[
                                    'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))

                            }


                            var rowCount = table.rows.length;

                            for (var i = 0; i < rowCount; i++) {
                                var data = table.rows[i].innerText.innerText;
                                console.log('end');

                            }




                            $('#product_name').val('');
                            $('#product_price_after_dis').val(0);
                            $('#quantity').val(1);
                            $('#avaliable_quentity').val('');
                            $('#product_location').val('');
                            $('#product_price').val('');
                            $('#purchase_price').val('');
                            $('#productNo').val("__('home.searchbyproductnumber')");
                            $('#priceWithTax').val('');

                        }

                        $('#saveinvice').val(0);

                        document.getElementById("product_code").focus();


                    },
                    error: function(response) {
                        console.log(response)
                        alert("{{ __('home.sorryerror') }}")

                    }
                });
    document.getElementById('loading-screen').style.display = 'none'; // Hide loading screen

    user_id = $('#user_id').val();
    if (user_id == 1) {
        document.getElementById('product_price').readOnly = true;
        document.getElementById('priceWithTax').readOnly = true;
        document.getElementById('priceWithTax_update').readOnly = true;
        document.getElementById('product_price_update').readOnly = true;
    }
    document.getElementById("product_code").focus();

    document.getElementById('printdiv').hidden = true
    document.getElementById('returnAlldiv').hidden = true

    $(function() {
        var timeout = 4000; // in miliseconds (3*1000)
        $('.alert').delay(timeout).fadeOut(500);
    });
    $('select[name="productNo"]').on('change', function() {




        console.log('AJAX load   work 0000');

        var selectProduct = $(this).val();
        console.log(selectProduct);
        $.ajax({
            url: "{{ URL::to('getProductdJsonDecode') }}/" + selectProduct,
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log("success");
                if (data && data['numberofpice'] > 0) {


                    $('#product_name').val(data['product_name']);
                    $('#product_location').val(data['Product_Location']);
                    $('#avaliable_quentity').val(data['numberofpice']);
                    $('#quantity').val(1);
                    $('#product_price').val(data['sale_price']);
                    $('#purchase_price').val(data['purchasingـprice']);
                    console.log('AJAX load   work');

                } else {

                    alert("{{ __('home.stocknotAvailable') }}");

                }
            },
        });

    });

    //update today
    //increaseProduct




    //endincreaseProductbutton


    //addProduct



    // Update ( 24/4/2023 )

    $("#saveInvoice").click(function(e) {

        if ($('#saveinvice').val() == 0) {
            $('#paymentmethod').modal('show');

        } else if ($('#saveinvice').val() == 2) {
            alert("{{ __('home.pleasewait') }}")

        } else {
            alert("{{ __('home.recentsave') }}")
        }


    })

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
another=6;
  const select = document.getElementById("paymodal");
  const selectedIndex = select.selectedIndex;

console.log(selectedIndex)

        text = $('#totalvalueinvoice').val()
        if($('#clientnamesearch').val()!=0){
        if ($('#saveinvice').val() == 0) {
            $('#saveinvice').val(1);
            console.log(" {{URL::to('confirmpaymentconfirmpayment')}}/" + $('#invoice_number').val() +
                '/' + $('#cashamount').val() + '/' + $('#bankamount').val() + '/' + $(
                    '#creaditamount').val() + "/" + $('#Bank_transfer').val() + '/' + $('#paymodal')
                .val() + '/' + $('#clientnamesearch').val() + '/' + $('#numbershowstatus').val() +
                '/' + $('#date').val()+'/'+selectedIndex + '/' + $('#p_o').val())
            $('#paymentmethod').modal('show');
            if (Number(text) == (Number($('#cashamount').val()) + Number($('#Bank_transfer').val()) +
                    Number($('#bankamount').val()) + Number($('#creaditamount').val()))) {
                $.ajax({
                    url: " {{URL::to('confirmpaymentconfirmpayment')}}/" + $('#invoice_number')
                        .val() + '/' + $('#cashamount').val() + '/' + $('#bankamount').val() +
                        '/' + $('#creaditamount').val() + "/" + $('#Bank_transfer').val() +
                        '/' + $('#paymodal').val() + '/' + $('#clientnamesearch').val() + '/' +
                        $('#numbershowstatus').val() + '/' + $('#date').val()+'/'+selectedIndex+ '/' + $('#p_o').val(),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        
                        
                        
                        
                        
                         var a = document.getElementById('generate_pdf'); //or grab it by tagname etc
                            a.href = "{{ URL::to('generate_pdf') }}" + "/" + data;
       
       
       
  link="https://demoo.ebdeaclients.online/ar/generate_pdf/"+data;
  ph=$('#phone').val();                        
  let phone = "966"+ph.substring(1); // رقم الواتساب
  let message =" يسرنا خدمتكم مرفق لكم فاتورتكم \n  لتحميل فاتورتك رقم "+data+link+'\n For dwonload your invoice number :'+data +'press here '+link; 
  let url = `https://web.whatsapp.com/send?phone=${phone}?text=${encodeURIComponent(message)}`;
  var a = document.getElementById('send_whats_app'); //or grab it by tagname etc
  a.href = url;
              
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            console.log(" {{ URL::to('generate_pdf') }}" + "/" + data)
                        $('#Bank_transfer').val(0)
                        $('#creaditamount').val(0)
                        $('#bankamount').val(0)
                        $('#cashamount').val(0)
    $('#clientnamesearch').val('0').change();

                        if (data >= 1) {
                            $('#show_invoice_number').val(data);
                            $('#invoice_show_mo').val(data)

                            document.getElementById('printdiv').hidden = false
                            document.getElementById('returnAlldiv').hidden = false

                           
                            $('#cashreceived').val(0)
                            $('#massagesave').modal().show();
                            setTimeout(() => {
                                $('#massagesave').modal('hide');

                            }, 1000);
                        } else {
                            alert("{{ __('home.sorryerror') }}")
                        }


                    },
                    error: function(response) {
                        $('#saveinvice').val(0);

                        alert("{{ __('home.sorryerror') }}")

                    }

                })
            } else {
                $('#saveinvice').val(0);

                alert("{{ __('home.entermonycorrect') }}")

            }
        } else {
            alert("{{ __('home.recentsave') }}")
        }
}else{
            alert("{{ __('home.chooseclient') }}")
}
    })


    // End Update ( 24/4/2023 )
    $("#getinvoiceupdate").click(function(e) {
        event.preventDefault();
        var url = " {{ URL::to('updateinvoicebyid') }}" + "/" + $('#updateinvoicebyid').val();;
        console.log(url)
        jQuery.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            cache: false,

            success: function(data) {
                let table = document.getElementById("example");

                $('#saveinvice').val(2)
                $('#product_code').val('');

                // const map =(JSON.parse(response));
                if (data == 0) {
                    alert("{{ __('home.stocknotAvailable') }}");
                } else {

                    var o = new Option(data['customer']['name'] + ' -' + data['customer'][
                        'tax_no'
                    ], data['customer']['id']);
                    o.selected = true;
                    $("#clientnamesearch").append(o);


                    $('#show_invoice_number').val(data['invoice_number'])
                    $('#invoice_number').val(data['invoice_number']);
                    $('#showInvoiceNumber').val(data['invoice_number']);
                    $('#invoice_no_delete_All').val(data['invoice_number']);



                    var tableHeaderRowCount = 1;

                    var rowCount = table.rows.length;

                    for (var i = tableHeaderRowCount; i < rowCount; i++) {
                        table.deleteRow(tableHeaderRowCount);
                    }
                    count1 = 0;
                    added_value_total = 0;
                    total_sales = 0;

                    data['product'].forEach(async (product) => {


                        sales_id = product['id'],
                            count1 = product['count'],
                            product_code = product['Product_Code']
                        product_name = product['product_name']
                        quentity = product['quantity']
                        price = product['Unit_Price']
                        discount = product['Discount_Value']
                        addedvalue = product['Added_Value']
                        reamingquantity = product['reamingquantity']
                        total = product['Unit_Price'] * product[
                                'quantity'] + product['Added_Value'] *
                            product['quantity']
                        added_value_total = added_value_total + (
                            product['Added_Value'] * product[
                                'quantity'])
                        total_sales = total_sales + (price * product[
                            'quantity'])
                        console.log(product_name);
                        text1 =
                            '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                        result = text1.concat("onclick=", "decreaseProduct(",
                            sales_id, ",", "1",
                            ")>",
                            '<i " class="las la-minus"></i>',
                            "</button> ")
                        product_name_update = product_name.replaceAll(" ", "?")
                        text2 =
                            ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                        result2 = text2.concat(sales_id, "  ",
                            "data-section_name=", product_name_update,
                            "  ", "data-return_quentity=", quentity, '  ',
                            '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                        )

                        update =
                            ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                        update = update.concat(sales_id, "  ",
                            "data-section_name=", product_name_update, "  ",
                            "data-section_price=", price, "  ",
                            "data-section_discount=", discount,
                            "  ", "data-return_quentity=", quentity, '  ',
                            '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                        )
                        text3 =
                            '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                        result3 = text3.concat("onclick=", "increaseProduct(",
                            sales_id, ",", "1",
                            ")>",
                            '<i class="las la-plus"></i>',
                            "</button> ")

                        if (quentity > 0) {


                            let table = document.getElementById("example");
                            let row = table.insertRow(-
                            1); // We are adding at the end

                            let c1 = row.insertCell(0);
                            let c2 = row.insertCell(1);
                            let c3 = row.insertCell(2);
                            let c4 = row.insertCell(3);
                            let c5 = row.insertCell(4);
                            let c6 = row.insertCell(5);
                            let c7 = row.insertCell(6);
                            let c8 = row.insertCell(7);
                            let c9 = row.insertCell(8);
                            let c10 = row.insertCell(9);
                            let c11 = row.insertCell(10);

                            // Add data to c1 and c2

                            c1.innerText = count1
                            c2.innerHTML = ' <span dir=ltr>' + product_code +
                                '</span>'
                            c3.innerText = product_name
                            c4.innerText = ((Math.round(price * 100) / 100)
                                .toFixed(2))
                            c5.innerText = quentity
                            c6.innerText = product['reamingquantity']
                            c7.innerText = ((Math.round((price * quentity) *
                                100) / 100).toFixed(2))
                            c8.innerText = ((Math.round(discount * 100) / 100)
                                .toFixed(2))
                            tax = Math.round(((price * quentity) - discount) *
                                0.15 * 100) / 100
                            c9.innerText = tax
                            c10.innerText = Math.round(((price * quentity) +
                                tax - discount) * 100) / 100
                            c11.innerHTML = result + ' ' + result3 + ' ' + ' ' +
                                update + result2







                        }


                    });


                    //    update3/3/2023


                    let tableTotalPrice = document.getElementById(
                        "tableTotalPrice");
                    var tableHeaderRowCount = 1;

                    var rowCount = tableTotalPrice.rows.length;

                    for (var i = tableHeaderRowCount; i < rowCount; i++) {
                        tableTotalPrice.deleteRow(tableHeaderRowCount);
                    }
                    let row = tableTotalPrice.insertRow(-
                        1); // We are adding at the end

                    let c1 = row.insertCell(0);
                    let c2 = row.insertCell(1);
                    let c3 = row.insertCell(2);
                    let c4 = row.insertCell(3);


                    // Add data to c1 and c2


                    c1.innerText = (Math.round(data['invoicetotal_price'] * 100) / 100)
                        .toFixed(2);
                    c2.innerText = (Math.round(data['invoicetotal_addedvalue'] * 100) / 100)
                        .toFixed(2);
                    c3.innerText = (Math.round(data['invoicetotal_discount'] * 100) / 100)
                        .toFixed(2);
                                           c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;





                    document.getElementById('totalvalue').innerHTML = (Math.round((data[
                        'invoicetotal_addedvalue'] * 1 + data[
                        'invoicetotal_price'] * 1) * 100) / 100).toFixed(2);
                    ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(2) * 1) +
                    ((Math.round(data['invoicetotal_addedvalue'] * 100) / 100).toFixed(2) *
                        1);
                    $('#totalvalueinvoice').val((Math.round((data[
                        'invoicetotal_addedvalue'] * 1 + data[
                            'invoicetotal_price'] * 1) * 100) / 100).toFixed(2))

                    $('#totalvalueinvoice').val((Math.round((data[
                        'invoicetotal_addedvalue'] * 1 + data[
                            'invoicetotal_price'] * 1) * 100) / 100).toFixed(2))
                    $('#cashamount').val((Math.round((data['invoicetotal_addedvalue'] * 1 +
                        data['invoicetotal_price'] * 1) * 100) / 100).toFixed(2))



                    var rowCount = table.rows.length;

                    for (var i = 0; i < rowCount; i++) {
                        var data = table.rows[i].innerText.innerText;
                        console.log('end');

                    }




                    $('#product_name').val('');
                    $('#product_price_after_dis').val(0);
                    $('#quantity').val(1);
                    $('#avaliable_quentity').val('');
                    $('#product_location').val('');
                    $('#product_price').val('');
                    $('#purchase_price').val('');
                    $('#productNo').val("__('home.searchbyproductnumber')");
                    $('#priceWithTax').val('');

                }

                $('#saveinvice').val(0);



            },
            error: function(response) {
                console.log(response)
                alert("{{ __('home.notreleaseinvoice') }}")

            }


        })
    })


    $("#updateinvoicebyidforsaleupdate").click(function(e) {
        console.log(" {{ URL::to('updateinvoicebyidforsaleupdate') }}" + "/" + $(
            '#updateinvoicebyidforsale').val())
        event.preventDefault();
        var url = " {{ URL::to('updateinvoicebyidforsaleupdate') }}" + "/" + $(
            '#updateinvoicebyidforsale').val();
        console.log(url)
        jQuery.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            cache: false,

            success: function(data) {
                let table = document.getElementById("example");

                $('#saveinvice').val(2)
                $('#product_code').val('');

                // const map =(JSON.parse(response));
                if (data == 0) {
                    alert("{{ __('home.stocknotAvailable') }}");
                } else {



                    $('#show_invoice_number').val(data['invoice_number'])
                    $('#invoice_number').val(data['invoice_number']);
                    $('#showInvoiceNumber').val(data['invoice_number']);
                    $('#invoice_no_delete_All').val(data['invoice_number']);



                    var tableHeaderRowCount = 1;

                    var rowCount = table.rows.length;

                    for (var i = tableHeaderRowCount; i < rowCount; i++) {
                        table.deleteRow(tableHeaderRowCount);
                    }
                    count1 = 0;
                    added_value_total = 0;
                    total_sales = 0;

                    data['product'].forEach(async (product) => {


                        sales_id = product['id'],
                            count1 = product['count'],
                            product_code = product['Product_Code']
                        product_name = product['product_name']
                        quentity = product['quantity']
                        price = product['Unit_Price']
                        discount = product['Discount_Value']
                        addedvalue = product['Added_Value']
                        reamingquantity = product['reamingquantity']
                        total = product['Unit_Price'] * product[
                                'quantity'] + product['Added_Value'] *
                            product['quantity']
                        added_value_total = added_value_total + (
                            product['Added_Value'] * product[
                                'quantity'])
                        total_sales = total_sales + (price * product[
                            'quantity'])
                        console.log(product_name);
                        text1 =
                            '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                        result = text1.concat("onclick=", "decreaseProduct(",
                            sales_id, ",", "1",
                            ")>",
                            '<i " class="las la-minus"></i>',
                            "</button> ")
                        product_name_update = product_name.replaceAll(" ", "?")
                        text2 =
                            ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                        result2 = text2.concat(sales_id, "  ",
                            "data-section_name=", product_name_update,
                            "  ", "data-return_quentity=", quentity, '  ',
                            '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                        )

                        update =
                            ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                        update = update.concat(sales_id, "  ",
                            "data-section_name=", product_name_update, "  ",
                            "data-section_price=", price, "  ",
                            "data-section_discount=", discount,
                            "  ", "data-return_quentity=", quentity, '  ',
                            '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                        )
                        text3 =
                            '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                        result3 = text3.concat("onclick=", "increaseProduct(",
                            sales_id, ",", "1",
                            ")>",
                            '<i class="las la-plus"></i>',
                            "</button> ")

                        if (quentity > 0) {


                            let table = document.getElementById("example");
                            let row = table.insertRow(-
                            1); // We are adding at the end

                            let c1 = row.insertCell(0);
                            let c2 = row.insertCell(1);
                            let c3 = row.insertCell(2);
                            let c4 = row.insertCell(3);
                            let c5 = row.insertCell(4);
                            let c6 = row.insertCell(5);
                            let c7 = row.insertCell(6);
                            let c8 = row.insertCell(7);
                            let c9 = row.insertCell(8);
                            let c10 = row.insertCell(9);
                            let c11 = row.insertCell(10);

                            // Add data to c1 and c2

                            c1.innerText = count1
                            c2.innerHTML = ' <span dir=ltr>' + product_code +
                                '</span>'
                            c3.innerText = product_name
                            c4.innerText = ((Math.round(price * 100) / 100)
                                .toFixed(2))
                            c5.innerText = quentity
                            c6.innerText = product['reamingquantity']
                            c7.innerText = ((Math.round((price * quentity) *
                                100) / 100).toFixed(2))
                            c8.innerText = ((Math.round(discount * 100) / 100)
                                .toFixed(2))
                            tax = Math.round(((price * quentity) - discount) *
                                0.15 * 100) / 100
                            c9.innerText = tax
                            c10.innerText = Math.round(((price * quentity) +
                                tax - discount) * 100) / 100
                            c11.innerHTML = result + ' ' + result3 + ' ' + ' ' +
                                update + result2




                        }


                    });


                    //    update3/3/2023


                    let tableTotalPrice = document.getElementById(
                        "tableTotalPrice");
                    var tableHeaderRowCount = 1;

                    var rowCount = tableTotalPrice.rows.length;

                    for (var i = tableHeaderRowCount; i < rowCount; i++) {
                        tableTotalPrice.deleteRow(tableHeaderRowCount);
                    }
                    let row = tableTotalPrice.insertRow(-
                        1); // We are adding at the end

                    let c1 = row.insertCell(0);
                    let c2 = row.insertCell(1);
                    let c3 = row.insertCell(2);
                    let c4 = row.insertCell(3);


                    // Add data to c1 and c2


                    c1.innerText = (Math.round(data['invoicetotal_price'] * 100) / 100)
                        .toFixed(2);
                    c2.innerText = (Math.round(data['invoicetotal_addedvalue'] * 100) / 100)
                        .toFixed(2);
                    c3.innerText = (Math.round(data['invoicetotal_discount'] * 100) / 100)
                        .toFixed(2);
                                          c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;




                    document.getElementById('totalvalue').innerHTML = (Math.round((data[
                        'invoicetotal_addedvalue'] * 1 + data[
                        'invoicetotal_price'] * 1) * 100) / 100).toFixed(2);
                    ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(2) * 1) +
                    ((Math.round(data['invoicetotal_addedvalue'] * 100) / 100).toFixed(2) *
                        1);
                    $('#totalvalueinvoice').val((Math.round((data[
                        'invoicetotal_addedvalue'] * 1 + data[
                            'invoicetotal_price'] * 1) * 100) / 100).toFixed(2))

                    $('#totalvalueinvoice').val((Math.round((data[
                        'invoicetotal_addedvalue'] * 1 + data[
                            'invoicetotal_price'] * 1) * 100) / 100).toFixed(2))
                    $('#cashamount').val((Math.round((data['invoicetotal_addedvalue'] * 1 +
                        data['invoicetotal_price'] * 1) * 100) / 100).toFixed(2))



                    var rowCount = table.rows.length;

                    for (var i = 0; i < rowCount; i++) {
                        var data = table.rows[i].innerText.innerText;
                        console.log('end');

                    }




                    $('#product_name').val('');
                    $('#product_price_after_dis').val(0);
                    $('#quantity').val(1);
                    $('#avaliable_quentity').val('');
                    $('#product_location').val('');
                    $('#product_price').val('');
                    $('#purchase_price').val('');
                    $('#productNo').val("__('home.searchbyproductnumber')");
                    $('#priceWithTax').val('');

                }

                $('#saveinvice').val(0);



            },
            error: function(response) {
                console.log(response)
                alert("{{ __('home.notreleaseinvoice') }}")

            }


        })
    })


    // End Update ( 24/4/2023 )

    $("#button_1").click(function(e) {


        event.preventDefault();
        var url = $(this).attr('data-action');
        let table = document.getElementById("example");
        var token_search = $("#token_search").val();
        console.log(" {{ URL::to('AddInvoices') }}");
        var url = " {{ URL::to('AddInvoices') }}";
        token_search = $('#token_search').val();
        productNo = $('#productNo').val();
        invoice_number = $('#invoice_number').val();
        product_name = $('#product_name').val();
        product_price_after_dis = $('#product_price_after_dis').val();
        quantity = $('#quantity').val();
        avaliablequantity = $('#avaliable_quentity').val();
        pay = $('#paymodal').val();
        clientnamesearch = $('#clientnamesearch').val();
        creditlimit = $('#creditlimit').val();
        purchase_price = $('#purchase_price').val();
        P_O = $('#P_O').val();

        if ($('#clientnamesearch').val() == 0) {

            alert("{{ __('home.chooseclient') }}")

        } else {
            if ($('#saveinvice').val() == 1) {
                $('#Bank_transfer').val(0)
                $('#creaditamount').val(0)
                $('#bankamount').val(0)
                $('#cashamount').val(0)
                $("#paymodal").val("Cash").change();
                document.getElementById('printdiv').hidden = true
                document.getElementById('returnAlldiv').hidden = true
                $.ajax({
                    url: url,
                    type: 'post',
                    cache: false,

                    data: {
                        _token: token_search,
                        productNo: $('#productNo').val(),
                        invoice_number: null,
                        product_name: $('#product_name').val(),
                        product_price_after_dis:  ($('#product_price_after_dis').val()),
                        quantity: $('#quantity').val(),
                        pay: $('#paymodal').val(),
                        clientnamesearch: $('#clientnamesearch').val(),
                        creditlimit: $('#creditlimit').val(),
                        product_price: $('#product_price').val(),
                        purchase_price: $('#purchase_price').val(),
                        note: $('#notes').val() ?? '-',
                        unit_pice: $('#unit_pice').val(),
P_O:P_O

                    },


                    success: function(data) {

                        console.log(data)
                        $('#total_profit').val(data['total_profit']);

                        $('#saveinvice').val(2)
                        $('#product_code').val('');

                        // const map =(JSON.parse(response));
                        if (data[0] == "notfount") {
                            alert("{{ __('home.stocknotAvailable') }}");
                        } else {

                            $('#total_profit').val(data['total_profit']);
                            $('#show_invoice_number').val(data['invoice_number'])
                            $('#invoice_number').val(data['invoice_number']);
                            $('#showInvoiceNumber').val(data['invoice_number']);
                            $('#invoice_no_delete_All').val(data['invoice_number']);

 var a = document.getElementById('pending_invoice'); //or grab it by tagname etc
                            a.href = "{{ URL::to('pending_invoice') }}" + "/" + data['invoice_number'];
       
       console.log('/*/*/*/*/')
       console.log( "{{ URL::to('pending_invoice') }}" + "/" + data['invoice_number'])

                            var tableHeaderRowCount = 1;

                            var rowCount = table.rows.length;

                            for (var i = tableHeaderRowCount; i < rowCount; i++) {
                                table.deleteRow(tableHeaderRowCount);
                            }
                            count1 = 0;
                            added_value_total = 0;
                            total_sales = 0;

                            data['product'].forEach(async (product) => {


                                sales_id = product['id'],
                                    count1 = product['count'],
                                    product_code = product['Product_Code']
                                product_name = product['product_name']
                                quentity = product['quantity']
                                price = product['Unit_Price']
                                discount = product['Discount_Value']
                                addedvalue = product['Added_Value']
                                reamingquantity = product['reamingquantity']
                                total = product['Unit_Price'] * product[
                                        'quantity'] + product['Added_Value'] *
                                    product['quantity']
                                added_value_total = added_value_total + (
                                    product['Added_Value'] * product[
                                        'quantity'])
                                total_sales = total_sales + (price * product[
                                    'quantity'])
                                console.log(product_name);
                                text1 =
                                    '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                                result = text1.concat("onclick=",
                                    "decreaseProduct(", sales_id, ",", "1",
                                    ")>",
                                    '<i " class="las la-minus"></i>',
                                    "</button> ")
                                product_name_update = product_name.replaceAll(
                                    " ", "?")
                                text2 =
                                    ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                                result2 = text2.concat(sales_id, "  ",
                                    "data-section_name=",
                                    product_name_update,
                                    "  ", "data-return_quentity=", quentity,
                                    '  ',
                                    '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                                )

                                update =
                                    ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                                update = update.concat(sales_id, "  ",
                                    "data-section_name=",
                                    product_name_update, "  ",
                                    "data-section_price=", price, "  ",
                                    "data-section_discount=", discount,
                                    "  ", "data-return_quentity=", quentity,
                                    '  ',
                                    '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                                )
                                text3 =
                                    '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                                result3 = text3.concat("onclick=",
                                    "increaseProduct(", sales_id, ",", "1",
                                    ")>",
                                    '<i class="las la-plus"></i>',
                                    "</button> ")

                                if (quentity > 0) {


                                    let table = document.getElementById(
                                        "example");
                                    let row = table.insertRow(-
                                    1); // We are adding at the end

                                    let c1 = row.insertCell(0);
                                    let c2 = row.insertCell(1);
                                    let c3 = row.insertCell(2);
                                    let c4 = row.insertCell(3);
                                    let c5 = row.insertCell(4);
                                    let c6 = row.insertCell(5);
                                    let c7 = row.insertCell(6);
                                    let c8 = row.insertCell(7);
                                    let c9 = row.insertCell(8);
                                    let c10 = row.insertCell(9);
                                    let c11 = row.insertCell(10);

                                    // Add data to c1 and c2

                                    c1.innerText = count1
                                    c2.innerHTML = ' <span dir=ltr>' +
                                        product_code + '</span>'
                                    c3.innerText = product_name
                                    c4.innerText = ((Math.round(price * 100) /
                                        100).toFixed(2))
                                    c5.innerText = quentity
                                    c6.innerText = product['reamingquantity']
                                    c7.innerText = ((Math.round((price *
                                            quentity) * 1000) / 1000)
                                        .toFixed(3))
                                    c8.innerText = ((Math.round(discount *
                                        100) / 100).toFixed(2))
                                    tax = Math.round(((price * quentity) -
                                        discount) * 0.15 * 100) / 100
                                    c9.innerText = tax
                                    c10.innerText = Math.round(((price *
                                            quentity) + tax - discount) *
                                        100) / 100
                                    c11.innerHTML = result + ' ' + result3 +
                                        ' ' + ' ' + update + result2







                                }


                            });


                            //    update3/3/2023


                            let tableTotalPrice = document.getElementById(
                                "tableTotalPrice");
                            var tableHeaderRowCount = 1;

                            var rowCount = tableTotalPrice.rows.length;

                            for (var i = tableHeaderRowCount; i < rowCount; i++) {
                                tableTotalPrice.deleteRow(tableHeaderRowCount);
                            }
                            let row = tableTotalPrice.insertRow(-
                                1); // We are adding at the end

                            let c1 = row.insertCell(0);
                            let c2 = row.insertCell(1);
                            let c3 = row.insertCell(2);
                            let c4 = row.insertCell(3);


                            // Add data to c1 and c2


                            c1.innerText = (Math.round((data['invoicetotal_price']+data['invoicetotal_discount'] ) * 100) /100).toFixed(2);
                            c2.innerText =(Math.round(data['invoicetotal_discount'] *100) / 100).toFixed(2);
                            c3.innerText = (Math.round(data['invoicetotal_addedvalue'] *100) / 100).toFixed(2); 
                            c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;



                            document.getElementById('totalvalue').innerHTML = ((Math.round(
                                    data['invoicetotal_price'] * 100) / 100).toFixed(
                                2) * 1) + ((Math.round(data['invoicetotal_addedvalue'] *
                                100) / 100).toFixed(2) * 1);
                            ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(
                                2) * 1) + ((Math.round(data['invoicetotal_addedvalue'] *
                                100) / 100).toFixed(2) * 1);
                            $('#totalvalueinvoice').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                'invoicetotal_price']) * 100) / 100).toFixed(2))

                            $('#totalvalueinvoice').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                'invoicetotal_price']) * 100) / 100).toFixed(2))
                            if ($('#pay').val() == "Cash") {
                                $('#cashamount').val((Math.round((data[
                                    'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))
                            } else if (('#pay').val() == "Shabka") {
                                $('#bankamount').val((Math.round((data[
                                    'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))

                            } else {
                                $('#creaditamount').val((Math.round((data[
                                    'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))

                            }


                            var rowCount = table.rows.length;

                            for (var i = 0; i < rowCount; i++) {
                                var data = table.rows[i].innerText.innerText;
                                console.log('end');

                            }




                            $('#product_name').val('');
                            $('#product_price_after_dis').val(0);
                            $('#quantity').val(1);
                            $('#avaliable_quentity').val('');
                            $('#product_location').val('');
                            $('#product_price').val('');
                            $('#purchase_price').val('');
                            $('#productNo').val("__('home.searchbyproductnumber')");
                            $('#priceWithTax').val('');

                        }

                        $('#saveinvice').val(0);

                        document.getElementById("product_code").focus();


                    },
                    error: function(response) {
                        console.log(response)
                        alert("{{ __('home.sorryerror') }}")

                    }
                });

            }  else {
                if (product_name == '') {
                alert("{{ __('home.pleaseChooseProduct') }}")

            }else{
                                    product_name= $('#product_name').val();
                                    $('#product_name').val('');

                $.ajax({
                    url: url,
                    type: 'post',
                    cache: false,

                    data: {
                        _token: token_search,
                        productNo: $('#productNo').val(),
                        invoice_number: $('#invoice_number').val(),
                        product_name: product_name,
                        product_price_after_dis:  ($('#product_price_after_dis').val()),

                        quantity: $('#quantity').val(),
                        pay: $('#paymodal').val(),
                        clientnamesearch: $('#clientnamesearch').val(),
                        creditlimit: $('#creditlimit').val(),
                        product_price: $('#product_price').val(),
                        purchase_price: $('#purchase_price').val(),
                        note: $('#notes').val() ?? '-',
P_O:P_O,

                        unit_pice: $('#unit_pice').val(),

                    },


                    success: function(data) {
                        $('#saveinvice').val(2)
                        $('#product_code').val('');

                        // const map =(JSON.parse(response));
                        if (data[0] == "notfount") {
                            alert("{{ __('home.stocknotAvailable') }}");
                        } else {
                            $('#total_profit').val(data['total_profit']);
                            $('#show_invoice_number').val(data['invoice_number'])
                            $('#invoice_number').val(data['invoice_number']);
                            $('#showInvoiceNumber').val(data['invoice_number']);
                            $('#invoice_no_delete_All').val(data['invoice_number']);

 var a = document.getElementById('pending_invoice'); //or grab it by tagname etc
                            a.href = "{{ URL::to('pending_invoice') }}" + "/" + data['invoice_number'];
       
       console.log('/*/*/*/*/')
       console.log( "{{ URL::to('pending_invoice') }}" + "/" + data['invoice_number'])


                            var tableHeaderRowCount = 1;

                            var rowCount = table.rows.length;

                            for (var i = tableHeaderRowCount; i < rowCount; i++) {
                                table.deleteRow(tableHeaderRowCount);
                            }
                            count1 = 0;
                            added_value_total = 0;
                            total_sales = 0;

                            data['product'].forEach(async (product) => {


                                sales_id = product['id'],
                                    count1 = product['count'],
                                    product_code = product['Product_Code']
                                product_name = product['product_name']
                                quentity = product['quantity']
                                price = product['Unit_Price']
                                discount = product['Discount_Value']
                                addedvalue = product['Added_Value']
                                reamingquantity = product['reamingquantity']
                                total = product['Unit_Price'] * product[
                                        'quantity'] + product['Added_Value'] *
                                    product['quantity']
                                added_value_total = added_value_total + (
                                    product['Added_Value'] * product[
                                        'quantity'])
                                total_sales = total_sales + (price * product[
                                    'quantity'])
                                console.log(product_name);
                                text1 =
                                    '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                                result = text1.concat("onclick=",
                                    "decreaseProduct(", sales_id, ",", "1",
                                    ")>",
                                    '<i " class="las la-minus"></i>',
                                    "</button> ")
                                product_name_update = product_name.replaceAll(
                                    " ", "?")
                                text2 =
                                    ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                                result2 = text2.concat(sales_id, "  ",
                                    "data-section_name=",
                                    product_name_update,
                                    "  ", "data-return_quentity=", quentity,
                                    '  ',
                                    '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                                )

                                update =
                                    ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                                update = update.concat(sales_id, "  ",
                                    "data-section_name=",
                                    product_name_update, "  ",
                                    "data-section_price=", price, "  ",
                                    "data-section_discount=", discount,
                                    "  ", "data-return_quentity=", quentity,
                                    '  ',
                                    '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                                )
                                text3 =
                                    '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                                result3 = text3.concat("onclick=",
                                    "increaseProduct(", sales_id, ",", "1",
                                    ")>",
                                    '<i class="las la-plus"></i>',
                                    "</button> ")

                                if (quentity > 0) {


                                    let table = document.getElementById(
                                        "example");
                                    let row = table.insertRow(-
                                    1); // We are adding at the end

                                    let c1 = row.insertCell(0);
                                    let c2 = row.insertCell(1);
                                    let c3 = row.insertCell(2);
                                    let c4 = row.insertCell(3);
                                    let c5 = row.insertCell(4);
                                    let c6 = row.insertCell(5);
                                    let c7 = row.insertCell(6);
                                    let c8 = row.insertCell(7);
                                    let c9 = row.insertCell(8);
                                    let c10 = row.insertCell(9);
                                    let c11 = row.insertCell(10);

                                    // Add data to c1 and c2

                                    c1.innerText = count1
                                    c2.innerHTML = ' <span dir=ltr>' +
                                        product_code + '</span>'
                                    c3.innerText = product_name
                                    c4.innerText = ((Math.round(price * 100) /
                                        100).toFixed(2))
                                    c5.innerText = quentity
                                    c6.innerText = product['reamingquantity']
                                    c7.innerText = ((Math.round((price *
                                            quentity) * 100) / 100)
                                        .toFixed(2))
                                    c8.innerText = ((Math.round(discount *
                                        100) / 100).toFixed(2))
                                    tax = Math.round(((price * quentity) -
                                        discount) * 0.15 * 100) / 100
                                    c9.innerText = tax
                                    c10.innerText = Math.round(((price *
                                            quentity) + tax - discount) *
                                        100) / 100
                                    c11.innerHTML = result + ' ' + result3 +
                                        ' ' + ' ' + update + result2





                                }


                            });


                            //    update3/3/2023


                            let tableTotalPrice = document.getElementById("tableTotalPrice");
                            var tableHeaderRowCount = 1;

                            var rowCount = tableTotalPrice.rows.length;

                            for (var i = tableHeaderRowCount; i < rowCount; i++) {
                                tableTotalPrice.deleteRow(tableHeaderRowCount);
                            }
                            let row = tableTotalPrice.insertRow(-
                                1); // We are adding at the end

                            let c1 = row.insertCell(0);
                            let c2 = row.insertCell(1);
                            let c3 = row.insertCell(2);
                            let c4 = row.insertCell(3);


                            // Add data to c1 and c2


                 
                            c1.innerText = (Math.round((data['invoicetotal_price']+data['invoicetotal_discount'] ) * 100) /100).toFixed(2);
                            c2.innerText =(Math.round(data['invoicetotal_discount'] *100) / 100).toFixed(2);
                            c3.innerText = (Math.round(data['invoicetotal_addedvalue'] *100) / 100).toFixed(2); 
                            c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;



                            document.getElementById('totalvalue').innerHTML = ((Math.round(
                                    data['invoicetotal_price'] * 100) / 100).toFixed(
                                2) * 1) + ((Math.round(data['invoicetotal_addedvalue'] *
                                100) / 100).toFixed(2) * 1);
                            ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(
                                2) * 1) + ((Math.round(data['invoicetotal_addedvalue'] *
                                100) / 100).toFixed(2) * 1);
                            $('#totalvalueinvoice').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                'invoicetotal_price']) * 100) / 100).toFixed(2))

                            $('#totalvalueinvoice').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                'invoicetotal_price']) * 100) / 100).toFixed(2))
                            if ($('#pay').val() == "Cash") {
                                $('#cashamount').val((Math.round((data[
                                    'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))
                            } else if (('#pay').val() == "Shabka") {
                                $('#bankamount').val((Math.round((data[
                                    'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))

                            } else {
                                $('#creaditamount').val((Math.round((data[
                                    'invoicetotal_addedvalue'] + data[
                                    'invoicetotal_price']) * 100) / 100).toFixed(2))

                            }


                            var rowCount = table.rows.length;

                            for (var i = 0; i < rowCount; i++) {
                                var data = table.rows[i].innerText.innerText;
                                console.log('end');

                            }




                            $('#product_name').val('');
                            $('#product_price_after_dis').val(0);
                            $('#quantity').val(1);
                            $('#avaliable_quentity').val('');
                            $('#product_location').val('');
                            $('#product_price').val('');
                            $('#purchase_price').val('');
                            $('#productNo').val("__('home.searchbyproductnumber')");
                            $('#priceWithTax').val('');

                        }

                        $('#saveinvice').val(0);

                        document.getElementById("product_code").focus();


                    },
                    error: function(response) {
                        console.log(response)
                        alert("{{ __('home.sorryerror') }}")

                    }
                });
            }
        }

        }
    });




    $('select[name="clientnamesearch"]').on('change', function() {
        console.log('AJAX load   work 0000');

        var selectCustomer = $(this).val();
        console.log("{{ URL::to('/getlastprice') }}/" + $("#productNo").val() + "/" + $(
            '#clientnamesearch').val());
        $.ajax({
            url: "{{ URL::to('/getlastprice') }}/" + $("#productNo").val() + "/" + $(
                '#clientnamesearch').val(),
            type: "GET",
            dataType: "json",
            success: function(data) {
                $("#last_supplier_cost").empty();

                data.forEach(async (product) => {

                    $('#last_supplier_cost').append($('<option>', {
                        value: 1,
                        text: "{{ __('home.Invoice_no') }}" +
                            " : " + product['invoiceid'] + " ** " +
                            product['date'] + " **  " + product[
                                'cost'] + " " +
                            "{{ __('home.SAR') }}"
                    }));
                })

            }
        })
        if ($('#invoice_number').val() != '') {

            $.ajax({
                url: "{{ URL::to('/changechustomer') }}/" + $('#invoice_number').val() + "/" +
                    selectCustomer,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log("success");

                    if (data) {


                        console.log(data);

                    } else {
                        alert("{{ __('home.sorryerror')}}")
                    }
                },
            });
        }
        $.ajax({
            url: "{{ URL::to('/getcustomer') }}/" + selectCustomer,
            type: "GET",
            dataType: "json",
            success: function(data) {
                console.log("success");
                if (data) {


                    $('#creditlimit').val(data['Limit_credit']);
                    $('#balance').val(data['Balance']);
                    $('#phone').val(data['phone']);

                    console.log('AJAX load   work');

                } else {
                    alert("{{ __('home.sorryerror')}}")
                }
            },
        });





    });


    $('select[name="paymodal"]').on('change', function() {
        $('#loading').modal().show();

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

        setTimeout(() => {
            $('#loading').modal('hide');

        }, 500);

    });

    //endAddproduct

    //delete


    //updatealldata


    $("#updateproductalldata").click(function(e) {
        $('#loading').modal().show();

        event.preventDefault();
        $('#increaseProduct').modal('hide');

        var url = $(this).attr('data-action');
        let table = document.getElementById("example");


        var token_search = $("#token_search").val();
        console.log(token_search);

        var url = " {{ URL::to('updateproductallDataInvoices') }}";
        token_search = $('#token_search').val();
        id = $('#id_update').val();
        quentity = $('#quantity_update').val();
        avt = $('#avt_update').val();
        discount = $('#product_price_after_dis_update').val();
        price = $('#product_price_update').val();
        console.log('-=-=--bcvvcvvc=-=--=')
        console.log(id)
        console.log(quentity)
        console.log(avt)
        console.log(discount)
        console.log(price)
        if ($('#saveinvice').val() == 1) {
            alert("{{ __('home.notupadteaftersave') }}")

        } else {
            $.ajax({
                url: url,
                type: 'post',
                cache: false,

                data: {
                    _token: token_search,
                    id: id,
                    quentity: quentity,
                    avt: avt,
                    discount: discount,
                    price: price
                },


                success: function(data) {
                    console.log('seccusss12111');
                    if (data.length == 0) {
                        alert("{{ __('home.stocknotAvailable') }}")

                    } else {
                        console.log(data)
                        var tableHeaderRowCount = 1;
                        added_value_total = 0;
                        total_sales = 0;
                        var rowCount = table.rows.length;
                        for (var i = tableHeaderRowCount; i < rowCount; i++) {
                            table.deleteRow(tableHeaderRowCount);
                        }

                        data['product'].forEach(async (product) => {


                            sales_id = product['id'],
                                count1 = product['count'],
                                product_code = product['Product_Code']
                            product_name = product['product_name']
                            quentity = product['quantity']
                            price = product['Unit_Price']
                            discount = product['Discount_Value']
                            addedvalue = product['Added_Value']
                            total = product['Unit_Price'] * product[
                                    'quantity'] + product['Added_Value'] *
                                product[
                                    'quantity']
                            added_value_total = added_value_total + (product[
                                'Added_Value'] * product['quantity'])
                            total_sales = total_sales + (price * product[
                                'quantity'])
                            console.log(product_name);
                            text1 =
                                '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                            result = text1.concat("onclick=",
                                "decreaseProduct(", sales_id, ",", "1",
                                ")>",
                                '<i class="las la-minus"></i>',
                                "</button> ")
                            product_name_update = product_name.replaceAll(" ",
                                "?")
                            text2 =
                                ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                            result2 = text2.concat(sales_id, "  ",
                                "data-section_name=", product_name_update,
                                "  ", "data-return_quentity=", quentity,
                                '  ',
                                '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                            )

                            update =
                                ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                            update = update.concat(sales_id, "  ",
                                "data-section_name=", product_name_update,
                                "  ", "data-section_price=", price, "  ",
                                "data-section_discount=", discount,
                                "  ", "data-return_quentity=", quentity,
                                '  ',
                                '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                            )
                            text3 =
                                '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                            result3 = text3.concat("onclick=",
                                "increaseProduct(", sales_id, ",", "1",
                                ")>",
                                '<i class="las la-plus"></i>',
                                "</button> ")

                            if (quentity > 0) {


                                let table = document.getElementById("example");
                                let row = table.insertRow(-
                                1); // We are adding at the end
                                let c1 = row.insertCell(0);
                                let c2 = row.insertCell(1);
                                let c3 = row.insertCell(2);
                                let c4 = row.insertCell(3);
                                let c5 = row.insertCell(4);
                                let c6 = row.insertCell(5);
                                let c7 = row.insertCell(6);
                                let c8 = row.insertCell(7);
                                let c9 = row.insertCell(8);
                                let c10 = row.insertCell(9);
                                let c11 = row.insertCell(10);

                                // Add data to c1 and c2

                                c1.innerText = count1
                                c2.innerHTML = ' <span dir=ltr>' +
                                    product_code + '</span>'
                                c3.innerText = product_name
                                c4.innerText = ((Math.round(price * 100) / 100)
                                    .toFixed(2))
                                c5.innerText = quentity
                                c6.innerText = product['reamingquantity']
                                c7.innerText = ((Math.round((price * quentity) *
                                    100) / 100).toFixed(2))
                                c8.innerText = ((Math.round(discount * 100) /
                                    100).toFixed(2))
                                tax = Math.round(((price * quentity) -
                                    discount) * 0.15 * 100) / 100
                                c9.innerText = tax
                                c10.innerText = Math.round(((price * quentity) +
                                    tax - discount) * 100) / 100
                                c11.innerHTML = result + ' ' + result3 + ' ' +
                                    ' ' + update + result2




                            }


                        });


                        //    update3/3/2023


                        let tableTotalPrice = document.getElementById("tableTotalPrice");
                        var tableHeaderRowCount = 1;

                        var rowCount = tableTotalPrice.rows.length;

                        for (var i = tableHeaderRowCount; i < rowCount; i++) {
                            tableTotalPrice.deleteRow(tableHeaderRowCount);
                        }
                        let row = tableTotalPrice.insertRow(-1); // We are adding at the end
                        let c1 = row.insertCell(0);
                        let c2 = row.insertCell(1);
                        let c3 = row.insertCell(2);
                        let c4 = row.insertCell(3);


                        // Add data to c1 and c2

                            c1.innerText = (Math.round((data['invoicetotal_price']+data['invoicetotal_discount'] ) * 100) /100).toFixed(2);
                            c2.innerText =(Math.round(data['invoicetotal_discount'] *100) / 100).toFixed(2);
                            c3.innerText = (Math.round(data['invoicetotal_addedvalue'] *100) / 100).toFixed(2); 
                            c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;



                        document.getElementById('totalvalue').innerHTML = ((Math.round(data[
                            'invoicetotal_price'] * 100) / 100).toFixed(2) * 1) + ((Math
                                .round(data['invoicetotal_addedvalue'] * 100) / 100)
                            .toFixed(2) * 1);
                        ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(2) *
                            1) + ((Math.round(data['invoicetotal_addedvalue'] * 100) / 100)
                            .toFixed(2) * 1).toString() + "{{ __('home.SAR') }}";
                        $('#totalvalueinvoice').val((Math.round((data[
                            'invoicetotal_addedvalue'] + data[
                            'invoicetotal_price']) * 100) / 100).toFixed(2))

                        if ($('#pay').val() == "Cash") {
                            $('#cashamount').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                'invoicetotal_price']) * 100) / 100).toFixed(2))
                        } else if (('#pay').val() == "Shabka") {
                            $('#bankamount').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                'invoicetotal_price']) * 100) / 100).toFixed(2))

                        } else {
                            $('#creaditamount').val((Math.round((data[
                                'invoicetotal_addedvalue'] + data[
                                'invoicetotal_price']) * 100) / 100).toFixed(2))

                        }

                        // var rowCount = table.rows.length;

                        // for (var i = 0; i < rowCount; i++) {
                        //     var data = table.rows[i].innerText.innerText;
                        //     console.log('end');

                        // }

                    }

                    setTimeout(() => {
                        $('#loading').modal('hide');

                    }, 500);
                },
                error: function(response) {
                    console.log(response)
                    alert("{{ __('home.sorryerror') }}")

                }
            });
        }

    });








    //endupdatealldata







    //update
    $("#added_product").click(function(e) {
        event.preventDefault();
        $('#modaldemo9').modal('hide');
        $('#exampleModal2').modal('hide');

        var url = $(this).attr('data-action');
        let table = document.getElementById("example");


        var token_search = $("#token_search").val();
        console.log(token_search);

        var url = " {{ URL::to('EditInvoices') }}";
        token_search = $('#token_search').val();
        id = $('#id').val();
        return_quentity = $('#return_quentity').val();
        original_quantity = $('#original_quantity').val();
        if (original_quantity >= return_quentity) {
            $.ajax({
                url: url,
                type: 'post',
                cache: false,

                data: {
                    _token: token_search,
                    id: $('#id').val(),
                    return_quentity: $('#return_quentity').val(),
                },


                success: function(data) {
                    console.log('seccusss12111');

                    console.log(data)
                    var tableHeaderRowCount = 1;
                    added_value_total = 0;
                    total_sales = 0;
                    var rowCount = table.rows.length;
                    for (var i = tableHeaderRowCount; i < rowCount; i++) {
                        table.deleteRow(tableHeaderRowCount);
                    }

                    data['product'].forEach(async (product) => {


                        sales_id = product['id'],
                            count1 = product['count'],
                            product_code = product['Product_Code']
                        product_name = product['product_name']
                        quentity = product['quantity']
                        price = product['Unit_Price']
                        discount = product['Discount_Value']
                        addedvalue = product['Added_Value']
                        total = product['Unit_Price'] * product[
                                'quantity'] + product['Added_Value'] *
                            product[
                                'quantity']
                        added_value_total = added_value_total + (product[
                            'Added_Value'] * product['quantity'])
                        total_sales = total_sales + (price * product[
                            'quantity'])
                        console.log(product_name);
                        text1 =
                            '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                        result = text1.concat("onclick=", "decreaseProduct(",
                            sales_id, ",", "1",
                            ")>",
                            '<i class="las la-minus"></i>',
                            "</button> ")
                        product_name_update = product_name.replaceAll(" ", "?")
                        text2 =
                            ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                        result2 = text2.concat(sales_id, "  ",
                            "data-section_name=", product_name_update,
                            "  ", "data-return_quentity=", quentity, '  ',
                            '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                        )

                        update =
                            ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                        update = update.concat(sales_id, "  ",
                            "data-section_name=", product_name_update, "  ",
                            "data-section_price=", price, "  ",
                            "data-section_discount=", discount,
                            "  ", "data-return_quentity=", quentity, '  ',
                            '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                        )
                        text3 =
                            '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                        result3 = text3.concat("onclick=", "increaseProduct(",
                            sales_id, ",", "1",
                            ")>",
                            '<i class="las la-plus"></i>',
                            "</button> ")


                        if (quentity > 0) {


                            let table = document.getElementById("example");
                            let row = table.insertRow(-
                            1); // We are adding at the end
                            let c1 = row.insertCell(0);
                            let c2 = row.insertCell(1);
                            let c3 = row.insertCell(2);
                            let c4 = row.insertCell(3);
                            let c5 = row.insertCell(4);
                            let c6 = row.insertCell(5);
                            let c7 = row.insertCell(6);
                            let c8 = row.insertCell(7);
                            let c9 = row.insertCell(8);
                            let c10 = row.insertCell(9);
                            let c11 = row.insertCell(10);

                            // Add data to c1 and c2

                            c1.innerText = count1
                            c2.innerHTML = ' <span dir=ltr>' + product_code +
                                '</span>'
                            c3.innerText = product_name
                            c4.innerText = ((Math.round(price * 100) / 100)
                                .toFixed(2))
                            c5.innerText = quentity
                            c6.innerText = product['reamingquantity']
                            c7.innerText = ((Math.round((price * quentity) *
                                100) / 100).toFixed(2))
                            c8.innerText = ((Math.round(discount * 100) / 100)
                                .toFixed(2))
                            tax = Math.round(((price * quentity) - discount) *
                                0.15 * 100) / 100
                            c9.innerText = tax
                            c10.innerText = Math.round(((price * quentity) +
                                tax - discount) * 100) / 100
                            c11.innerHTML = result + ' ' + result3 + ' ' + ' ' +
                                update + result2

                        }


                    });


                    //    update3/3/2023


                    let tableTotalPrice = document.getElementById("tableTotalPrice");
                    var tableHeaderRowCount = 1;

                    var rowCount = tableTotalPrice.rows.length;

                    for (var i = tableHeaderRowCount; i < rowCount; i++) {
                        tableTotalPrice.deleteRow(tableHeaderRowCount);
                    }
                    let row = tableTotalPrice.insertRow(-1); // We are adding at the end
                    let c1 = row.insertCell(0);
                    let c2 = row.insertCell(1);
                    let c3 = row.insertCell(2);
                    let c4 = row.insertCell(3);


                    // Add data to c1 and c2

                            c1.innerText = (Math.round((data['invoicetotal_price']+data['invoicetotal_discount'] ) * 100) /100).toFixed(2);
                            c2.innerText =(Math.round(data['invoicetotal_discount'] *100) / 100).toFixed(2);
                            c3.innerText = (Math.round(data['invoicetotal_addedvalue'] *100) / 100).toFixed(2); 
                            c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;

                    document.getElementById('totalvalue').innerHTML = ((Math.round(data[
                        'invoicetotal_price'] * 100) / 100).toFixed(2) * 1) + ((Math
                            .round(data['invoicetotal_addedvalue'] * 100) / 100)
                        .toFixed(2) * 1);
                    ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(2) * 1) +
                    ((Math.round(data['invoicetotal_addedvalue'] * 100) / 100).toFixed(2) *
                        1).toString() + "{{ __('home.SAR') }}";
                    $('#totalvalueinvoice').val((Math.round((data[
                        'invoicetotal_addedvalue'] + data[
                            'invoicetotal_price']) * 100) / 100).toFixed(2))

                    if ($('#pay').val() == "Cash") {
                        $('#cashamount').val((Math.round((data['invoicetotal_addedvalue'] +
                            data['invoicetotal_price']) * 100) / 100).toFixed(2))
                    } else if (('#pay').val() == "Shabka") {
                        $('#bankamount').val((Math.round((data['invoicetotal_addedvalue'] +
                            data['invoicetotal_price']) * 100) / 100).toFixed(2))

                    } else {
                        $('#creaditamount').val((Math.round((data[
                            'invoicetotal_addedvalue'] + data[
                                'invoicetotal_price']) * 100) / 100).toFixed(2))

                    }


                    // var rowCount = table.rows.length;

                    // for (var i = 0; i < rowCount; i++) {
                    //     var data = table.rows[i].innerText.innerText;
                    //     console.log('end');

                    // }




                },
                error: function(response) {
                    alert("{{ __('home.sorryerror') }}")

                }
            });
        } else {
            alert("{{ __('home.returnquantitymorethensale') }}")

        }
    });



    $("#deleteproduct").click(function(e) {
        event.preventDefault();
        $('#modaldemo9').modal('hide');
        $('#loading').modal().show();

        var url = $(this).attr('data-action');
        let table = document.getElementById("example");
        var token_search = $("#token_search").val();
        console.log(token_search);
        var url = " {{ URL::to('EditInvoices') }}";
        token_search = $('#token_search').val();
        id = $('#id_delete').val();
        return_quentity = $('#return_quentity_delete').val();
        console.log('+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++');
        console.log(id);
        console.log(return_quentity);
        if ($('#saveinvice').val() == 1) {
            alert("{{ __('home.notupadteaftersave') }}")

        } else {
            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: {
                    _token: token_search,
                    id: $('#id_delete').val(),
                    return_quentity: $('#return_quentity_delete').val(),
                },
                success: function(data) {
                    console.log('seccusss12111');
                    console.log(data)
                    var tableHeaderRowCount = 1;
                    added_value_total = 0;
                    total_sales = 0;
                    var rowCount = table.rows.length;
                    for (var i = tableHeaderRowCount; i < rowCount; i++) {
                        table.deleteRow(tableHeaderRowCount);
                    }
                    i = 0;

                    data['product'].forEach(async (product) => {

                        sales_id = product['id'],
                            count1 = product['count'],
                            product_code = product['Product_Code']
                        product_name = product['product_name']
                        quentity = product['quantity']
                        price = product['Unit_Price']
                        discount = product['Discount_Value']
                        addedvalue = product['Added_Value']
                        total = product['Unit_Price'] * product['quantity'] +
                            product['Added_Value'] * product['quantity']

                        console.log(product_name);
                        text1 =
                            '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                        result = text1.concat("onclick=", "decreaseProduct(",
                            sales_id, ",", "1",
                            ")>",
                            '<i class="las la-minus"></i>',
                            "</button> ")
                        product_name_update = product_name.replaceAll(" ", "?")
                        text2 =
                            ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-danger mb-1" data-effect="effect-scale" data-id='
                        result2 = text2.concat(sales_id, "  ",
                            "data-section_name=", product_name_update,
                            "  ", "data-return_quentity=", quentity, '  ',
                            '  data-toggle="modal"   href="#modaldemo9"   title="حذف"><i class="las la-trash"></i></a>'
                        )

                        update =
                            ' <a style="width:40px;height:20px" class="modal-effect btn btn-sm btn-warning mb-1" data-effect="effect-scale" data-id='
                        update = update.concat(sales_id, "  ",
                            "data-section_name=", product_name_update, "  ",
                            "data-section_price=", price, "  ",
                            "data-section_discount=", discount,
                            "  ", "data-return_quentity=", quentity, '  ',
                            '  data-toggle="modal"   href="#increaseProduct"   title="تعديل"><i class="las la-align-justify"></i></a>'
                        )
                        text3 =
                            '<button style="height:20px;width:20px;background-color: #419BB2" type="button"  class="btn btn-success mb-1 minus-plus-buttons" data-dismiss="modal"'
                        result3 = text3.concat("onclick=", "increaseProduct(",
                            sales_id, ",", "1",
                            ")>",
                            '<i class="las la-plus"></i>',
                            "</button> ")


                        if (quentity > 0) {


                            let table = document.getElementById("example");
                            let row = table.insertRow(-
                            1); // We are adding at the end
                            let c1 = row.insertCell(0);
                            let c2 = row.insertCell(1);
                            let c3 = row.insertCell(2);
                            let c4 = row.insertCell(3);
                            let c5 = row.insertCell(4);
                            let c6 = row.insertCell(5);
                            let c7 = row.insertCell(6);
                            let c8 = row.insertCell(7);
                            let c9 = row.insertCell(8);
                            let c10 = row.insertCell(9);
                            let c11 = row.insertCell(10);

                            // Add data to c1 and c2

                            c1.innerText = count1
                            c2.innerHTML = ' <span dir=ltr>' + product_code +
                                '</span>'
                            c3.innerText = product_name
                            c4.innerText = ((Math.round(price * 100) / 100)
                                .toFixed(2))
                            c5.innerText = quentity
                            c6.innerText = product['reamingquantity']
                            c7.innerText = ((Math.round((price * quentity) *
                                100) / 100).toFixed(2))
                            c8.innerText = ((Math.round(discount * 100) / 100)
                                .toFixed(2))
                            tax = Math.round(((price * quentity) - discount) *
                                0.15 * 100) / 100
                            c9.innerText = tax
                            c10.innerText = Math.round(((price * quentity) +
                                tax - discount) * 100) / 100
                            c11.innerHTML = result + ' ' + result3 + ' ' + ' ' +
                                update + result2



                        }
                    });
                    //    update3/3/2023
                    let tableTotalPrice = document.getElementById("tableTotalPrice");
                    var tableHeaderRowCount = 1;

                    var rowCount = tableTotalPrice.rows.length;

                    for (var i = tableHeaderRowCount; i < rowCount; i++) {
                        tableTotalPrice.deleteRow(tableHeaderRowCount);
                    }
                    let row = tableTotalPrice.insertRow(-1); // We are adding at the end

                    let c1 = row.insertCell(0);
                    let c2 = row.insertCell(1);
                    let c3 = row.insertCell(2);
                    let c4 = row.insertCell(3);


                    // Add data to c1 and c2

          c1.innerText = (Math.round((data['invoicetotal_price']+data['invoicetotal_discount'] ) * 100) /100).toFixed(2);
                            c2.innerText =(Math.round(data['invoicetotal_discount'] *100) / 100).toFixed(2);
                            c3.innerText = (Math.round(data['invoicetotal_addedvalue'] *100) / 100).toFixed(2); 
                            c4.innerText = Math.round((((data['invoicetotal_price'] )) + (data['invoicetotal_addedvalue']) )*100) / 100;


                    document.getElementById('totalvalue').innerHTML = ((Math.round(data[
                        'invoicetotal_price'] * 100) / 100).toFixed(2) * 1) + ((Math
                            .round(data['invoicetotal_addedvalue'] * 100) / 100)
                        .toFixed(2) * 1);
                    ((Math.round(data['invoicetotal_price'] * 100) / 100).toFixed(2) * 1) +
                    ((Math.round(data['invoicetotal_addedvalue'] * 100) / 100).toFixed(2) *
                        1).toString() + "{{ __('home.SAR') }}";
                    $('#totalvalueinvoice').val((Math.round((data[
                        'invoicetotal_addedvalue'] + data[
                            'invoicetotal_price']) * 100) / 100).toFixed(2))

                    if ($('#pay').val() == "Cash") {
                        $('#cashamount').val((Math.round((data['invoicetotal_addedvalue'] +
                            data['invoicetotal_price']) * 100) / 100).toFixed(2))
                    } else if (('#pay').val() == "Shabka") {
                        $('#bankamount').val((Math.round((data['invoicetotal_addedvalue'] +
                            data['invoicetotal_price']) * 100) / 100).toFixed(2))

                    } else {
                        $('#creaditamount').val((Math.round((data[
                            'invoicetotal_addedvalue'] + data[
                                'invoicetotal_price']) * 100) / 100).toFixed(2))

                    }


                    setTimeout(() => {
                        $('#loading').modal('hide');

                    }, 500);

                    // var rowCount = table.rows.length;
                    // for (var i = 0; i < rowCount; i++) {
                    //     var data = table.rows[i].innerText.innerText;
                    //     console.log('end');
                    // }
                },
                error: function(response) {
                    alert("{{ __('home.sorryerror') }}")
                }
            });
        }
    });




    const tbodyEl = document.querySelector("tbody");
    const tableEl = document.querySelector("table");

    function onDeleteRow(e) {
        if (!e.target.classList.contains("deleteBtn")) {
            return;
        }

        const btn = e.target;
        console.log('start')

        console.log(btn.closest("tr").data)
        console.log('end')
        alert('delete')
        btn.closest("tr").remove();
    }

    tableEl.addEventListener("click", onDeleteRow);


    //end added



});
</script>

@endsection