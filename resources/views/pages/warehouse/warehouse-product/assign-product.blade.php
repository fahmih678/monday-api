@extends('layouts.master')
@section('title')
    @lang('translation.assign-product')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('route_back', route('manage-warehouses.show', $warehouse->id))
        @slot('li_1')
            Manage Warehouse Product
        @endslot
        @slot('title')
            Assign Product to Warehouse {{ $warehouse->name }}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Assign Product To Warehouse
                    </h4>
                </div><!-- end card header -->

                <div class="card-body">
                    @if ($products->count() == 0)
                        All products has been assigned.
                    @else
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="live-preview">
                            <form action="{{ route('manage-warehouses.attach-product', $warehouse->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">Category</label>
                                    <select class="form-control @error('product_id') is-invalid @enderror" name="product_id"
                                        id="product_id">
                                        <option value="">--Select Product--</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control @error('stock') is-invalid @enderror"
                                        id="stock_display" placeholder="Enter stock" oninput="formatStock(this)"
                                        value={{ old('stock') }}>
                                    {{-- Hidden input untuk simpan angka mentah --}}
                                    <input type="hidden" name="stock" id="stock" value={{ old('stock') }}>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-end">
                                    <a href="{{ route('manage-warehouses.show', $warehouse->id) }}"
                                        class="btn btn-dark me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div><!-- end card body -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function formatStock(input) {
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
        // langsung format saat page load
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.getElementById("stock_display");
            if (input.value) {
                formatStock(input);
            }
        });
    </script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
