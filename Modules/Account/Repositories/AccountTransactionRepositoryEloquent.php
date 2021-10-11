<?php

namespace Modules\Account\Repositories;

use Modules\Account\Entities\AccountTransaction;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class AccountTransactionRepositoryEloquent extends BaseRepository implements AccountTransactionRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'account_id',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AccountTransaction::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
