<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\MerchantProductRequest;
use App\Http\Requests\MerchantProductUpdateRequest;
use App\Services\MerchantProductService;
use Illuminate\Http\Request;

class MerchantProductController extends Controller
{
    private MerchantProductService $merchantProductService;

    public function __construct(MerchantProductService $merchantProductService)
    {
        $this->merchantProductService = $merchantProductService;
    }

    public function store(MerchantProductRequest $request, int $merchant)
    {
        $validated = $request->validated();
        $validated['merchant_id'] = $merchant;

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
