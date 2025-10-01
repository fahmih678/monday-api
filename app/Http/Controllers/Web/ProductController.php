<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;
    private CategoryService $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $products = $this->productService->getPaginate(['*'], 5);
        return view('pages.product.index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        $categories = $this->categoryService->getAll(['id', 'name']);
        return view('pages.product.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'about' => 'required|string',
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_popular' => 'boolean',
        ]);

        $product = $this->productService->create($validateData);
        return back()->with('success', 'Category updated successfully');
    }

    public function edit(int $id)
    {
        return view('pages.product.edit', [
            'product' => $this->productService->getById($id, ['*']),
            'categories' => $this->categoryService->getAll(['id', 'name']),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'about' => 'required|string',
            'price' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'is_popular' => 'boolean',
        ]);

        try {
            $product = $this->productService->update($id, $validateData);
            return back()->with('success', 'Category updated successfully');
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Product not found.');
        }
    }
}
