@if(session()->has('success'))
    <div class="alert alert-success text-center" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger text-center" role="alert">
        {{ session('error') }}
    </div>
@endif

@if(session()->has('warning'))
    <div class="alert alert-warning text-center" role="alert">
        <p>{{ session('warning') }}
    </div>
@endif

 