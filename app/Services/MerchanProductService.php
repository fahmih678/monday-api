<?php

namespace App\Services;

use App\Repositories\MerchantProductRepository;
use App\Repositories\WarehouseProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MerchanProductService
{

    private MerchantProductRepository $merchantProductRepository;
    private WarehouseProductRepository $warehouseProductRepository;

    public function __construct(
        MerchantProductRepository $merchantProductRepository,
        WarehouseProductRepository $warehouseProductRepository
    ) {
        $this->merchantProductRepository = $merchantProductRepository;
        $this->warehouseProductRepository = $warehouseProductRepository;
    }

    public function assignProductToMerchant(array $data)
    {
        return DB::transaction(function () use ($data) {
            $warehouseProduct = $this->warehouseProductRepository->getByWarehouseAndProduct(
                $data['warehouse_id'],
                $data['product_id'],
            );
            if (!$warehouseProduct || $warehouseProduct->stock < $data['stock']) {
                throw ValidationException::withMessages([
                    'stock' => ['Insufficient stock in warehouse'],
                ]);
            }
        });
    }
}
