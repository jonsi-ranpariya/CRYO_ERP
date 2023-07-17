<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Partymaster\PartyMaster;

class JobWorkRateMaster extends BaseModel
{

    protected $collection = 'job_work_rate_master';
    protected $fillable = [
        'itemCode',
        'itemDescription',
        'itemAlice',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrawingNo',
        'itemRevision',
        'itemUom',
        'cFactor',
        'convUom',
        'subContractorDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
