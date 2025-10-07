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
        return view('pages.keeper.transaction.create');
    }

    public function show(int $id)
    {
        $fields = ['*'];
        $merchant = auth()->user()->merchant;
        $transaction = $this->transactionService->getTransactionById($id, $fields);
        return view('pages.keeper.transaction.show', compact('transaction', 'merchant'));
    }
}
