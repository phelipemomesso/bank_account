<?php

namespace Modules\Purchase\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Account\Services\AccountService;
use Modules\Purchase\Services\PurchaseService;

class PurchaseController extends Controller
{
    public function __construct(AccountService $accountService, PurchaseService $purchaseService)
    {
        $this->accountService = $accountService;
        $this->purchaseService = $purchaseService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $account = $this->accountService->hasAccount(auth()->user());
        $data = $this->purchaseService->findByField('account_id', $account->id);
        return Inertia::render('Purchase/List', ['data' => $data, 'account' => $account]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|min:10',
            'amount' => 'required|numeric|gt:0',
        ]);
        $account = $this->accountService->hasAccount(auth()->user());
        if ($this->purchaseService->verifyBalance($account, $request->amount)) {
            $purchase = $this->purchaseService->makePurchase($request->all(), $account);
            $updateBalancePurchase = $this->accountService->updateBalance($account, $request->amount, 'D');
            $this->accountService->createTransaction($purchase->toArray(), 'D');
            return redirect()->back()->with('message', 'Successful purchase!');
        }
        return redirect()->back()->withErrors('You do not have enough balance for this purchase!');
    }
}
