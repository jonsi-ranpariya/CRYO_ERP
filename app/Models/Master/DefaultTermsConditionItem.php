<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Jenssegers\Mongodb\Relations\HasOne;

class DefaultTermsConditionItem extends BaseModel
{
//    protected $connection = 'mongodb';

    protected $collection = 'default_term_condition_item';
    protected $fillable = [
        'defaultId',
        'tcGroup',
        'tcGroupName',
        'tcDescription',
        'addedFrom',
        'updatedFrom',
        'created_at',
        'updated_at',
        'companyId',
    ];
    /**
     * @return HasOne
     */
    public function tcDetails()
    {
        return $this->hasOne(TermsConditionDetailsMaster::class, '_id','tcGroup');
    }

}
