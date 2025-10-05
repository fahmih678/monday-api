<?php

namespace App\Repositories;

use App\Models\WarehouseProduct;
use Illuminate\Validation\ValidationException;

class WarehouseProductRepository
{
    public function getDistinct(array $fields)
    {
        return WarehouseProduct::select($fields)->distinct()->get();
    }

    public function getByWarehouseAndProduct(int $warehouseId, int $productId): ?WarehouseProduct // type hinting
    {
        return WarehouseProduct::where('warehouse_id', $warehouseId)->where('product_id', $productId)->first();
    }

    public function updateStock(int $warehouseId, int $productId, int $stock): WarehouseProduct // type hinting
    {
        $warehouseProduct = $this->getByWarehouseAndProduct($warehouseId, $productId);

        if (!$warehouseProduct) {
            throw ValidationException::withMessages([
                'product_id' => ['Product not found for this warehouse.']
            ]);
        }
        $warehouseProduct->update(['stock' => $stock]);
        return $warehouseProduct;
    }
}
