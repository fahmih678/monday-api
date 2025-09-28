<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\TransactionProduct;

class TransactionRepository
{
    public function getAll(array $fields)
    {
        return Transaction::select($fields)
            ->with(['transactionProducts.product.category', 'merchant.keeper']) // eager load relationships
            ->latest()
            ->get();
    }

    public function getPaginate(array $fields, int $num = 10)
    {
        return Transaction::select($fields)
            ->with(['transactionProducts.product.category', 'merchant.keeper']) // eager load relationships
            ->latest()
            ->paginate($num);
    }

    public function getById(int $id, array $fields)
    {
        return Transaction::select($fields)
            ->with(['transactionProducts.product.category', 'merchant.keeper']) // eager load relationships
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        return Transaction::create($data);
    }

    public function update(int $id, array $data)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($data);
        return $transaction;
    }

    public function delete(int $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
    }

    public function createTransactionProducts(int $transactionId, array $products)
    {
        foreach ($products as $key => $product) {
            $subTotal = $product['quantity'] * $product['price'];
            TransactionProduct::create([
                'transaction_id' => $transactionId,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'sub_total' => $subTotal,
            ]);
        }
    }

    public function getTransactionByMerchant(int $merchantId)
    {
        return Transaction::where('merchant_id', $merchantId)
            ->select(['id', 'name', 'phone', 'merchant_id', 'grand_total', 'created_at'])
            ->with(['merchant', 'transactionProducts.product.category'])
            ->latest()
            ->paginate(10);
    }

    public function getSumGrandTotalTransaction(){
        return Transaction::sum('sub_total');
    }
}
