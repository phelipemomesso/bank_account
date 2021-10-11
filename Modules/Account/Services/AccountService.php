<?php

namespace Modules\Account\Services;

use App\Models\User;
use App\Service\BaseService;
use Illuminate\Support\Arr;
use Modules\Account\Entities\Account;
use Modules\Account\Entities\AccountTransaction;
use Modules\Account\Repositories\AccountRepository;
use Modules\Account\Repositories\AccountTransactionRepository;
use function PHPUnit\Framework\throwException;

class AccountService extends BaseService
{
    const DEBIT = 'D';
    const CREDIT = 'C';

    /**
     * The repository instance.
     *
     * @var AccountRepository
     */
    protected $repository = AccountRepository::class;

    /**
    * The repository instance.
    *
    * @var AccountTransactionRepository
    */
    protected $accountTransactionRepository = AccountTransactionRepository::class;

    public function __construct(
        AccountRepository $repository,
        AccountTransactionRepository $accountTransactionRepository
    ) {
        $this->repository = $repository;
        $this->accountTransactionRepository = $accountTransactionRepository;
    }

    public function hasAccount(User $user)
    {
        $account = $this->repository->findByField('user_id', $user->id);
        if ($account->isNotEmpty()) {
            return $account[0];
        }
        return false;
    }

    public function createAccount(User $user):Account
    {
        return $this->repository->create([
           'user_id' => $user->id,
           'balance' => 0
       ]);
    }

    public function updateBalance(Account $account, float $amount, string $operation): Account
    {
        $value = $operation === self::DEBIT ? $account->balance - $amount :  $account->balance + $amount;
        return $this->repository->update(['balance'=>$value], $account->id);
    }

    public function createTransaction(array $attributes, string $operation)
    {
        return $this->accountTransactionRepository->create([
            'account_id' => $attributes['account_id'],
            'description' => $attributes['description'],
            'amount' => $attributes['amount'],
            'type' => $operation
       ]);
    }

    public function getTransactionsByAccount(Account $account)
    {
        return $this->accountTransactionRepository->findWhere(['account_id' => $account->id]);
    }
}
