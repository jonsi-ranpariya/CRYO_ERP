<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Partymaster\PartyMaster;

class   IssueJobWorkChallan extends BaseModel
{
    protected $collection = 'issue_job_work_challan';
    protected $fillable = [
        'jobWorkNo',
        'jobWorkId',
        'jobWorkDate',
        'challanNo',
        'challanDate',
        'subContractorId',
        'subContractorCode',
        'subContractorName',
        'jwType',
        'timeOfIssue',
        'subContractorDetails',
        'noteDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
        ];

}
