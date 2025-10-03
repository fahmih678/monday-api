<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\MerchantService;
use App\Services\UserService;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    private MerchantService $merchantService;
    private UserService $userService;


    public function __construct(MerchantService $merchantService, UserService $userService)
    {
        $this->merchantService = $merchantService;
        $this->userService = $userService;
    }

    public function index()
    {
        $merchants = $this->merchantService->getPaginate(['*'], 5);
        return view('pages.merchant.index', [
            'merchants' => $merchants,
        ]);
    }

    public function create()
    {
        $users = $this->userService->getAll(['id', 'name']);
        return view('pages.merchant.create', [
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'keeper_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255|unique:merchants,name,',
            'address' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'phone' => 'required|string|max:15|unique:merchants,phone,',
        ]);

        $merchant = $this->merchantService->create($validateData);
        return back()->with('success', 'merchant created successfully');
    }

    public function show(int $merchantId)
    {
        $merchant = $this->merchantService->getById($merchantId, ['*']);

        return view('pages.merchant.show', [
            'products_merchant' => $merchant->products()->orderBy('pivot_created_at', 'desc')->paginate(5),
            'merchant' => $merchant,
        ]);
    }
}
