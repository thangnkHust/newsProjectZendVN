{{-- Phan cau truc chinh khi route goi view --}}
@extends('admin.main')

{{-- Phan them le cua page slider --}}
@section('content')
@php
    use App\Helpers\template as template;
    $xhtmlButtonFilter = template::showButtonFilter($controllerName, $itemsStatusCount, $params['filter']['status'], $params['search']);
    $xhtmlAreaSearch = template::showAreaSearch($controllerName, $params['search']);
@endphp
<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>Danh sách User</h3>
    </div>
    <div class="zvn-add-new pull-right">
        <a href="{{route($controllerName.'/form')}}" class="btn btn-success"><i
                class="fa fa-plus-circle"></i> Thêm mới</a>
    </div>
</div>

@include('admin/templates/notify')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin/templates.x-title', ['title' => 'Bo Loc'])
            <div class="x_content">
                <div class="row">
                    <div class="col-md-6">
                        {!!$xhtmlButtonFilter!!}
                    </div>
                    <div class="col-md-6">
                        {!!$xhtmlAreaSearch!!}
                    </div>
                    {{-- <div class="col-md-2">
                        <select name="select_filter" class="form-control"
                                data-field="level">
                            <option value="default" selected="selected">Select Level</option>
                            <option value="admin">Admin</option>
                            <option value="member">Member</option>
                        </select>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!--box-lists-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin/templates.x-title', ['title' => 'Danh Sach'])
            @include('admin/pages/slider.list')
        </div>
    </div>
</div>
<!--end-box-lists-->
<!--box-pagination-->
@if(count($items) > 0)
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin/templates.x-title', ['title' => 'Phan trang'])
                @include('admin/templates.pagination')
            </div>
        </div>
    </div>
@endif
<!--end-box-pagination-->
@endsection
