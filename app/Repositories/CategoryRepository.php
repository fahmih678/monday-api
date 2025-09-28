<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getAll(array $fields)
    {
        return Category::select($fields)->with('products')->latest()->get();
    }

    public function getPaginate(array $fields, int $num = 10)
    {
        return Category::select($fields)->with('products')->latest()->paginate($num);
    }

    public function getById(int $id, array $fields)
    {
        return Category::select($fields)->findOrFail($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update(int $id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }

    public function topCategory(){
        return Category::select(['id','name'])->withCount('products')
            ->orderBy('products_count', 'desc')
            ->paginate(10);
    }
}
