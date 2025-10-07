<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $fields = ['*'];
        $transactions = $this->transactionService->getAll($fields);
        return back()->with('success', 'Berhasil mengakses halaman transaksi.')->with('transactions', $transactions);
    }

    public function listTransactions()
    {
        $fields = ['*'];
        $merchant = auth()->user()->merchant;
        $transactions = $this->transactionService->getPaginate($fields, 10);
        return view('pages.keeper.transaction.index', compact('transactions', 'merchant'));
    }

    public function create()
    {
        $user = auth()->user();
        if (!$user->hasRole('keeper') || !$user->merchant) {
            return redirect()->route('login')->with('error', 'No merchant assigned, please contact admin.');
        }
        $products = $user->merchant->products ?? collect();
        return view('pages.keeper.transaction.create', [
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->hasRole('keeper') || !$user->merchant) {
            return redirect()->route('login')->with('error', 'No merchant assigned, please contact admin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $validated['merchant_id'] = $user->merchant->id;

        $transaction = $this->transactionService->createTransaction($validated);

        if ($transaction) {
            return redirect()->route('my-merchant-transactions.index')->with('success', 'Transaction created successfully.');
        } else {
            return back()->with('error', 'Failed to create transaction. Please try again.');
        }
    }


    public function show(int $id)
    {
        $fields = ['*'];
        $merchant = auth()->user()->merchant;
        $transaction = $this->transactionService->getTransactionById($id, $fields);
        return view('pages.keeper.transaction.show', compact('transaction', 'merchant'));
    }
}
