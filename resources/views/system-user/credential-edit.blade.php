@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
<div>
    @include('shared-layout.success-message')
    <h4 class="card-title">Edit Password</h4>
    <form class="mt-4" method="POST" action="{{ route('users.credential.update', $user->id) }}">
        @csrf
        @method('put')
        <div class="row">
            <div class="col col-4">
                <label class="me-1 form-label">Password:</label>
                <input type="password" autocomplete="new-password"
                    class="form-control @error('password') is-invalid  @enderror" name="password">
    
                @error('password')
                    <span class="fs-6 text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col col-4">
                <label class="me-1 form-label">Confirm Password:</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid  @enderror"
                    name="password_confirmation">
    
                @error('password_confirmation')
                    <span class="fs-6 text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="d-flex flex-row">
                <a href="{{ route('users.edit', $user->id) }}" type="submit" class="ms-auto btn btn-danger">Back</a>
                <button type="submit" class="btn btn-success ms-2">Update</button>
            </div>
        </div>
    </form>
</div>
@endsection