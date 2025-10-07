@extends('layouts.master')
@section('title')
    @lang('translation.create-transaction')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            My Merchant Transactions
        @endslot
        @slot('title')
            Create Transaction
        @endslot
    @endcomponent
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
