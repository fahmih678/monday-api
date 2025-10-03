<?php

namespace App\Services;

use App\Repositories\MerchantProductRepository;
use App\Repositories\MerchantRepository;
use App\Repositories\WarehouseProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MerchantProductService
{
    private MerchantRepository $merchantRepository;
    private MerchantProductRepository $merchantProductRepository;
    private WarehouseProductRepository $warehouseProductRepository;

    public function __construct(
        MerchantRepository $merchantRepository,
        MerchantProductRepository $merchantProductRepository,
        WarehouseProductRepository $warehouseProductRepository
    ) {
        $this->merchantRepository = $merchantRepository;
        $this->merchantProductRepository = $merchantProductRepository;
        $this->warehouseProductRepository = $warehouseProductRepository;
    }

    public function getProductsByMerchant(int $merchantId, array $fields)
    {
        return $this->merchantProductRepository->getProductsByMerchant($merchantId, $fields ?? ['*']);
    }

    public function getByMerchantAndProduct(int $merchantId, int $productId, array $fields)
    {
        return $this->merchantProductRepository->getByMerchantAndProduct($merchantId, $productId, $fields ?? ['*']);
    }

    public function assignProductToMerchant(array $data)
    {
        return DB::transaction(function () use ($data) {
            $warehouseProduct = $this->warehouseProductRepository->getByWarehouseAndProduct(
                $data['warehouse_id'],
                $data['product_id'],
            );
            // cek data di warehouse
            if (!$warehouseProduct || $warehouseProduct->stock < $data['stock']) {
                throw ValidationException::withMessages([
                    'stock' => ['Insufficient stock in warehouse'],
                ]);
            }

            $existingProduct = $this->merchantProductRepository->getByMerchantAndProduct(
                $data['merchant_id'],
                $data['product_id'],
            );

            if ($existingProduct) {
                throw ValidationException::withMessages([
                    'product' => ['Product already assigned to this merchant.'],
                ]);
            }

            // kurangi stock di warehouse
            $this->warehouseProductRepository->updateStock(
                $data['warehouse_id'],
                $data['product_id'],
                $warehouseProduct->stock - $data['stock']
            );

            // tambah product ke merchant
            return $this->merchantProductRepository->create([
                'warehouse_id' => $data['warehouse_id'],
                'merchant_id' => $data['merchant_id'],
                'product_id' => $data['product_id'],
                'stock' => $data['stock'],
            ]);
        });
    }

    public function updateStock(int $merchantId, int $productId, int $newStock, int $warehouseId)
    {
        return DB::transaction(function () use ($merchantId, $productId, $newStock, $warehouseId) {
            // cek produk di merchant  
            $existing = $this->merchantProductRepository->getByMerchantAndProduct($merchantId, $productId);
            if (!$existing) {
                throw ValidationException::withMessages([
                    'product' => ['Product not found for this merchant.'],
                ]);
            }
            if (!$warehouseId) {
                throw ValidationException::withMessages([
                    'warehouse' => ['Warehouse ID is required to update stock.'],
                ]);
            }

            // stock saat ini di merchant
            $currentStock = $existing->stock;

            // jika stock baru lebih besar dari stock saat ini, berarti perlu ambil dari warehouse
            if ($newStock > $currentStock) {
                $diff = $newStock - $currentStock;
                $warehouseProduct = $this->warehouseProductRepository->getByWarehouseAndProduct($warehouseId, $productId);
                if (!$warehouseProduct || $warehouseProduct->stock < $diff) {
                    throw ValidationException::withMessages([
                        'stock' => ['Insufficient stock in warehouse'],
                    ]);
                }
                // kurangi stock di warehouse
                $this->warehouseProductRepository->updateStock(
                    $warehouseId,
                    $productId,
                    $warehouseProduct->stock - $diff
                );
            }
            // jika stock baru lebih kecil dari stock saat ini, berarti perlu kembalikan ke warehouse
            if ($newStock < $currentStock) {
                $diff = $currentStock - $newStock;
                $warehouseProduct = $this->warehouseProductRepository->getByWarehouseAndProduct($warehouseId, $productId);
                // jika tidak ada di warehouse, lempar error
                if (!$warehouseProduct) {
                    throw ValidationException::withMessages([
                        'warehouse' => ['Product not found in warehouse.'],
                    ]);
                }
                // jika ada, tambahkan stock di warehouse
                $this->warehouseProductRepository->updateStock(
                    $warehouseId,
                    $productId,
                    $warehouseProduct->stock + $diff
                );
            }

            // update stock di merchant
            return $this->merchantProductRepository->updateStock($merchantId, $productId, $newStock);
        });
    }

    // remove product from merchant and return stock to warehouse
    public function removeProductFromMerchant(int $merchantId, int $productId)
    {
        $merchant = $this->merchantRepository->getById($merchantId, ['id']);
        if (!$merchant) {
            throw ValidationException::withMessages([
                'merchant' => ['Merchant not found.'],
            ]);
        }

        $exists = $this->merchantProductRepository->getByMerchantAndProduct($merchantId, $productId);
        if (!$exists) {
            throw ValidationException::withMessages([
                'product' => ['Product not found for this merchant.'],
            ]);
        }
        $merchant->products()->detach($productId);
    }
}
