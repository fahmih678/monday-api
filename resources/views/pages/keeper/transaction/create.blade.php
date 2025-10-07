@extends('layouts.master')
@section('title')
    @lang('translation.create-transaction')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Keeper
        @endslot
        @slot('title')
            Create Transaction
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Add New Transaction</h4>
                </div>
                <div class="card-body">
                    {{-- filepath: /Users/fahmih678/project/monday-api/resources/views/pages/keeper/transaction/create.blade.php --}}
                    <form action="{{ route('my-merchant-transactions.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Customer Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Customer Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5>Products</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="products_table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Product rows will be added here -->
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary" id="add_product">Add Product</button>

                        <hr>
                        <div class="row mt-4">
                            <div class="col-lg-8"></div>
                            <div class="col-lg-4">
                                <div class="mt-4">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Sub Total</td>
                                                <td class="text-end" id="sub_total">Rp 0</td>
                                            </tr>
                                            <tr>
                                                <td>Tax (10%)</td>
                                                <td class="text-end" id="tax_total">Rp 0</td>
                                            </tr>
                                            <tr>
                                                <th>Grand Total</th>
                                                <th class="text-end" id="grand_total">Rp 0</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Create Transaction</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const products = @json($products);
            let productIndex = 0;

            document.getElementById('add_product').addEventListener('click', function() {
                const tableBody = document.getElementById('products_table').getElementsByTagName('tbody')[
                    0];
                const newRow = tableBody.insertRow();
                newRow.innerHTML = `
                    <td>
                        <select class="form-select product-select" name="products[${productIndex}][product_id]" required>
                            <option value="">Select Product</option>
                            ${products.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name}</option>`).join('')}
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control quantity-input" name="products[${productIndex}][quantity]" min="1" value="1" required>
                    </td>
                    <td class="price">Rp 0</td>
                    <td class="subtotal">Rp 0</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-product">Remove</button>
                    </td>
                `;
                productIndex++;
            });

            document.getElementById('products_table').addEventListener('change', function(e) {
                if (e.target.classList.contains('product-select') || e.target.classList.contains(
                        'quantity-input')) {
                    updateTotals();
                }
            });
            document.getElementById('products_table').addEventListener('input', function(e) {
                if (e.target.classList.contains('quantity-input')) {
                    updateTotals();
                }
            });

            document.getElementById('products_table').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-product')) {
                    e.target.closest('tr').remove();
                    updateTotals();
                }
            });

            function updateTotals() {
                let subTotal = 0;
                const rows = document.getElementById('products_table').getElementsByTagName('tbody')[0].rows;

                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    const productSelect = row.querySelector('.product-select');
                    const quantityInput = row.querySelector('.quantity-input');
                    const priceCell = row.querySelector('.price');
                    const subtotalCell = row.querySelector('.subtotal');

                    const selectedOption = productSelect.options[productSelect.selectedIndex];
                    const price = parseFloat(selectedOption.dataset.price) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;
                    const rowSubtotal = price * quantity;

                    priceCell.textContent = 'Rp ' + price.toLocaleString('id-ID');
                    subtotalCell.textContent = 'Rp ' + rowSubtotal.toLocaleString('id-ID');
                    subTotal += rowSubtotal;
                }

                const taxTotal = subTotal * 0.10;
                const grandTotal = subTotal + taxTotal;

                document.getElementById('sub_total').textContent = 'Rp ' + subTotal.toLocaleString('id-ID');
                document.getElementById('tax_total').textContent = 'Rp ' + taxTotal.toLocaleString('id-ID');
                document.getElementById('grand_total').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
            }
        });
    </script>
@endsection
