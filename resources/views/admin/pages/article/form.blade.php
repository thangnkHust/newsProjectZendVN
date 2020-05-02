{{-- Phan cau truc chinh khi route goi view --}}
@extends('admin.main')

@php
    // xu ly trong Helper/form.php
    use App\Helpers\form as formTemplate;
    use App\Helpers\template as template;

    // Lay du lieu class chung trong config 
    $formInputAttr = config('test.template.form_input');
    $formLabelAttr = config('test.template.form_label');
    $formCkeditor = config('test.template.form_ckeditor');
    $statusValue = ['active' => 'Active', 'inactive' => 'Inactive'];
    $inputHiddenID = Form::hidden('id', $item['id']);
    $inputHiddenThumb = Form::hidden('thumb_current', $item['thumb']);

    $elements = [
        [
            'label' => Form::label('name', 'Name', $formLabelAttr),
            'element' => Form::text('name', $item['name'], $formInputAttr)
        ],
        [
            'label' => Form::label('content', 'Content', $formLabelAttr),
            'element' => Form::textArea('content', $item['content'], $formCkeditor)
        ],
        [
            'label' => Form::label('status', 'Status', $formLabelAttr),
            'element' => Form::select('status', $statusValue, $item['status'], ['class' => $formInputAttr['class'], 'placeholder' => 'Select status'])
        ],
        [
            'label' => Form::label('category_id', 'Category', $formLabelAttr),
            'element' => Form::select('category_id', $itemsCategory, $item['category_id'], ['class' => $formInputAttr['class'], 'placeholder' => 'Select category'])
        ],
        [
            'label' => Form::label('thumb', 'Thumb', $formLabelAttr),
            'element' => Form::file('thumb', $formInputAttr),
            'thumb' => (!empty($item['id'])) ? template::showItemThumb($controllerName, $item['thumb'], $item['name']) : null,
            'type' => 'thumb'
        ],
        [
            'element' => $inputHiddenID . $inputHiddenThumb . Form::submit('Save', ['class' => 'btn btn-success']),
            'type' => 'btn-submit'
        ]
    ]
@endphp

{{-- Phan them le cua page form --}}
@section('content')
    <div class="page-header zvn-page-header clearfix">
        <div class="zvn-page-header-title">
            <h3>Quan ly Article</h3>
        </div>
        <div class="zvn-add-new pull-right">
            <a href="{{route($controllerName)}}" class="btn btn-info"><i
                    class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>

    @include('admin/templates.error')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin/templates.x-title', ['title' => 'Form'])
                <div class="x_content">
                    {{-- <br/> --}}
                    {!! Form::open([
                        'url' => route("$controllerName/save"),
                        'method' => 'POST',
                        'accept-charset' => 'UTF-8',
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal form-label-left',
                        'id' => 'main-form'
                        ]) !!}

                        {{-- html xu ly trong form -> in ra --}}
                        {!! formTemplate::show($elements) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
