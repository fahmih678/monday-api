<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\MerchantService;
use App\Services\ProductService;
use App\Services\TransactionService;
use App\Services\WarehouseService;

class OverviewController extends Controller
{
    private TransactionService $transactionService;
    private WarehouseService $warehouseService;
    private MerchantService $merchantService;
    private ProductService $productService;
    private CategoryService $categoryService;

    public function __construct(
        TransactionService $transactionService,
        WarehouseService $warehouseService,
        MerchantService $merchantService,
        ProductService $productService,
        CategoryService $categoryService
    ) {
        $this->transactionService = $transactionService;
        $this->warehouseService = $warehouseService;
        $this->merchantService = $merchantService;
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        // Monitoring
        $totalRevenue = $this->transactionService->getSumGrandTotalTransaction();
        $totalTransactions = $this->transactionService->getAll(['id'])->count();
        $totalWarehouses = $this->warehouseService->getAll(['id'])->count();
        $totalMerchants = $this->merchantService->getAll(['id'])->count();

        // Analytics
        $bestProducts = $this->productService->getAllProductTransactions(['*']);
        $topMerchants = $this->merchantService->getAllMerchantTransactions(['*']);
        $recentTransactions = $this->transactionService->getPaginate(['*'], 6);
        $topCategories = $this->categoryService->topCategory();

        return view('pages.overview', [
            'total_revenue' => $totalRevenue,
            'total_transactions' => $totalTransactions,
            'total_warehouses' => $totalWarehouses,
            'total_merchants' => $totalMerchants,
            'best_products' => $bestProducts,
            'top_merchants' => $topMerchants,
            'recent_transactions' => $recentTransactions,
            'top_categories' => $topCategories,
        ]);
    }
}
