<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;

class RawMaterial extends BaseModel
{

    protected $collection = 'raw_material';
    protected $fillable = [
        'returnNo',
        'returnDate',
        'jobWorkId',
        'subContractorId',
        'jobWorkNo',
        'jwChallanNo',
        'subContractorCode',
        'subContractorName',
        'jwType',
        'subContractorDetail',
        'remarkDetails',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
//    public function subContractorDetails()
//    {
//        return $this->hasOne(JobWorkOrder::class,'_id', 'subContractorCode');
//    }
}
