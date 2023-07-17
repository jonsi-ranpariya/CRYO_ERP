<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class EnquiryReferenceMaster extends BaseModel
{
    protected $collection = 'enquiry_reference_masters';
    protected $fillable = [
        'enquiryReferenceName',
        'companyId',
        'addedFrom',
    ];
    protected $hidden = ['updated_at'];
}
