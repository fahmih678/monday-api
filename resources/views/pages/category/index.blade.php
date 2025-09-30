@extends('layouts.master')
@section('title')
    @lang('translation.categories')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Category
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">List Categories <span class="text-muted">(17 in totals)</span>
                    </h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('manage-categories.create') }}" class="btn btn-success add-btn"><i
                                class="ri-add-line align-bottom me-1"></i> Add</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <p class="text-muted">Show available categories and count its product here. you can edit photo, name.
                    </p>
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Photo</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <th scope="row">
                                                {{ $categories->firstItem() + $loop->index }}
                                            </th>
                                            <td><img src="{{ $category->photo }}" width="40" height="40"
                                                    alt="Photo"></td>
                                            <td>{{ $category->name }}</td>

                                            <td> {{ $category->products->count() }} listed</td>
                                            <td><!-- Base Buttons -->
                                                <a href="{{ route('manage-categories.edit', $category->id) }}"
                                                    class="btn btn-sm btn-soft-dark waves-effect waves-light" href="#"
                                                    role="button">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card body -->
                <div class="mx-3">
                    {{ $categories->links('components.pagination-bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
