<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class PaymentDeductionMaster extends BaseModel
{
    protected $collection = 'payment_deduction_masters';
    protected $fillable = [
        'deductionDesc',
        'companyId',
        'addedFrom'

    ];
    protected $hidden = ['updated_at'];
}
