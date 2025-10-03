@extends('layouts.master')
@section('title')
    @lang('translation.categories')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Manage Products
        @endslot
        @slot('title')
            Create Product
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Create Product
                    </h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <p class="text-muted">Create new product
                    </p>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="live-preview">
                        <form action="{{ route('manage-products.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control  @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Enter name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Product Price</label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        Rp
                                    </div>
                                    <input type="text" class="form-control @error('price') is-invalid @enderror"
                                        id="price_display" placeholder="Enter price" value="{{ old('price') }}"
                                        oninput="formatCurrency(this)">
                                    {{-- Hidden input untuk simpan angka mentah --}}
                                    <input type="hidden" name="price" id="price"
                                        value="{{ old('price', $product->price ?? '') }}">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Product Category_id</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id"
                                    id="category_id" aria-valuenow="{{ old('category_id') }}">
                                    <option value="">---Select category---</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="is_popular" class="form-label">Is Popular</label>
                                <select class="form-control @error('is_popular') is-invalid @enderror" name="is_popular"
                                    id="is_popular" aria-valuenow="{{ old('is_popular') }}">
                                    <option value="1">Yes, it is.</option>
                                    <option value="0">No, it is not.</option>
                                </select>
                                @error('is_popular')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="about" class="form-label">Product about</label>
                                <input type="text" class="form-control  @error('about') is-invalid @enderror"
                                    id="about" name="about" placeholder="Enter about" value="{{ old('about') }}">
                                @error('about')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="thumbnail" class="form-label">Input thumbnail</label>
                                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                    id="thumbnail" name="thumbnail" accept="image/*">
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div>
                                    <img id="preview-photo" style="display:none; max-width:200px; margin-top:10px;" />
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('manage-products.index') }}" class="btn btn-dark me-2">Cancel</a>
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
        document.getElementById('thumbnail').addEventListener('change', function(event) {
            let preview = document.getElementById('preview-photo');
            let file = event.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        function formatCurrency(input) {
            let value = input.value.replace(/\D/g, ""); // ambil angka aja
            if (value) {
                // tampilkan dengan format ribuan (contoh: 1000000 -> 1.000.000)
                input.value = new Intl.NumberFormat('id-ID').format(value);
                document.getElementById('price').value = value; // simpan angka mentah
            } else {
                input.value = "";
                document.getElementById('price').value = "";
            }
        }
    </script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
