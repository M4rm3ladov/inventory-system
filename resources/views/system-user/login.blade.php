@extends('shared-layout.layout')
@section('content')
    <div class="content-container vh-100 d-flex align-items-center">
        <div class="container-fluid">
            <div class="card mx-auto" style="width: 500px">
                <div class="card-body">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <h4 class="card-title text-center">Login</h4>
                        <div class="">
                            <label class="me-1 form-label">Email:</label>
                            <input value="{{ old('email') }}" type="email" autocomplete="email"
                                class="form-control @error('email') is-invalid  @enderror" name="email">
                            @error('email')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="">
                            <label class="me-1 form-label">Password:</label>
                            <input type="password" autocomplete="current-password"
                            class="form-control @error('password') is-invalid  @enderror"
                                name="password">
    
                            @error('password')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success w-100 mt-4">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
