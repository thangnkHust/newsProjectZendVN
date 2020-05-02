@if (session('notify'))
    <div class="alert alert-success">
        <strong>{{ session('notify') }}</strong>
    </div>
@endif