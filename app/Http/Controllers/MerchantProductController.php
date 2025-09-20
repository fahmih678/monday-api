<?php

namespace App\Http\Controllers;

use App\Http\Requests\MerchantProductRequest;
use App\Http\Requests\MerchantProductUpdateRequest;
use App\Services\MerchanProductService;
use Illuminate\Http\Request;

class MerchantProductController extends Controller
{
    private MerchanProductService $merchantProductService;

    public function __construct(MerchanProductService $merchantProductService)
    {
        $this->merchantProductService = $merchantProductService;
    }

    public function store(MerchantProductRequest $request, int $merchantId)
    {
        $validated = $request->validated();
        $validated['merchant_id'] = $merchantId;

        $merchantProduct = $this->merchantProductService->assignProductToMerchant($validated);

        return response()->json([
            'message' => 'Product assigned to merchant successfully.',
            'data' => $merchantProduct,
        ], 201);
    }

    public function update(MerchantProductUpdateRequest $request, int $merchantId, int $productId)
    {
        $validated = $request->validated();

        $merchantProduct = $this->merchantProductService->updateStock(
            $merchantId,
            $productId,
            $validated['stock'],
            $validated['warehouse_id'],
        );

        return response()->json([
            'message' => 'Stock updated successfully.',
            'data' => $merchantProduct,
        ]);
    }

    public function destroy(int $merchantId, int $productId)
    {
        $this->merchantProductService->removeProductFromMerchant($merchantId, $productId);
        return response()->json([
            'message' => 'Product removed from merchant successfully.',
        ]);
    }
}
