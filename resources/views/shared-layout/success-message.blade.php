@if (session()->has('success'))
    <div id="success-message">
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <strong>{{ session('success') }}</strong>
        </div>
    </div>
@endif
<script>
    setTimeout(function() {
        $('#success-message').fadeOut('fast');
    }, 1500);
</script>