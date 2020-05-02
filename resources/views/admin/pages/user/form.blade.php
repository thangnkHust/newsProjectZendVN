{{-- Phan cau truc chinh khi route goi view --}}
@extends('admin.main')

{{-- Phan them le cua page form --}}
@section('content')
    <div class="page-header zvn-page-header clearfix">
        <div class="zvn-page-header-title">
            <h3>Quan ly User</h3>
        </div>
        <div class="zvn-add-new pull-right">
            <a href="{{route($controllerName)}}" class="btn btn-info"><i
                    class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>

    @include('admin/templates.error')

    @if($item['id'])
        <div class="row">
            @include('admin/pages/user.form_info')
            @include('admin/pages/user.form_change_password')
            @include('admin/pages/user.form_change_level')
        </div>
    @else
        @include('admin/pages/user.form_add')
    @endif

@endsection
