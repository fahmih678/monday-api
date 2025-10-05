@extends('layouts.master')
@section('title')
    @lang('translation.users')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Monday
        @endslot
        @slot('title')
            Manage Users
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">List users <span class="text-muted">({{ $users->count() }}
                            in totals)</span>
                    </h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('manage-users.create') }}" class="btn btn-success add-btn"><i
                                class="ri-add-line align-bottom me-1"></i> Add</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <p class="text-muted">Show list users here. you can edit photo, name.
                    </p>
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Photo</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <th scope="row">
                                                {{ $users->firstItem() + $loop->index }}
                                            </th>
                                            <td><img src="{{ $user->photo }}" width="40" height="40" alt="Photo">
                                            </td>
                                            <td>{{ $user->name }} <br> ({{ $user->phone }})</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @foreach ($user->roles as $role)
                                                    <span class="badge badge-soft-primary">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td><!-- Base Buttons -->
                                                <a href="{{ route('manage-users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-soft-dark waves-effect waves-light me-2"
                                                    role="button">Edit</a>
                                                {{-- <form action="" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger btn-icon waves-effect waves-light {{ $product->users->count() > 0 ? 'disabled' : 0 }}"
                                                        onclick="return confirmDelete({{ $product->users->count() }})">
                                                        <i class="ri-delete-bin-5-line"></i>
                                                    </button>
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card body -->
                <div class="mx-3">
                    {{ $users->links('components.pagination-bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- <script>
        function confirmDelete(productCount) {
            if (productCount > 0) {
                alert("Kategori ini masih memiliki produk, tidak bisa dihapus!");
                return false; // cegah submit
            }
            return confirm("Apakah Anda yakin ingin menghapus kategori ini?");
        }
    </script> --}}
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
