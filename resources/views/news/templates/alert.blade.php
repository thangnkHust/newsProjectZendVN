@if (session('notify'))
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">x</span>
        </button>
        <strong>{{ session('notify') }}</strong>
    </div>
@endif