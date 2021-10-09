<?php

namespace Modules\Account\Services;

use App\Service\BaseService;
use Illuminate\Support\Arr;
use Modules\Account\Repositories\AccountRepository;

class AccountService extends BaseService
{
    /**
     * The repository instance.
     *
     * @var AccountRepository
     */
    protected $repository = AccountRepository::class;
}
