<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use \Jenssegers\Mongodb\Relations\HasOne;

class TermsConditionDetailsMaster extends BaseModel
{
    protected $collection = 'terms_condition_detail_master';
    protected $fillable = [
        'tcGroupCode',
        'tcGroup',
        'tcGroupDescription',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];

    public function tcGroupDetails()
    {
        return $this->belongsTo(TermsConditionGroupMaster::class, 'tcGroup','_id', 'termDetailsData');
    }
}
