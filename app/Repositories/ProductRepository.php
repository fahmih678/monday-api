<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll(array $fields)
    {
        return Product::select($fields)->with(['category'])->latest()->get();
    }

    public function getPaginate(array $fields, int $num = 10)
    {
        return Product::select($fields)->with(['category'])->latest()->paginate($num);
    }

    public function getById(int $id, array $fields)
    {
        return Product::select($fields)->with(['category'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(int $id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }

    public function getWith(array $fields, array $with)
    {
        return Product::select($fields)->with($with)->latest()->get();
    }

    public function getAllProductTransactions(array $fields){
        return Product::select($fields)
                ->withSum('transactions', 'sub_total')
                ->withSum('transactions', 'quantity')
                ->withCount('transactions')
                ->orderBy('transactions_count', 'desc')
                ->paginate(10);
    }
}
