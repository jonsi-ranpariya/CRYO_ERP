<?php

namespace App\Models;

use App\Traits\DatabaseTrait;
use Jenssegers\Mongodb\Eloquent\Model;

abstract class BaseModel extends Model
{
    use DatabaseTrait;

    protected $connection = 'mongodb';

    protected $primaryKey = '_id';

    /**
     * @param $query
     * @param $companyId
     * @return mixed
     */
    public function scopeCompanyWise($query, $companyId)
    {
        return $query->where('companyId', $companyId);
    }
}
