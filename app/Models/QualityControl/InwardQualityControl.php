<?php

namespace App\Models\QualityControl;

use App\Models\BaseModel;

class InwardQualityControl extends BaseModel
{
    protected $collection = 'inward_quality_control';
    protected $fillable = [
        'goodNoteId',
        'partyId',
        'purchaseOrderId',
        'partyCode',
        'partyName',
        'grnNo',
        'purchaseOrderNo',
        'remarkDetails',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
