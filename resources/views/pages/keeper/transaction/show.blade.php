@extends('layouts.master')
@section('title')
    @lang('translation.order-details')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('route_back', route('my-merchant-transactions.index'))

        @slot('li_1')
            Ecommerce
        @endslot
        @slot('title')
            Orders Details
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">Order #VL2667</h5>
                        {{-- <div class="flex-shrink-0">
                            <a href="apps-invoices-details" class="btn btn-success btn-sm"><i
                                    class="ri-download-2-fill align-middle me-1"></i> Invoice</a>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle table-borderless mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">Product Details</th>
                                    <th scope="col">Item Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col" class="text-end">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction->transactionProducts as $tp)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                    <img src="{{ $tp->product->thumbnail }}" alt=""
                                                        class="img-fluid d-block">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="fs-15"><a href="apps-ecommerce-product-details"
                                                            class="link-primary">{{ $tp->product->name }}</a></h5>
                                                    <p class="text-muted mb-0">Color: <span class="fw-medium">Pink</span>
                                                    </p>
                                                    <p class="text-muted mb-0">Size: <span class="fw-medium">M</span></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp. {{ number_format($tp->price) }}</td>
                                        <td>{{ number_format($tp->quantity) }}</td>
                                        <td class="fw-medium text-end">
                                            Rp. {{ number_format($tp->price * $tp->quantity) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="border-top border-top-dashed">
                                    <td colspan="2"></td>
                                    <td colspan="2" class="fw-medium p-0">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>Sub Total :</td>
                                                    <td class="text-end">Rp {{ number_format($transaction->sub_total) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Estimated Tax :</td>
                                                    <td class="text-end">Rp. {{ number_format($transaction->tax_total) }}
                                                    </td>
                                                </tr>
                                                <tr class="border-top border-top-dashed">
                                                    <th scope="row">Total (USD) :</th>
                                                    <th class="text-end">Rp {{ number_format($transaction->grand_total) }}
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!--end card-->
        </div><!--end col-->
        <div class="col-xl-3">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0">Customer Details</h5>
                        <div class="flex-shrink-0">
                            <a href="javascript:void(0);" class="link-secondary">View Profile</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 vstack gap-3">
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ URL::asset('assets/images/users/avatar-3.jpg') }}" alt=""
                                        class="avatar-sm rounded">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{ $transaction->name }}</h6>
                                    <p class="text-muted mb-0">Customer</p>
                                </div>
                            </div>
                        </li>
                        <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $transaction->phone }}</li>
                    </ul>
                </div>
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
