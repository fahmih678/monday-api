@extends('layouts.master')
@section('title')
    @lang('translation.merchants')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('route_back', route('manage-merchants.index'))
        @slot('li_1')
            Manage Merchants
        @endslot
        @slot('title')
            Manage Products in {{ $merchant->name }}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">List Products in {{ $merchant->name }}<span
                            class="text-muted">({{ $products_merchant->count() }}
                            products in total)</span>
                    </h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('manage-merchants.assign-product', $merchant->id) }}"
                            class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1"></i> Assign Product</a>
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
                                        <th scope="col">Stock</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products_merchant as $product)
                                        <tr>
                                            <th scope="row">
                                                {{ $products_merchant->firstItem() + $loop->index }}
                                            </th>
                                            <td><img src="{{ $product->thumbnail }}" width="40" height="40"
                                                    alt="Photo"></td>
                                            <td>{{ $product->name }}
                                                <br>
                                                (Rp. {{ number_format($product->price) }})
                                            </td>
                                            <td>{{ number_format($product->pivot->stock) }}</td>
                                            <td> {{ $product->category->name }}</td>
                                            <td><!-- Base Buttons -->
                                                <a href="{{ route('manage-merchants.edit-stock-product', ['merchant_id' => $merchant->id, 'product_id' => $product->id]) }}"
                                                    class="btn btn-sm btn-secondary waves-effect waves-light me-2"
                                                    href="#" role="button"><i
                                                        class="ri-add-line align-bottom me-1"></i>Edit Stock</a>
                                                <form action="{{ route('manage-products.destroy', $product->id) }}"
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
                    {{ $products_merchant->links('components.pagination-bootstrap-5') }}
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
