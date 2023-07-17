<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class TermsConditionGroupMaster extends BaseModel
{
    protected $collection = 'terms_condition_group';
    protected $fillable = [
        'groupCode',
        'groupDescription',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];

    public function termDetailsData()
    {
        return $this->hasMany(TermsConditionDetailsMaster::class, 'tcGroup', '_id');
    }
}
