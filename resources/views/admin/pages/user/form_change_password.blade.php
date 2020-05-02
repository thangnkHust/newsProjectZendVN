@php
    // xu ly trong Helper/form.php
    use App\Helpers\form as formTemplate;
    use App\Helpers\template as template;

    // Lay du lieu class chung trong config 
    $formInputAttr = config('test.template.form_input');
    $formLabelAttr = config('test.template.form_label');
    $inputHiddenID = Form::hidden('id', $item['id']);
    $inputHiddenAvatar = Form::hidden('avatar_current', $item['avatar']);
    $inputHiddenTask = Form::hidden('task', 'change_password');

    $elements = [
        [
            'label' => Form::label('password', 'Password', $formLabelAttr),
            'element' => Form::password('password', $formInputAttr)
        ],
        [
            'label' => Form::label('password_confirmation', 'Password Confirmation', $formLabelAttr),
            'element' => Form::password('password_confirmation', $formInputAttr)
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
                'url' => route("$controllerName/change-password"),
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

