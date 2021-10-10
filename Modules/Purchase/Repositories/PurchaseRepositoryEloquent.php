<?php

namespace Modules\Purchase\Repositories;

use Modules\Purchase\Entities\Purchase;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class PurchaseRepositoryEloquent extends BaseRepository implements PurchaseRepository
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
        return Purchase::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
