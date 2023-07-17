<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class InvoiceTypeMaster extends BaseModel
{
    protected $collection = 'invoice_type_master';
    protected $fillable = [
        'description',
        'prefix',
        'currentNo',
        'financialYearAs',
        'separator',
        'sampleNo',
        'location',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $hidden = ['updated_at'];
}
