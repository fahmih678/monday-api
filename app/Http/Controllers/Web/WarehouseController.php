<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\WarehouseService;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    private WarehouseService $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    public function index()
    {

        return view('pages.warehouse.index', [
            'warehouses' => $this->warehouseService->getPaginate(['*'], 5),
        ]);
    }

    public function create()
    {
        return view('pages.warehouse.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255|unique:warehouses,name,',
            'address' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'phone' => 'required|string|max:15|unique:warehouses,phone,',
        ]);

        $warehouse = $this->warehouseService->create($validateData);
        return back()->with('success', 'Warehouse created successfully');
    }

    public function show(int $warehouseId)
    {
        $warehouse = $this->warehouseService->getById($warehouseId, ['*']);

        return view('pages.warehouse.show', [
            'products_warehouse' => $warehouse->products()->orderBy('pivot_created_at', 'desc')->paginate(5),
            'warehouse' => $warehouse,
        ]);
    }
}
