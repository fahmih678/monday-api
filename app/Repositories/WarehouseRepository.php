<?php

namespace App\Repositories;

use App\Models\Warehouse;

class WarehouseRepository
{
    public function getAll(array $fields)
    {
        $fields = array_merge(['id', 'created_at'], $fields);
        return Warehouse::select($fields)->with(['products.category'])->latest()->get();
    }

    public function getPaginate(array $fields, int $num = 10)
    {
        $fields = array_merge(['id', 'created_at'], $fields);
        return Warehouse::select($fields)->with(['products.category'])->latest()->paginate($num);
    }

    public function getById(int $id, array $fields)
    {
        return Warehouse::select($fields)->with(['products.category'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Warehouse::create($data);
    }

    public function update(int $id, array $data)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update($data);
        return $warehouse;
    }

    public function delete(int $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();
    }
}
