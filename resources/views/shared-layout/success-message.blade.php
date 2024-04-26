@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2 mx-2" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
