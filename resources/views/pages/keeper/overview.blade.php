@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Monday
        @endslot
        @slot('title')
            Overview
        @endslot
    @endcomponent
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">Good Morning, Anna!</h4>
                                <p class="text-muted mb-0">Here's what's happening with your store
                                    today.</p>
                            </div>
                            <div class="mt-3 mt-lg-0">
                                <form action="javascript:void(0);">
                                    <div class="row g-3 mb-0 align-items-center">
                                        <div class="col-sm-auto">
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control border-0 dash-filter-picker shadow"
                                                    data-provider="flatpickr" data-range-date="true"
                                                    data-date-format="d M, Y"
                                                    data-deafult-date="01 Jan 2022 to 31 Jan 2022">
                                                <div class="input-group-text bg-primary border-primary text-white">
                                                    <i class="ri-calendar-2-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-soft-success"><i
                                                    class="ri-add-circle-line align-middle me-1"></i>
                                                Add Product</button>
                                        </div>
                                        <!--end col-->
                                        <div class="col-auto">
                                            <button type="button"
                                                class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i
                                                    class="ri-pulse-line"></i></button>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

                <div class="row">
                    <div class="col-xl col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            Total Revenue Merchant</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            +16.24 %
                                        </h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">Rp<span class="counter-value"
                                                data-target="{{ $total_revenue }}">0</span>
                                        </h4>
                                        {{-- <a href="" class="text-decoration-underline">View net
                                            earnings</a> --}}
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-success rounded fs-3">
                                            <i class="bx bx-dollar-circle text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            Total Transactions</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h5 class="text-danger fs-14 mb-0">
                                            <i class="ri-arrow-right-down-line fs-13 align-middle"></i>
                                            -3.57 %
                                        </h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                data-target="{{ $total_transactions }}">0</span></h4>
                                        {{-- <a href="" class="text-decoration-underline">View all orders</a> --}}
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded fs-3">
                                            <i class="bx bx-shopping-bag text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->


                    <div class="col-xl col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            Products Sold</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                data-target="{{ $total_products_sold }}">0</span>
                                        </h4>
                                        {{-- <a href="" class="text-decoration-underline">See details</a> --}}
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-warning rounded fs-3">
                                            <i class="bx bx-user-circle text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                </div> <!-- end row-->


            </div> <!-- end .h-100-->

        </div> <!-- end col -->

        <div class="col-auto layout-rightside-col">
            <div class="overlay"></div>
            <div class="layout-rightside">
                <div class="card h-100 rounded-0">
                    <div class="card-body p-0">
                        {{-- <div class="p-3">
                            <h6 class="text-muted mb-0 text-uppercase fw-semibold">Recent Activity</h6>
                        </div>
                        <div data-simplebar style="max-height: 410px;" class="p-3 pt-0">
                            <div class="acitivity-timeline acitivity-main">
                                <div class="acitivity-item d-flex">
                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                        <div class="avatar-title bg-soft-success text-success rounded-circle">
                                            <i class="ri-shopping-cart-2-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Purchase by James Price</h6>
                                        <p class="text-muted mb-1">Product noise evolve smartwatch </p>
                                        <small class="mb-0 text-muted">02:14 PM Today</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                        <div class="avatar-title bg-soft-danger text-danger rounded-circle">
                                            <i class="ri-stack-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Added new <span class="fw-semibold">style
                                                collection</span></h6>
                                        <p class="text-muted mb-1">By Nesta Technologies</p>
                                        <div class="d-inline-flex gap-2 border border-dashed p-2 mb-2">
                                            <a href="apps-ecommerce-product-details" class="bg-light rounded p-1">
                                                <img src="{{ URL::asset('assets/images/products/img-8.png') }}"
                                                    alt="" class="img-fluid d-block" />
                                            </a>
                                            <a href="apps-ecommerce-product-details" class="bg-light rounded p-1">
                                                <img src="{{ URL::asset('assets/images/products/img-2.png') }}"
                                                    alt="" class="img-fluid d-block" />
                                            </a>
                                            <a href="apps-ecommerce-product-details" class="bg-light rounded p-1">
                                                <img src="{{ URL::asset('assets/images/products/img-10.png') }}"
                                                    alt="" class="img-fluid d-block" />
                                            </a>
                                        </div>
                                        <p class="mb-0 text-muted"><small>9:47 PM Yesterday</small></p>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="{{ URL::asset('assets/images/users/avatar-2.jpg') }}" alt=""
                                            class="avatar-xs rounded-circle acitivity-avatar">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Natasha Carey have liked the products
                                        </h6>
                                        <p class="text-muted mb-1">Allow users to like products in your
                                            WooCommerce store.</p>
                                        <small class="mb-0 text-muted">25 Dec, 2021</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xs acitivity-avatar">
                                            <div class="avatar-title rounded-circle bg-secondary">
                                                <i class="mdi mdi-sale fs-14"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Today offers by <a href="apps-ecommerce-seller-details"
                                                class="link-secondary">Digitech Galaxy</a></h6>
                                        <p class="text-muted mb-2">Offer is valid on orders of Rs.500 Or
                                            above for selected products only.</p>
                                        <small class="mb-0 text-muted">12 Dec, 2021</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xs acitivity-avatar">
                                            <div class="avatar-title rounded-circle bg-soft-danger text-danger">
                                                <i class="ri-bookmark-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Favoried Product</h6>
                                        <p class="text-muted mb-2">Esther James have favorited product.
                                        </p>
                                        <small class="mb-0 text-muted">25 Nov, 2021</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xs acitivity-avatar">
                                            <div class="avatar-title rounded-circle bg-secondary">
                                                <i class="mdi mdi-sale fs-14"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Flash sale starting <span
                                                class="text-primary">Tomorrow.</span></h6>
                                        <p class="text-muted mb-0">Flash sale by <a href="javascript:void(0);"
                                                class="link-secondary fw-medium">Zoetic Fashion</a></p>
                                        <small class="mb-0 text-muted">22 Oct, 2021</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xs acitivity-avatar">
                                            <div class="avatar-title rounded-circle bg-soft-info text-info">
                                                <i class="ri-line-chart-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Monthly sales report</h6>
                                        <p class="text-muted mb-2"><span class="text-danger">2 days
                                                left</span> notification to submit the monthly sales
                                            report. <a href="javascript:void(0);"
                                                class="link-warning text-decoration-underline">Reports
                                                Builder</a></p>
                                        <small class="mb-0 text-muted">15 Oct</small>
                                    </div>
                                </div>
                                <div class="acitivity-item d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="{{ URL::asset('assets/images/users/avatar-3.jpg') }}" alt=""
                                            class="avatar-xs rounded-circle acitivity-avatar" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Frank Hook Commented</h6>
                                        <p class="text-muted mb-2 fst-italic">" A product that has
                                            reviews is more likable to be sold than a product. "</p>
                                        <small class="mb-0 text-muted">26 Aug, 2021</small>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="p-3 mt-2">
                            <h6 class="text-muted mb-3 text-uppercase fw-semibold">Top 10 Categories
                            </h6>

                            <ol class="ps-3 text-muted">
                                @foreach ($top_categories as $category)
                                    <li class="py-1">
                                        <a href="#" class="text-muted">{{ $category->name }} <span
                                                class="float-end">({{ $category->products_count }})</span></a>
                                    </li>
                                @endforeach

                            </ol>
                            <div class="mt-3 text-center">
                                <a href="javascript:void(0);" class="text-muted text-decoration-underline">View all
                                    Categories</a>
                            </div>
                        </div>

                        <div class="card sidebar-alert bg-light border-0 text-center mx-4 mb-0 mt-3">
                            <div class="card-body">
                                <img src="{{ URL::asset('assets/images/giftbox.png') }}" alt="">
                                <div class="mt-4">
                                    <h5>Invite New Seller</h5>
                                    <p class="text-muted lh-base">Refer a new seller to us and earn $100
                                        per refer.</p>
                                    <button type="button" class="btn btn-primary btn-label rounded-pill"><i
                                            class="ri-mail-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
                                        Invite Now</button>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                </div> <!-- end card-->
            </div> <!-- end .rightbar-->

        </div> <!-- end col -->
    </div>
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/swiper/swiper.min.js') }}"></script>
    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
