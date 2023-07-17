<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class PurchaseTypeMaster extends BaseModel
{
    protected $collection = 'purchase_type_masters';
    protected $fillable = [
        'purchaseType',
        'addedFrom',
        'companyId',
    ];
    protected $hidden = ['updated_at'];
}
