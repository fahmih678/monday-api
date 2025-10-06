@extends('layouts.master')
@section('title')
    @lang('translation.roles')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Monday
        @endslot
        @slot('title')
            Manage roles
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">List roles
                    </h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('manage-roles.create') }}" class="btn btn-success add-btn"><i
                                class="ri-add-line align-bottom me-1"></i> Add</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <p class="text-muted">Show list roles here. you can edit name.
                    </p>
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Total Users</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <th scope="row">
                                                {{ $loop->index + 1 }}
                                            </th>
                                            </td>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->users->count() }} Users</td>

                                            <td>
                                                <a href="{{ route('manage-roles.edit', $role->id) }}"
                                                    class="btn btn-sm btn-soft-dark waves-effect waves-light me-2"
                                                    role="button">Edit</a>
                                                <form action="{{ route('manage-roles.destroy', $role->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger btn-icon waves-effect waves-light {{ $role->users->count() > 0 ? 'disabled' : 0 }}"
                                                        onclick="return confirmDelete({{ $role->users->count() }})">
                                                        <i class="ri-delete-bin-5-line"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function confirmDelete(usersCount) {
            if (usersCount > 0) {
                alert("Kategori ini masih memiliki produk, tidak bisa dihapus!");
                return false; // cegah submit
            }
            return confirm("Apakah Anda yakin ingin menghapus kategori ini?");
        }
    </script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
