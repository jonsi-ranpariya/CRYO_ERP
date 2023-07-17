<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class QuotationTypeMaster extends BaseModel
{
    protected $collection = 'quotation_type_masters';
    protected $fillable = [
        'description',
        'addedFrom',
        'companyId'
    ];
    protected $hidden = ['updated_at'];
}
