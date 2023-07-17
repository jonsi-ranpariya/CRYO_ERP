<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;

class ReturnRejectionMemo extends BaseModel
{
    protected $collection = 'return_rejection_memo';
    protected $fillable = [
        'jobWorkReturnNo',
        'jobWorkReturnDate',
        'subContractorId',
        'subContractorCode',
        'subContractorName',
        'kindAttn',
        'subContractorDetails',
        'headerFooterDetails',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
    public function subContractorDetails()
    {
        return $this->hasOne(JobWorkOrder::class,'_id', 'subContractorCode');
    }
}
