<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getPaginate(['id', 'name', 'photo', 'tagline', 'created_at'], 5);
        return view('pages.category.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('pages.category.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'tagline' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = $this->categoryService->create($validateData);
        return back()->with('success', 'Category created successfully');
    }

    public function edit(int $id)
    {
        return view('pages.category.edit', [
            'category' => $this->categoryService->getById($id, ['id', 'name', 'tagline', 'photo']),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'tagline' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = $this->categoryService->update($id, $validateData);
        return back()->with('success', 'Category updated successfully');
    }

    public function destroy(int $id)
    {
        try {
            $this->categoryService->delete($id);
            return back()->with('success', 'Category deleted successfully');
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Category not found');
        }
    }
}
