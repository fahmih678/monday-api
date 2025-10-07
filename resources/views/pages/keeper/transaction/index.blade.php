@extends('layouts.master')
@section('title')
    @lang('translation.transactions')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Monday
        @endslot
        @slot('title')
            Transactions List
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <img src="{{ $merchant->photo }}" class="img-fluid me-3" alt="" height="48" width="48">
                    <h4 class="card-title mb-0 flex-grow-1">{{ $merchant->name }} ({{ $merchant->phone }})
                    </h4>
                    <br>
                    <h4 class="card-title mb-0 flex-grow-0">{{ $merchant->keeper->name }} (You)
                    </h4>
                </div><!-- end card header -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">List of transactions
                    </h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('my-merchant-transactions.create') }}" class="btn btn-success add-btn"><i
                                class="ri-add-line align-bottom me-1"></i> Add</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <p class="text-muted">Show transaction
                    </p>
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <th scope="row">
                                                {{ $transactions->firstItem() + $loop->index }}
                                            </th>
                                            <td>{{ $transaction->name }} <br> ({{ $transaction->phone }})</td>

                                            <td>Rp. {{ number_format($transaction->grand_total) }}</td>
                                            <td>
                                                <a href="{{ route('my-merchant-transactions.show', $transaction->id) }}"
                                                    class="btn btn-sm btn-soft-dark waves-effect waves-light me-2"
                                                    href="#" role="button">Details</a>
                                                {{--  <form action="{{ route('manage-categories.destroy', $category->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger btn-icon waves-effect waves-light {{ $category->products->count() > 0 ? 'disabled' : 0 }}"
                                                        onclick="return confirmDelete({{ $category->products->count() }})">
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
                    {{ $transactions->links('components.pagination-bootstrap-5') }}
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
