@extends('layouts.master')
@section('title')
    @lang('translation.products')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Products
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">List Products <span class="text-muted">({{ $products->count() }}
                            in totals)</span>
                    </h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('manage-products.create') }}" class="btn btn-success add-btn"><i
                                class="ri-add-line align-bottom me-1"></i> Add</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <p class="text-muted">Show list products here. you can edit photo, name.
                    </p>
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Photo</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <th scope="row">
                                                {{ $products->firstItem() + $loop->index }}
                                            </th>
                                            <td><img src="{{ $product->thumbnail }}" width="40" height="40"
                                                    alt="Photo"></td>
                                            <td>{{ $product->name }} (Rp. {{ number_format($product->price) }})</td>

                                            <td> {{ $product->category->name }}</td>
                                            <td><!-- Base Buttons -->
                                                <a href="{{ route('manage-categories.edit', $product->id) }}"
                                                    class="btn btn-sm btn-soft-dark waves-effect waves-light me-2"
                                                    href="#" role="button">Edit</a>
                                                <form action="{{ route('manage-categories.destroy', $product->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- <button type="submit"
                                                        class="btn btn-sm btn-danger btn-icon waves-effect waves-light {{ $product->products->count() > 0 ? 'disabled' : 0 }}"
                                                        onclick="return confirmDelete({{ $product->products->count() }})">
                                                        <i class="ri-delete-bin-5-line"></i>
                                                    </button> --}}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card body -->
                <div class="mx-3">
                    {{ $products->links('components.pagination-bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function confirmDelete(productCount) {
            if (productCount > 0) {
                alert("Kategori ini masih memiliki produk, tidak bisa dihapus!");
                return false; // cegah submit
            }
            return confirm("Apakah Anda yakin ingin menghapus kategori ini?");
        }
    </script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
