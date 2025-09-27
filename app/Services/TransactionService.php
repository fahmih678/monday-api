<?php

namespace App\Services;

use App\Repositories\MerchantProductRepository;
use App\Repositories\MerchantRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionService
{
    private TransactionRepository $transactionRepository;
    private MerchantProductRepository $merchantProductRepository;
    private ProductRepository $productRepository;
    private MerchantRepository $merchantRepository;

    public function __construct(
        TransactionRepository $transactionRepository,
        MerchantProductRepository $merchantProductRepository,
        ProductRepository $productRepository,
        MerchantRepository $merchantRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->merchantProductRepository = $merchantProductRepository;
        $this->productRepository = $productRepository;
        $this->merchantRepository = $merchantRepository;
    }

    public function getAll(array $fields)
    {
        return $this->transactionRepository->getAll($fields);
    }

    public function getTransactionById(int $id, array $fields)
    {
        return $this->transactionRepository->getById($id, $fields ?? ['*']);
        if (!$transaction) {
            throw ValidationException::withMessages([
                'transaction_id' => 'Transaction not found.',
            ]);
        }
        return $transaction;
    }

    public function getTransactionByMerchant(int $merchantId)
    {
        return $this->transactionRepository->getTransactionByMerchant($merchantId);
    }

    public function createTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
            $merchant = $this->merchantRepository->getById($data['merchant_id'], ['id', 'keeper_id']);

            if (!$merchant) {
                throw ValidationException::withMessages([
                    'merchant_id' => 'Merchant not found.',
                ]);
            }

            if (Auth::id() !== $merchant->keeper_id) {
                throw ValidationException::withMessages([
                    'authorization' => 'You are not authorized to create a transaction for this merchant.',
                ]);
            }

            $product = [];

            $subTotal = 0;
            foreach ($data['products'] as $productData) {
                $merchantProduct = $this->merchantProductRepository->getByMerchantAndProduct(
                    $data['merchant_id'],
                    $productData['product_id']
                );

                // cek product yang ada di merchant
                if (!$merchantProduct || $merchantProduct->stock < $productData['quantity']) {
                    throw ValidationException::withMessages([
                        'stock' => ['Insufficient stock for product ID ' . $productData['product_id'],]
                    ]);
                }

                // cek product dan harganya
                $productInfo = $this->productRepository->getById($productData['product_id'], ['price']);
                if (!$productInfo) {
                    [
                        'product_id' => ['Product ID ' . $productData['product_id'] . ' not found.']
                    ];
                }

                $price = $productInfo->price;
                $productSubTotal = $price * $productData['quantity'];
                $subTotal += $productSubTotal;

                // simpan data product untuk transaksi
                $product[] = [
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'price' => $price,
                    'sub_total' => $productSubTotal,
                ];

                // update stock product di merchant
                $newStock = max(0, $merchantProduct->stock - $productData['quantity']);
                $this->merchantProductRepository->updateStock(
                    $data['merchant_id'],
                    $productData['product_id'],
                    $newStock
                );
            }
            // pajak 10%
            $taxTotal = $subTotal * 0.1;
            $grandTotal = $subTotal + $taxTotal;


            // create transaction
            $transaction = $this->transactionRepository->create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'merchant_id' => $data['merchant_id'],
                'sub_total' => $subTotal,
                'tax_total' => $taxTotal,
                'grand_total' => $grandTotal,
            ]);

            // create transaction products
            $this->transactionRepository->createTransactionProducts($transaction->id, $product);

            return $transaction->fresh();
        });
    }
}
