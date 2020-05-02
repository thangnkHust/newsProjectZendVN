@php
    // xu ly trong Helper/form.php
    use App\Helpers\form as formTemplate;
    use App\Helpers\template as template;

    // Lay du lieu class chung trong config 
    $formInputAttr = config('test.template.form_input');
    $formLabelAttr = config('test.template.form_label');
    $levelValue = ['admin' => config('test.template.level.admin.name'), 'member' => config('test.template.level.member.name')];
    $inputHiddenID = Form::hidden('id', $item['id']);
    $inputHiddenTask = Form::hidden('task', 'change_level');

    $elements = [
        [
            'label' => Form::label('level', 'Level', $formLabelAttr),
            'element' => Form::select('level', $levelValue, $item['level'], ['class' => $formInputAttr['class'], 'placeholder' => 'Select level'])
        ],
        [
            'element' => $inputHiddenID . $inputHiddenTask . Form::submit('Save', ['class' => 'btn btn-success']),
            'type' => 'btn-submit'
        ]
    ]
@endphp

{{-- Phan them le cua page form add--}}

<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin/templates.x-title', ['title' => 'Form Change Password'])
        <div class="x_content">
            {{-- <br/> --}}
            {!! Form::open([
                'url' => route("$controllerName/change-level"),
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

