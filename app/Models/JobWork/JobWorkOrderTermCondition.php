<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Master\TermsConditionDetailsMaster;

class JobWorkOrderTermCondition extends BaseModel
{
    protected $collection = 'job_work_order_term_condition';

    protected $fillable = [
        'addedFrom',
        'updatedFrom',
        'companyId',
        'jobWorkId',
        'groupId',
        'termsCondition',
      ];
    protected $appends = ['tc_group'];

    public function tcGroupDetails()
    {
        return $this->hasOne(TermsConditionDetailsMaster::class,'_id','groupId');
    }

    public function getTcGroupAttribute()
    {
        $response = $this->tcGroupDetails()->with('tcGroupDetails:_id,groupDescription')->first(['_id','tcGroup','tcGroupCode']);

        return $response->tcGroupCode. ' - '. $response->tcGroupDetails->groupDescription;
    }
}
