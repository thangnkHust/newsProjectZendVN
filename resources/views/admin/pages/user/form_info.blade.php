@php
    // xu ly trong Helper/form.php
    use App\Helpers\form as formTemplate;
    use App\Helpers\template as template;

    // Lay du lieu class chung trong config 
    $formInputAttr = config('test.template.form_input');
    $formLabelAttr = config('test.template.form_label');
    $statusValue = ['active' => 'Active', 'inactive' => 'Inactive'];
    $inputHiddenID = Form::hidden('id', $item['id']);
    $inputHiddenAvatar = Form::hidden('avatar_current', $item['avatar']);
    $inputHiddenTask = Form::hidden('task', 'edit-info');

    $elements = [
        [
            'label' => Form::label('username', 'Username', $formLabelAttr),
            'element' => Form::text('username', $item['username'], $formInputAttr)
        ],
        [
            'label' => Form::label('email', 'Email', $formLabelAttr),
            'element' => Form::text('email', $item['email'], $formInputAttr)
        ],
        [
            'label' => Form::label('fullname', 'Fullname', $formLabelAttr),
            'element' => Form::text('fullname', $item['fullname'], $formInputAttr)
        ],
        [
            'label' => Form::label('status', 'Status', $formLabelAttr),
            'element' => Form::select('status', $statusValue, $item['status'], ['class' => $formInputAttr['class'], 'placeholder' => 'Select status'])
        ],
        [
            'label' => Form::label('avatar', 'Avatar', $formLabelAttr),
            'element' => Form::file('avatar', $formInputAttr),
            'avatar' => (!empty($item['id'])) ? template::showItemThumb($controllerName, $item['avatar'], $item['name']) : null, 
            'type' => 'avatar'
        ],
        [
            'element' => $inputHiddenID . $inputHiddenAvatar . $inputHiddenTask . Form::submit('Save', ['class' => 'btn btn-success']),
            'type' => 'btn-submit'
        ]
    ]
@endphp

{{-- Phan them le cua page form add--}}

<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        @include('admin/templates.x-title', ['title' => 'Form Edit Info'])
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

