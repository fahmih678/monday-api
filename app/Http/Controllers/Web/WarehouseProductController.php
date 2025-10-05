<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Http\Requests\WarehouseProductUpdateRequest;
use App\Models\Product;
use App\Models\WarehouseProduct;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\WarehouseProductService;
use App\Services\WarehouseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WarehouseProductController extends Controller
{
    private WarehouseService $warehouseService;
    private ProductService $productService;
    private WarehouseProductService $warehouseProductService;

    public function __construct(
        WarehouseService $warehouseService,
        ProductService $productService,
        WarehouseProductService $warehouseProductService
    ) {
        $this->warehouseService = $warehouseService;
        $this->productService = $productService;
        $this->warehouseProductService = $warehouseProductService;
    }

    public function assignProduct(int $warehouseId)
    {
        $warehouse = $this->warehouseService->getById($warehouseId, ['id', 'name']);
        $productsInWarehouses = $this->warehouseProductService->getDistinct(['product_id'])->pluck('product_id')->toArray();

        // ambil produk yang belum ada
        $products = Product::whereNotIn('id', $productsInWarehouses)
            ->get(['id', 'name']);

        return view('pages.warehouse.warehouse-product.assign-product', [
            'warehouse' => $warehouse,
            'products' => $products,
        ]);
    }

    public function editStock(int $warehouseId, int $productId)
    {
        $warehouse = $this->warehouseService->getById($warehouseId, ['*']);
        $product = $warehouse->products()->where('product_id', $productId)->first();

        return view('pages.warehouse.warehouse-product.edit-stock', [
            'warehouse'     => $warehouse,
            'product' => $product,
        ]);
    }


    public function attach(Request $request, int $warehouseId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'stock' => 'required|integer|min:1',
        ]);

        $this->warehouseService->attachProduct(
            $warehouseId,
            $request->input('product_id'),
            $request->input('stock')
        );

        return back()->with('success', 'Product attached successfully');
    }

    public function detach(int $warehouseId, int $productId)
    {
        $this->warehouseService->detachProduct($warehouseId, $productId);
        return response()->json(['message' => 'Product detached successfully']);
    }

    public function update(Request $request, int $warehouseId, int $productId)
    {
        $request->validate([
            'stock' => 'required|integer|min:1',
        ]);

        $warehouseProduct = $this->warehouseService->updateProductStock(
            $warehouseId,
            $productId,
            $request['stock'],
        );

        return back()->with('success', 'Stock updated successfully');
    }
}
