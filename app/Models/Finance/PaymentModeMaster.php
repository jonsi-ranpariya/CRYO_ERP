<?php

namespace App\Models\Finance;

use App\Models\BaseModel;

class PaymentModeMaster extends BaseModel
{
    protected $collection = 'payment_mode_master';
    protected $fillable = [
        'paymentMode',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
