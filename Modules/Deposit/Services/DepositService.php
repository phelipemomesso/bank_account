<?php

namespace Modules\Deposit\Services;

use App\Service\BaseService;
use Modules\Account\Entities\Account;
use Modules\Deposit\Entities\Deposit;
use Modules\Deposit\Repositories\DepositRepository;

class DepositService extends BaseService
{
    /**
     * The repository instance.
     *
     * @var DepositRepository
     */
    protected $repository = DepositRepository::class;

    public function makeDeposit(array $attributes, Account $account): Deposit
    {
        $data = [
            'account_id' => $account->id,
            'approved_by' => null,
            'amount' => $attributes['amount'],
            'approved' => 0,
            'image' => $this->uploadCheckImage($attributes['image'])
        ];
        return $this->repository->create($data);
    }

    private function uploadCheckImage($image): ?string {
        if (isset($image) && !empty($image)) {
            $name = uniqid(date('HisYmd'));
            $extension = $image->extension();
            $nameFile = "{$name}.{$extension}";
            $upload = $image->storeAs('deposits', $nameFile);
            if (!$upload)
                return false;
            return $upload;
        }
        return null;
    }
}
