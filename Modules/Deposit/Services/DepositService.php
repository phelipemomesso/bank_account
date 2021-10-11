<?php

namespace Modules\Deposit\Services;

use App\Service\BaseService;
use Illuminate\Http\Request;
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
            'description' => $attributes['description'],
            'amount' => $attributes['amount'],
            'approved' => 0,
            'image' => $this->uploadCheckImage($attributes['check_image'])
        ];
        return $this->repository->create($data);
    }

    private function uploadCheckImage($image): ?string
    {
        if (isset($image) && !empty($image)) {
            $name = uniqid(date('HisYmd'));
            $extension = $image->extension();
            $nameFile = "{$name}.{$extension}";
            $upload = $image->move(public_path('uploads/deposits/'), $nameFile);
            if (!$upload) {
                return false;
            }
            return $nameFile;
        }
        return null;
    }

    public function doAprrove(array $attributes): Deposit
    {
        $data['approved_by'] = auth()->user()->id;
        $data['approved'] = $attributes['approved'];
        return $this->repository->update($data, $attributes['id']);
    }
}
