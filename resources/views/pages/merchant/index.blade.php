@extends('layouts.master')
@section('title')
    @lang('translation.merchants')
@endsection
@section('content')
    @component('components.breadcrumb')
        {{-- @slot('route_back', '') --}}
        @slot('li_1')
            Monday
        @endslot
        @slot('title')
            Manage Merchants
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">List Merchants<span class="text-muted">({{ $merchants->count() }}
                            in totals)</span>
                    </h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('manage-merchants.create') }}" class="btn btn-success add-btn"><i
                                class="ri-add-line align-bottom me-1"></i> Add</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <p class="text-muted">Show list merchants available.
                    </p>
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Photo</th>
                                        <th scope="col">Merchant Name & Manager</th>
                                        <th scope="col">Products</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($merchants as $merchant)
                                        <tr>
                                            <th scope="row">
                                                {{ $merchants->firstItem() + $loop->index }}
                                            </th>
                                            <td><img src="{{ $merchant->photo }}" width="40" height="40"
                                                    alt="Photo"></td>
                                            <td>
                                                {{ $merchant->name }}
                                                <br>
                                                ({{ $merchant->phone }})
                                            </td>
                                            <td>{{ $merchant->products->count() }} Listed</td>
                                            <td><!-- Base Buttons -->
                                                <a href="{{ route('manage-merchants.show', $merchant->id) }}"
                                                    class="btn btn-sm btn-primary waves-effect waves-light me-2"
                                                    href="#" role="button">Details</a>
                                                <form action="{{ route('manage-merchants.destroy', $merchant->id) }}"
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
                    {{ $merchants->links('components.pagination-bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
