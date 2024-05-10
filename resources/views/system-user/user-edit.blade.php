@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <div>
        @include('shared-layout.success-message')
        <h4 class="card-title">Edit a System User</h4>
        <form class="mt-4" method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('put')
            <div class="row">
                <div class="col col-4">
                    <label class="me-1 form-label">Given Name:</label>
                    <input value="{{ old('first_name', $user->first_name) }}" type="text" autocomplete="given-name"
                        class="form-control @error('first_name') is-invalid  @enderror" name="first_name">
                    @error('first_name')
                        <span class="fs-6 text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col col-4 px-0">
                    <label class="me-1 form-label">Surname:</label>
                    <input value="{{ old('last_name', $user->last_name) }}" type="text" autocomplete="family-name"
                        class="form-control @error('last_name') is-invalid  @enderror" name="last_name">
                    @error('last_name')
                        <span class="fs-6 text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col col-2">
                    <label class="me-1 form-label">MI:</label>
                    <input value="{{ old('mi', $user->mi) }}" type="text" autocomplete="additional-name"
                        class="form-control @error('mi') is-invalid  @enderror" name="mi">
                    @error('mi')
                        <span class="fs-6 text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col col-2 ps-0">
                    <label class="me-1 form-label">Suffix:</label>
                    <input value="{{ old('suffix', $user->suffix) }}" type="text" autocomplete="honorific-suffix"
                        class="form-control @error('suffix') is-invalid  @enderror" name="suffix">
                    @error('suffix')
                        <span class="fs-6 text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row mt-2 align-items-end">
                <div class="col col-4">
                    <label class="me-1 form-label">Email:</label>
                    <input type="email" value="{{ old('email', $user->email) }}" autocomplete="email"
                        class="form-control @error('email') is-invalid  @enderror" name="email">
                    @error('email')
                        <span class="fs-6 text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row mt-2">
                <div class="col col-9">
                    <label class="me-1 form-label">Branch:</label>
                    <select name="branch_id" class="form-select form-select-sm @error('branch_id') is-invalid  @enderror">
                        <option value={{ -1 }}>--Choose Branch--</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(old('branch_id', $user->branch_id) == $branch->id)>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <span class="fs-6 text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col col-3">
                    <label class="me-1 form-label">Role:</label>
                    <select name="role_id" class="form-select form-select-sm @error('role_id') is-invalid  @enderror">
                        <option value={{ -1 }}>--Choose Role--</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="fs-6 text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row mt-4">
                <div class="d-flex flex-row">
                    <a href="{{ route('users') }}" type="submit" class="ms-auto btn btn-danger">Back</a>
                    <a href="{{ route('users.credential.edit', $user->id) }}" role="button" class="btn btn-primary ms-2">Change Password</a>
                    <button type="submit" class="btn btn-success ms-2">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection
