<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;
use App\Models\User;
use Jenssegers\Mongodb\Relations\HasOne;

class SalesHistory extends BaseModel
{
    protected $collection = 'sales_history';
    protected $fillable = [
        'addedFrom',
        'companyId',
        'date',
        'history',
        'salesIqID',
    ];

    /**
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class,'_id','addedFrom');
    }
}
