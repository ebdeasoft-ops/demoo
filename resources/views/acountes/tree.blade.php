@extends('layouts.master')

@section('title')
{{ __('home.tree') }}
@endsection

@section('css')
<style>
    .tree-root,
    .tree-root ul {
        list-style: none;
        padding-right: 20px;
    }

    .tree-children {
        display: none;
        margin-top: 5px;
    }

    .tree-toggle {
        cursor: pointer;
        font-weight: bold;
        position: relative;
        padding-right: 18px;
        display: inline-block;
        margin: 4px 0;
    }

    .tree-toggle::before {
        content: "▶";
        position: absolute;
        right: 0;
        font-size: 12px;
        transition: transform 0.2s ease;
    }

    .tree-toggle.open::before {
        transform: rotate(90deg);
    }

    .level-0 { font-size: 20px; color: black; }
    .level-1 { color: green; font-size: 18px; }
    .level-2 { color: blue; font-size: 16px; }
    .level-3 { color: red; font-size: 15px; }
    .level-4 { color: gray; font-size: 14px; }
</style>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <h4 class="content-title mb-0 my-auto">{{ __('home.tree') }}</h4>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body p-4">

                <a class="btn btn-primary mb-3" href="{{ url('/create_acount') }}">
                    {{ __('home.add_new_account') }}
                </a>

                <ul class="tree-root">

                @foreach(App\Models\acounts_type::get() as $type)
                    <li>
                        {{-- 🔹 العنوان الرئيسي (قابل للضغط) --}}
                        <span class="tree-toggle level-0">
                            {{ app()->getLocale() == 'ar' ? $type->name_ar : $type->name_en }}
                        </span>

                        <ul class="tree-children">

                        @foreach(App\Models\financial_accounts::where('account_type',$type->id)->whereNull('parent_account_number')->get() as $lvl1)
                            <li>
                                <span class="tree-toggle level-1">
                                    ({{ $lvl1->account_number }}) {{ $lvl1->name }}
                                </span>

                                <ul class="tree-children">
                                @foreach(App\Models\financial_accounts::where('parent_account_number',$lvl1->id)->get() as $lvl2)
                                    <li>
                                        <span class="tree-toggle level-2">
                                            ({{ $lvl2->account_number }}) {{ $lvl2->name }}
                                        </span>

                                        <ul class="tree-children">
                                        @foreach(App\Models\financial_accounts::where('parent_account_number',$lvl2->id)->get() as $lvl3)
                                            <li>
                                                <span class="tree-toggle level-3">
                                                    ({{ $lvl3->account_number }}) {{ $lvl3->name }}
                                                </span>

                                                <ul class="tree-children">
                                                @foreach(App\Models\financial_accounts::where('parent_account_number',$lvl3->id)->get() as $lvl4)
                                                    <li class="level-4">
                                                        ({{ $lvl4->account_number }}) {{ $lvl4->name }}
                                                    </li>
                                                @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                                </ul>
                            </li>
                        @endforeach

                        </ul>
                    </li>
                @endforeach

                </ul>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function () {

    $('.tree-toggle').on('click', function (e) {
        e.stopPropagation();

        let $current = $(this);
        let $li = $current.closest('li');
        let $parentUl = $li.parent('ul');

        // اقفل الإخوة في نفس المستوى
        $parentUl.children('li').not($li)
            .find('> .tree-toggle')
            .removeClass('open')
            .end()
            .find('> .tree-children')
            .slideUp(200);

        // toggle الحالي
        $current.toggleClass('open');
        $li.children('.tree-children').slideToggle(200);
    });

});
</script>
@endsection
