<?php

namespace App\Repositories;

use App\Models\Merchant;
use App\Models\Product;

class MerchantRepository
{
    public function getAll(array $fields)
    {
        return Merchant::select($fields)->with(['keeper', 'products.category'])->latest()->get();
    }

    public function getPaginate(array $fields, int $num = 10)
    {
        return Merchant::select($fields)->with(['keeper', 'products.category'])->latest()->paginate($num);
    } 

    public function getById(int $id, array $fields)
    {
        return Merchant::select($fields)->with(['keeper', 'products.category'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Merchant::create($data);
    }

    public function update(int $id, array $data)
    {
        $merchant = Merchant::findOrFail($id);
        $merchant->update($data);
        return $merchant;
    }

    public function delete(int $id)
    {
        $merchant = Merchant::findOrFail($id);
        $merchant->delete();
    }

    public function getByKeeperId(int $keeperId, array $fields)
    {
        return Merchant::select($fields)
            ->where('keeper_id', $keeperId)
            ->with(['products.category', 'keeper'])
            ->firstOrFail();
    }

    public function getAllMerchantTransactions($fields){
        return Merchant::select($fields)
                ->withSum('transactions', 'sub_total')
                ->withCount('transactions')
                ->orderBy('transactions_count', 'desc')
                ->paginate(10);


    }
}
