@extends('layouts.master')
@section('title')
    @lang('translation.categories')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('route_back', route('manage-merchants.show', $merchant->id))
        @slot('li_1')
            Manage merchant Product
        @endslot
        @slot('title')
            Edit Stock in merchant {{ $merchant->name }}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Details Product
                    </h4>
                </div><!-- end card header -->

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="width: 200px;">
                                            Product From Warehouse</th>

                                        <td>{{ $merchant_product->warehouse->name }}
                                            ({{ $merchant_product->warehouse->phone }})
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px;">
                                            Product Name</th>
                                        <td>{{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Price</th>
                                        <td>Rp. {{ number_format($product->price) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Stock available</th>
                                        <td>{{ number_format($merchant_product->stock) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">New Stock
                    </h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <form
                            action="{{ route('manage-merchants.update-stock-product', ['merchant_id' => $merchant->id, 'product_id' => $product->id]) }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="warehouse_id" id="warehouse_id"
                                value="{{ $merchant_product->warehouse->id }}">
                            <div class="mb-3">
                                <input type="text" class="form-control @error('stock') is-invalid @enderror"
                                    id="stock_display" placeholder="Enter stock" oninput="formatCurrency(this)">
                                {{-- Hidden input untuk simpan angka mentah --}}
                                <input type="hidden" name="stock" id="stock">
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-end">
                                <a href="{{ route('manage-merchants.show', $merchant->id) }}"
                                    class="btn btn-dark me-2">Cancel</a>
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
    <script>
        function formatCurrency(input) {
            let value = input.value.replace(/\D/g, ""); // ambil angka aja
            if (value) {
                // tampilkan dengan format ribuan (contoh: 1000000 -> 100.000)
                input.value = new Intl.NumberFormat('id-ID').format(value);
                document.getElementById('stock').value = value; // simpan angka mentah
            } else {
                input.value = "";
                document.getElementById('stock').value = "";
            }
        }
    </script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
