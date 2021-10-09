<?php

namespace Modules\Deposit\Services;

use App\Service\BaseService;
use Illuminate\Support\Arr;
use Modules\Deposit\Repositories\DepositRepository;

class DepositService extends BaseService
{
    /**
     * The repository instance.
     *
     * @var DepositRepository
     */
    protected $repository = DepositRepository::class;
}
