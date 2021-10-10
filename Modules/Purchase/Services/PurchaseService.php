<?php

namespace Modules\Purchase\Services;

use App\Service\BaseService;
use Modules\Account\Entities\Account;
use Modules\Purchase\Entities\Purchase;
use Modules\Purchase\Repositories\PurchaseRepository;

class PurchaseService extends BaseService
{
    /**
     * The repository instance.
     *
     * @var PurchaseRepository
     */
    protected $repository = PurchaseRepository::class;

    public function verifyBalance(Account $account, float $amount): bool {
        if($account->balance < $amount) return false;
        return true;
    }

    public function makePurchase(array $attributes, Account $account): Purchase
    {
        $data = [
            'account_id' => $account->id,
            'description' => $attributes['description'],
            'amount' => $attributes['amount'],
        ];
        return $this->repository->create($data);
    }
}
