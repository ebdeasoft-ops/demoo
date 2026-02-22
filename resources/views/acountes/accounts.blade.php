@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<style>
    /* تحسين مظهر الكروت والفلاتر */
    .card-header { background-color: #f8f9fa; border-bottom: 1px solid #e9ecef; }
    .parent-label { font-weight: bold; color: #495057; font-size: 13px; }
    
    /* تمييز صفوف الحسابات */
    .row-parent { background-color: #f1f5f9 !important; font-weight: bold; color: #2c3e50; }
    .row-child { padding-right: 30px !important; } /* إزاحة للحسابات الفرعية */
    
    /* ألوان المبالغ */
    .text-debtor { color: #27ae60; font-weight: bold; }   /* مدين - أخضر */
    .text-creditor { color: #e74c3c; font-weight: bold; } /* دائن - أحمر */
    
    /* تحسين الأزرار */
    .btn-primary.print-style { border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    
    /* تأثير التحميل */
    #ajax_responce_allinvoicesDiv { transition: opacity 0.3s ease-in-out; }
    /* تكبير الخط داخل شارات المدين والدائن */
    .badge {
        font-size: 16px !important; /* تكبير حجم الخط */
        padding: 8px 12px !important; /* زيادة المساحة الداخلية لتبدو الخانة أكبر */
        font-weight: bold !important; /* جعل الخط عريضاً */
        min-width: 100px; /* ضمان حد أدنى للعرض لتوحيد المظهر */
        display: inline-block;
        text-align: center;
    }

    /* إذا كنت تستخدم كلاسات مخصصة للمدين والدائن */
    .text-debtor, .text-creditor {
        font-size: 18px !important; 
        font-weight: 800 !important;
    }

    /* تحسين مظهر الجدول بشكل عام لتناسب الخط الكبير */
    .table td {
        vertical-align: middle !important; /* موازنة المحتوى عمودياً */
        font-size: 18px; /* تكبير خط أرقام الحسابات والأسماء أيضاً */
    }
</style>
@endsection

@section('title')
{{ __('home.Financial_accounts') }}
@stop

@section('page-header')
<div class="main-parent">
    <div class="breadcrumb-header justify-content-between parent-heading">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">&nbsp;&nbsp;{{ __('home.Financial_accounts') }}</h4>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>خطأ</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <a class="btn btn-primary print-style p-1 py-2" href="{{ url('create_acount') }}">
                            {{ __('home.add_new_account') }}
                            <svg style="width: 17px" class="svg-icon-buttons" viewBox="0 0 20 20">
                                <path fill="none" d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z"></path>
                            </svg>
                        </a>
                        <a class="btn btn-success print-style" id="export_excel_btn" target="_blank" href="#">
                            EXPORT EXCEL <i class="fa-solid fa-download"></i>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="parent-label">{{ __('home.saerch_by_numberaccount_or_name') }}</label>
                        <input autocomplete="off" class="form-control" id="invoiceid" placeholder="***" type="text" onkeyup="searchaboutinvoiceByIdfunction()">
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="parent-label">{{ __('report.fromdate') }} </label>
                        <input class="form-control fc-datepicker" id="start_at_filter" value="{{ date('Y-01-01') }}" type="text" placeholder="YYYY-MM-DD">
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="parent-label">  {{ __('report.todate') }}</label>
                        <input class="form-control fc-datepicker" id="end_at_filter" value="{{ date('Y-m-d') }}" type="text" placeholder="YYYY-MM-DD">
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="control-label parent-label">{{ __('home.searchby_account_type') }}</label>
                        <select class="form-control select2" name="searchaboutaccountBytype_function" id="searchaboutaccountBytype_function">
                            @foreach (App\Models\acounts_type::get() as $account)
                            <option value="{{ $account->id }}"> {{ App::getLocale()=='ar'?$account->name_ar:$account->name_en}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive hoverable-table" id="ajax_responce_allinvoicesDiv">
                    </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_account_modal"  role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('users.update') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="update_account_form">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    
                    {{-- اسم الحساب --}}
                    <div class="form-group">
                        <label>{{ __('home.acount_name') }}</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>


                </div>
                <div class="modal-footer">
               
                
                
                
                    <button class="btn ripple btn-primary" type="submit" id="submit_btn">{{ __('home.confirm') }}</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{ __('home.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script>
$(document).on('change', '.update-status', function() {
    let accountId = $(this).data('id');
    let isActive = $(this).is(':checked') ? 1 : 0;
    let isAr = "{{ app()->getLocale() }}" == 'ar';

    $.ajax({
        url: "{{ url('/update_account_status') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: accountId,
            active: isActive
        },
        success: function(response) {
            if(response.success) {
                // رسالة النجاح
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end', // تظهر أسفل الشاشة (يمين للعربي)
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });

                Toast.fire({
                    icon: 'success',
                    title: isAr ? 'تم تحديث الحالة بنجاح' : 'Status updated successfully'
                });
                
                
        // تفعيل منتقي التاريخ مع التحديث التلقائي
        $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect: function() { fetchAccountsData(); }
        });

        // جلب البيانات لأول مرة عند تحميل الصفحة
        fetchAccountsData();

        // ربط تغيير نوع الحساب بالدالة
        $('#searchaboutaccountBytype_function').on('change', function() {
            fetchAccountsData();
        });
    
            }
        },
        error: function(r) {
            console.log(r)
            // رسالة الخطأ
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 3000,
            });

            Toast.fire({
                icon: 'error',
                title: isAr ? 'حدث خطأ ما أثناء التحديث' : 'An error occurred during update'
            });
        }
    });
});


$(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();
    let id = $(this).data('id');
    let locale = "{{ app()->getLocale() }}";
    let tr = $(this).closest('tr');
console.log(id)
    Swal.fire({
        title: locale == 'ar' ? 'هل أنت متأكد؟' : 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: locale == 'ar' ? 'نعم، احذف!' : 'Yes, delete it!',
        cancelButtonText: locale == 'ar' ? 'إلغاء' : 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('/delete_account') }}", 
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    if(response.success) {
                        tr.fadeOut(500);
                        showToast('success', locale == 'ar' ? 'تم الحذف بنجاح' : 'Deleted successfully');
                    }
                },
                error: function(xhr) {
                    console.log(xhr)
                    let response = xhr.responseJSON;
                    
                    if (xhr.status === 422 && response.status === 'has_data') {
                        // إظهار الرسالة التي طلبتها في حالة وجود عمليات
                        Swal.fire({
                            icon: 'error',
                            title: locale == 'ar' ? 'عذراً' : 'Sorry',
                            text: locale == 'ar' ? response.message_ar : response.message_en,
                            confirmButtonText: locale == 'ar' ? 'موافق' : 'OK'
                        });
                    } else {
                        showToast('error', locale == 'ar' ? 'حدث خطأ غير متوقع' : 'Unexpected error');
                    }
                }
            });
        }
    });
});

// دالة مساعدة لإظهار التنبيهات
function showToast(icon, title) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
    Toast.fire({ icon: icon, title: title });
}

function searchaboutinvoiceByIdfunction() {
    var searchText = $('#invoiceid').val(); // القيمة من خانة البحث
    var start = $('#start_at').val(); // تأكد من الـ id الخاص بتاريخ البداية
    var end = $('#end_at').val();     // تأكد من الـ id الخاص بتاريخ النهاية
    var type = $('#type_id').val();   // تأكد من الـ id الخاص بنوع الحساب

    $.ajax({
        url: "{{ URL::to('searchaboutaccountByname_numberfunction') }}",
        type: "GET",
        data: {
            // يجب أن يكون المفتاح هو 'search_text' ليطابق الـ Controller
            'search_text': searchText, 
            'start_at': start,
            'end_at': end,
            'type_id': type
        },
        success: function(data) {
            // تأكد أن هذا هو الـ id الخاص بالـ Div الذي يعرض الجدول
            $("#ajax_responce_allinvoicesDiv").html(data);
        }
    });
}
    // الدالة الموحدة لجلب البيانات - متوافقة مع Request $request في الـ Controller
    function fetchAccountsData() {
        var text = $('#invoiceid').val();
        var start = $('#start_at_filter').val();
        var end = $('#end_at_filter').val();
        var type = $('#searchaboutaccountBytype_function').val();

        // إظهار مؤشر تحميل (تعتيم الجدول)
        $("#ajax_responce_allinvoicesDiv").css('opacity', '0.5');
        
        $.ajax({
            url: "{{ URL::to('searchaboutaccountByname_numberfunction') }}",
            type: "GET",
            // نرسل البيانات كأسماء متغيرات تطابق الـ Request في الـ Controller
            data: {
                'search_text': text,
                'start_at': start,
                'end_at': end,
                'type_id': type
            },
            dataType: "html",
            success: function(data) {
                console.log(data)
                $("#ajax_responce_allinvoicesDiv").html(data).css('opacity', '1');
                
                // تحديث رابط الإكسل فوراً
                var excelUrl = "{{ url('financial_accounts_Export') }}?start_at=" + start + "&end_at=" + end;
                $('#export_excel_btn').attr('href', excelUrl);
            },
            error: function(xhr) {
                console.error("AJAX Error: " + xhr.statusText);
                $("#ajax_responce_allinvoicesDiv").css('opacity', '1');
            }
        });
    }




    $(document).ready(function() {
        
        $(document).on('click', '.edit-account-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
   
        $('#edit_id').val(id);
        $('#edit_name').val(name);
    });

    // عند إرسال الفورم عبر AJAX
    $('#update_account_form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ url('/update_account_details') }}", // تأكد من اسم الـ Route
            method: "POST",
            data: formData,
            beforeSend: function() {
                $('#submit_btn').attr('disabled', true).text('...');
            },
            success: function(response) {
                if(response.success) {
                    $('#edit_account_modal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: "{{ app()->getLocale() == 'ar' ? 'تم التعديل بنجاح' : 'Updated Successfully' }}",
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    setTimeout(function() { location.reload(); }, 1500);
                }
            },
            error: function(r) {
                console.log(r)
                alert('Error Updating Data');
                $('#submit_btn').attr('disabled', false).text("{{ __('home.save') }}");
            }
        });
    });
    
    
    
    
    
        // تفعيل منتقي التاريخ مع التحديث التلقائي
        $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect: function() { fetchAccountsData(); }
        });

        // جلب البيانات لأول مرة عند تحميل الصفحة
        fetchAccountsData();

        // ربط تغيير نوع الحساب بالدالة
        $('#searchaboutaccountBytype_function').on('change', function() {
            fetchAccountsData();
        });
    });
</script>
@endsection