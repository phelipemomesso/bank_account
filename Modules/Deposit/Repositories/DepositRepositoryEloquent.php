<?php

namespace Modules\Deposit\Repositories;

use Modules\Deposit\Entities\Deposit;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class DepositRepositoryEloquent extends BaseRepository implements DepositRepository
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
        return Deposit::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
