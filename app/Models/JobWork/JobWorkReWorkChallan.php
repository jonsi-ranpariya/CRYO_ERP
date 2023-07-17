<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Partymaster\PartyMaster;

class JobWorkReWorkChallan extends BaseModel
{

    protected $collection = 'job_work_rework_challan';
    protected $fillable = [
        'jobWorkId',
        'reWorkChallanNo',
        'reWorkChallanDate',
        'subContractorId',
        'subContractor',
        'subContractorName',
        'itemJobWorkNo',
        'remark',
        'subContractorDetail',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
    protected $appends = ['party_details'];

    public function partyDetails()
    {
        return $this->hasOne(PartyMaster::class,'_id','subContractor');
    }
    public function getPartyDetailsAttribute()
    {
        return $this->partyDetails()->first(['partyCode']);
    }

}
