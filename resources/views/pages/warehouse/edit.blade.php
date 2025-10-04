@extends('layouts.master')
@section('title')
    @lang('translation.warehouses')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Manage Warehouses
        @endslot
        @slot('title')
            Edit Warehouse
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Edit Warehouse
                    </h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <p class="text-muted">Edit warehouse information here. You can change the name, phone, location, and
                        photo.
                    </p>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="live-preview">
                        <form action="{{ route('manage-warehouses.update', $warehouse->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Warehouse Name</label>
                                <input type="text" class="form-control  @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Enter name"
                                    value="{{ old('name', $warehouse->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">No Penjaga</label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        (+62)
                                    </div>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone_display" placeholder="Enter phone"
                                        value="{{ old('phone', $warehouse->phone) }}" oninput="formatPhone(this)">
                                    {{-- Hidden input untuk simpan angka mentah --}}
                                    <input type="hidden" name="phone" id="phone"
                                        value="{{ old('phone', $warehouse->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Warehouse location</label>
                                <input type="text" class="form-control  @error('address') is-invalid @enderror"
                                    id="address" name="address" placeholder="Enter location"
                                    value="{{ old('address', $warehouse->address) }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Input Photo</label>
                                <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                    id="photo" name="photo" accept="image/*">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div>
                                    <img id="preview-photo"
                                        src="{{ isset($warehouse->photo) ? asset($warehouse->photo) : '' }}"
                                        style="max-width:200px; margin-top:10px; {{ isset($warehouse->photo) ? '' : 'display:none;' }}" />
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('manage-warehouses.index') }}" class="btn btn-dark me-2">Cancel</a>
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
        document.getElementById('photo').addEventListener('change', function(event) {
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
        function formatPhone(input) {
            // hapus semua karakter non-angka
            let value = input.value.replace(/\D/g, "");

            // format: 4-4-4 (contoh: 0812-3456-7890)
            let formatted = value;
            if (value.length > 4 && value.length <= 8) {
                formatted = value.slice(0, 4) + "-" + value.slice(4);
            } else if (value.length > 8) {
                formatted = value.slice(0, 4) + "-" + value.slice(4, 8) + "-" + value.slice(8, 12);
            }

            input.value = formatted;
            document.getElementById('phone').value = value; // simpan angka mentah ke hidden input
        }

        // langsung format saat page load
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.getElementById("phone_display");
            if (input.value) {
                formatPhone(input);
            }
        });
    </script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
