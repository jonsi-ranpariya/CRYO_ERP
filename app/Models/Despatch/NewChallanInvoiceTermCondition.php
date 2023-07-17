<?php

namespace App\Models\Despatch;

use App\Models\BaseModel;
use App\Models\Master\TermsConditionDetailsMaster;
class NewChallanInvoiceTermCondition extends BaseModel
{
    protected $collection = 'new_challan_and_invoice_term_condition';

    protected $fillable = [
        'addedFrom',
        'updatedFrom',
        'companyId',
        'challanInvoiceId',
        'groupId',
        'groupName',
        'termsCondition',
        'byPercentage',
        'byValue',
    ];

    protected $appends = ['tc_group'];

    public function tcGroupDetails()
    {
        return $this->hasOne(TermsConditionDetailsMaster::class,'_id','groupId');
    }

    public function getTcGroupAttribute()
    {
        $response = $this->tcGroupDetails()->with('tcGroupDetails:_id,groupDescription')->first(['_id','tcGroup','tcGroupCode']);

        if (empty($response)){
            return null;
        }

        return $response->tcGroupCode. ' - '. $response->tcGroupDetails->groupDescription;
    }
}
