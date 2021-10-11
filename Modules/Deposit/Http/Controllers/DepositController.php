<?php

namespace Modules\Deposit\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Account\Services\AccountService;
use Modules\Deposit\Services\DepositService;

class DepositController extends Controller
{
    public function __construct(AccountService $accountService, DepositService $depositService)
    {
        $this->accountService = $accountService;
        $this->depositService = $depositService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $account = null;
        if (!auth()->user()->is_admin) {
            $account = $this->accountService->hasAccount(auth()->user());
            $data = $this->depositService->findByField('account_id', $account->id);
        } else {
            $data = $this->depositService->findWhere(['approved_by'=>null]);
        }
        return Inertia::render('Deposit/List', ['data' => $data, 'account' => $account]);
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
            'check_image' => 'required|file|image|max:2048'
        ]);
        $account = $this->accountService->hasAccount(auth()->user());
        $deposit = $this->depositService->makeDeposit($request->all(), $account);
        return redirect()->back()->with('message', 'Successful Deposit !');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'id' => 'required',
            'account_id' => 'required',
            'amount' => 'required|numeric|gt:0',
            'approved' => 'required'
        ]);
        $deposit = $this->depositService->doAprrove($request->all());
        if ($deposit->approved === true) {
            $account = $this->accountService->find($request->account_id);
            $updateBalance = collect($this->accountService->updateBalance($account, $request->amount, 'C'));
            $this->accountService->createTransaction($deposit->toArray(), 'C');
        }
        return redirect()->back()->with('message', 'Successful Update !');
    }
}
