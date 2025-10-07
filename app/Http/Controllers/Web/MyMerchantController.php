<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyMerchantController extends Controller
{
    public function index()
    {
        $merchant = auth()->user()->merchant;
        return view('pages.keeper.my-merchant.index', [
            'merchant' => $merchant,
            'products_merchant' => $merchant->products()->paginate(10),
        ]);
    }
}
