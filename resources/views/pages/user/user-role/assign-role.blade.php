@extends('layouts.master')
@section('title')
    @lang('translation.users')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Manage Users
        @endslot
        @slot('title')
            Assign Role to User
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Assign Role to User
                    </h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <p class="text-muted">Assign a role to an existing user
                    </p>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="live-preview">
                        <form action="{{ route('manage-users.assign-role.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="user" class="form-label">Select User</label>
                                <select class="form-control @error('user') is-invalid @enderror" name="user"
                                    id="user">
                                    <option value="">---Select user---</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Select role</label>
                                <select class="form-control @error('role') is-invalid @enderror" name="role"
                                    id="role" aria-valuenow="{{ old('role') }}">
                                    <option value="">---Select role---</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-end">
                                <a href="{{ route('manage-users.index') }}" class="btn btn-dark me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
