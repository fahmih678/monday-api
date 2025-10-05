<?php

namespace App\Services;

use App\Repositories\WarehouseProductRepository;

class WarehouseProductService
{
    private WarehouseProductRepository $warehouseProductRepository;

    public function __construct(WarehouseProductRepository $warehouseProductRepository)
    {
        $this->warehouseProductRepository = $warehouseProductRepository;
    }

    public function getById(int $id, array $fields)
    {
        return $this->warehouseProductRepository->getById($id, $fields ?? ['*']);
    }

    public function getDistinct(array $fields)
    {
        return $this->warehouseProductRepository->getDistinct($fields);
    }
}
