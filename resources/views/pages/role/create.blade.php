@extends('layouts.master')
@section('title')
    @lang('translation.roles')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Manage Roles
        @endslot
        @slot('title')
            Create Role
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Create Role
                    </h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <p class="text-muted">Create new role
                    </p>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="live-preview">
                        <form action="{{ route('manage-roles.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" class="form-control  @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Enter name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('manage-roles.index') }}" class="btn btn-dark me-2">Cancel</a>
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
