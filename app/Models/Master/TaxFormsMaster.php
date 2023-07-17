<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class TaxFormsMaster extends BaseModel
{
    protected $collection = 'tax_forms_master';
    protected $fillable = [
        'formName',
        'formDescription',
        'formRemark',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
