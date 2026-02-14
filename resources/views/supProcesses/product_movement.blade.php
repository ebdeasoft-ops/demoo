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
{{__('supprocesses.product_movement')}}@stop
@endsection
@section('page-header')
<div class="main-parent">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between parent-heading">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('supprocesses.product_movement')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
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
    @if (session()->has('productupdatedlocation'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <br>

        <strong>{{ session()->get('productupdatedlocation') }}</strong>
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

                    <form action="{{ url(Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale().'/'. ($page = 'product_movement')) }}" method="POST" enctype="multipart/form-data"
 role="search" autocomplete="off">
                        {{ csrf_field() }}







                        <div class="col-lg-4 mg-t-20 mg-lg-t-0 px-0 mb-3">

                            <a style="background-color: #FF4F1F;" class="modal-effect btn py-2 px-0 btn-info button-eng" data-effect="effect-scale" data-toggle="modal" href="#SearchProduct" title="تحديد"><i style=" height: 100;
                 width: 100px;font-size:13px" class="las la-search p-0"> {{ __('home.chooose product') }}</i></a>
                        </div>
                                                <div class="row">

                                 <div class="col-lg-4 mg-t-20 mg-lg-t-0" id="type">
                                <p class="mg-b-10 parent-label"> {{ __('home.productNo') }} </p>
                                <input class="form-control parent-input parent-input" name="productname" id="productname" list="productsList" dir="ltr"  hidden>
                                <input type="text" class="form-control parent-input" id="productcode" name="productcode"  dir=ltr>

                            </div>
                            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label"> {{__('home.productname')}} </label>
                                <input type="text" class="form-control" id="productnameshow" name="productnameshow"  required>

                            </div>
                   
                            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('home.purachesepice') }}</label>
                                <input type="text" class="form-control parent-input" id="purachesepice" name="purachesepice"  required>
                            </div>
                         
                                <input type="number" class="form-control" id="product_no" name="product_no" hidden>
                        </div>
                        <div class="row">
                                   <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('home.Wholesale_price') }}</label>
                                <input type="text" class="form-control parent-input" id="Wholesale_price" name="Wholesale_price"  required>
                            </div>
                          
                        <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('home.sellingproduct without tax') }}</label>
                                <input type="text" class="form-control parent-input" id="product_price" name="product_price"  required>
                            </div>
                                      <div class="col-lg-2 mb-2">
                                <label for="inputName" class="control-label parent-label">{{ __('home.groups') }}</label>
                                <select name="product_group" id="product_group" class="form-control select2" onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                   @foreach (App\Models\products_group::get() as $section)
                                    <option value="{{ $section->id }}"> {{ $section->group_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 mb-2">
                                <label for="inputName" class="control-label parent-label">{{ __('home.MAINproduct') }}</label>
                                <select name="MAINproduct" id="MAINproduct" class="form-control select2" onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option value="no"> -</option>

                                    @foreach (App\Models\products::where('branchs_id',Auth()->user()->branchs_id)->get() as $section)
                                    <option value="{{ $section->id }}"> {{ $section->product_name }} - {{ $section->Product_Code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 mb-2">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('home.refnumber') }}</label>
                                <input type="text" class="form-control parent-input" id="refnumber" name="refnumber"  >
                            </div>
                                
                                    <input hidden type="number" class="form-control parent-input" id="quentity" name="quentity" >
                             
                            <div class="col-lg-4">
                                <label for="inputName" class="control-label parent-label"> {{__('supprocesses.current_location')}} </label>
                                <input type="text" class="form-control" id="current_location" name="current_location" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label for="inputName" class="control-label parent-label"> {{__('supprocesses.new_location')}} </label>
                                <input type="text" class="form-control parent-input" id="new_location" name="new_location" required>
                            </div>
                                <input hidden=true class="form-control" id="user_id" name="user_id" value="{{Auth()->user()->discount_allow_limit}}">

                              <div class="col-lg-4 mb-2">
                                <label for="inputName" class="control-label parent-label">
                                    {{ __('supprocesses.product_notes') }}</label>
                                <input type="text" class="form-control parent-input" id="product_notes" name="product_notes" title="{{ __('supprocesses.product_notes') }}" required value='-'>
                            </div>
 <div class="col-md-6" style="border:solid 5px #000 ; margin:10px;">
               <div class="form-group">    
               
                                                <label for="inputName" class="control-label parent-label">
 {{__('home.photo')}}</label>
                  <input autocomplete="off" onchange="readURL(this)" type="file" id="Item_img" name="Item_img" class="form-control">
                  @error('active')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
             
               </div>
               </div>
               </div>
                        </div>                        <br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success print-style"> {{__('roles.update')}} </button>
                        </div>

                        <input  hidden=true class="form-control" id="branchs_id" name="branchs_id" value="{{Auth()->user()->branchs_id}}">

                        <br>



                </div>
            </div>



            <br>





            </table>

        </div>
    </div>


</div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
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
                            <input type="hidden" id="token_search" value="{{ csrf_token() }}">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('home.cancel')}}</button>
                    </div>

                </div>


            </div>
        </div>

    </div>

<div class="col-lg-4 mg-t-20 mg-lg-t-0">

    <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale" data-toggle="modal" href="#SearchProduct" title="تحديد"><i style=" height: 100;
                 width: 100px;" class="las la-search"> {{ __('home.chooose product') }}</i></a>
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

 document.addEventListener('keydown', (e) => {
    if (e.key === "F9") {
        $('#SearchProduct').modal().show();

    }})
     document.addEventListener('keydown', (e) => {
    searchtext = $('#product_code').val();

if (e.ctrlKey && e.keyCode == '38') {
                searchtext = $('#product_code').val();
$('#searchaboutproduct').val(searchtext);
// document.getElementById("searchaboutproduct").focus();
$('#SearchProduct').modal().show();

        

    }})
    $('#SearchProduct').on('shown.bs.modal', function () {
    $('#searchaboutproduct').focus();
}) 

    function getproduct() {}
    
    
    
    function searchaboutproductfunction() {
        searchtext = $('#searchaboutproduct').val();
        branchs_id = $('#branchs_id').val();
        var token_search = $("#token_search").val();

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
                    "searchtext": '',
                    "branchs_id": branchs_id,
                },
                  success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {

            }
        });

    })
</script>

<script>
    function chooseProduct(code, name, price, sale_price, product_location, availablequantity, productcode,MAINproductname,maincode) {
        $('#SearchProduct').modal().hide();
 console.log('=======----=========')
        console.log(code)
        console.log(name)
        console.log(sale_price)
        console.log(price)
        console.log(product_location)
        console.log(availablequantity)
        console.log(productcode)
        console.log(MAINproductname)
        console.log(maincode)
    $('#MAINproduct')
      .append($('<option selected>', { value :productcode  })
      .text(MAINproductname)); 
         searchtext =product_location;
         console.log(" {{URL::to('getproductbyid')}}/" + code)
    jQuery.ajax({
            url: " {{URL::to('getproductbyid')}}/" + code ,
            type: 'get',
            cache: false,
            dataType: "json",
            success: function(data) {
                    $('#product_group').val(data['product_group']).change();
        $('#uploadedimg').attr('src','https://demoo.ebdeaclients.online/assets/admin/uploads'+'/'+data['photo'])

                    refnumber=data['refnumber']
                    numberofpice=data['numberofpice']
             
           $('#refnumber').val(refnumber);
           $('#quentity').val(numberofpice);
        $('#Wholesale_price').val(data['Wholesale_price']);

             
          
           
        }
            
        }
        )
        var Product_Code = code
        var product_name = name
        var product_sale_pice = price
        $('#productnameshow').val(name);
        $('#current_location').val(availablequantity);
        $('#new_location').val(availablequantity);
        $('#product_price').val(sale_price);

        $('#product_no').val(code);
        $('#productcode').val(product_location);
        $('#purachesepice').val(price);
        $('#refnumber').val(refnumber);
        

    }
</script>

<script>
     document.addEventListener('keydown', (e) => {
    searchtext = $('#productcode').val();

    if (e.key === "Enter") {
$('#searchaboutproduct').val(searchtext);
// document.getElementById("searchaboutproduct").focus();
$('#SearchProduct').modal().show();

        


    }})
        $('#SearchProduct').on('shown.bs.modal', function () {
  $('#searchaboutproduct').focus();
    $('#searchaboutproduct').val($('#productcode').val());
           $('#searchaboutproduct').keyup()
}) 
    $(document).ready(function() {
    $('#productcode').focus();
         user_id=$('#user_id').val();
if(user_id==1)
{
     
}
        $(function() {
            var timeout = 4000; // in miliseconds (3*1000)
            $('.alert').delay(timeout).fadeOut(500);
        });

    });
</script>






@endsection