<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WarehouseProduct;
use App\Services\MerchantProductService;
use App\Services\MerchantService;
use App\Services\ProductService;
use App\Services\WarehouseProductService;
use Illuminate\Http\Request;

class MerchantProductController extends Controller
{
    private MerchantProductService $merchantProductService;
    private MerchantService $merchantService;
    private WarehouseProductService $warehouseProductService;

    public function __construct(
        MerchantProductService $merchantProductService,
        MerchantService $merchantService,
        WarehouseProductService $warehouseProductService
    ) {
        $this->merchantProductService = $merchantProductService;
        $this->merchantService = $merchantService;
        $this->warehouseProductService = $warehouseProductService;
    }

    public function assignProduct(int $merchantId)
    {
        $merchants = $this->merchantService->getById($merchantId, ['*']);
        $merchantProducts = $this->merchantProductService->getProductsByMerchant($merchantId, ['*']);

        // ambil semua product_id yang sudah ada di warehouse ini
        $products_id = $merchantProducts->pluck('product_id')->toArray();
        $warehouses_id = $merchantProducts->pluck('warehouse_id')->toArray();

        $products = $this->warehouseProductService->getDistinct(['product_id', 'warehouse_id', 'stock', 'id']);

        $products = WarehouseProduct::select(['product_id', 'warehouse_id', 'stock', 'id'])
            ->whereNotIn('product_id', $products_id)
            ->with(['product', 'warehouse'])
            ->distinct()
            ->get();

        return view('pages.merchant.merchant-product.assign-product', [
            'merchant' => $merchants,
            'warehouse_products' => $products,
        ]);
    }

    public function editStock(int $merchantId, int $productId)
    {
        $merchantProduct = $this->merchantProductService->getByMerchantAndProduct($merchantId, $productId, ['*']);
        $merchant = $merchantProduct->merchant;
        $product = $merchantProduct->product;
        return view('pages.merchant.merchant-product.edit-stock', [
            'merchant_product' => $merchantProduct,
            'merchant'     => $merchant,
            'product' => $product,
        ]);
    }

    public function attach(Request $request, int $merchant)
    {
        $warehouseProduct = $this->warehouseProductService->getById($request->product, ['*']);
        $request->merge(['product_id' => $warehouseProduct->product_id]);
        $request->merge(['warehouse_id' => $warehouseProduct->warehouse_id]);

        $validated = $request->validate([
            'product' => 'required|exists:warehouse_products,id',
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'stock' => 'required|integer|min:1',
        ]);
        $validated['merchant_id'] = $merchant;

        $merchantProduct = $this->merchantProductService->assignProductToMerchant($validated);

        return back()->with('success', 'Product assigned successfully');
    }

    public function update(Request $request, int $merchantId, int $productId)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'stock' => 'required|integer|min:0',
        ]);

        $merchantProduct = $this->merchantProductService->updateStock(
            $merchantId,
            $productId,
            $validated['stock'],
            $validated['warehouse_id'],
        );

        return back()->with('success', 'Stock updated successfully');
    }

    public function destroy(int $merchantId, int $productId)
    {
        $this->merchantProductService->removeProductFromMerchant($merchantId, $productId);
        return response()->json([
            'message' => 'Product removed from merchant successfully.',
        ]);
    }
}
