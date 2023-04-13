<?php

namespace App\Repositories\Criteria\PromoCode;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class ValidPromoCode extends Criteria {

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        
       $query = $model->where(function ($model) {
                    $model->where('is_valid', 1)
                       ->orWhere("expired_at", "<", date("Y-m-d H:i:s"));
                   });

        return $query;
    }
}

