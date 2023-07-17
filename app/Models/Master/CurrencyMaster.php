<?php

namespace App\Models\Master;

use App\Models\BaseModel;


class CurrencyMaster extends BaseModel
{
    protected $collection = 'currency_masters';
    protected $fillable = [
        'currencyCode',
        'currencyRate',
        'currencyCodeEinv',
        'companyId',
        'addedFrom'
    ];

    protected $hidden = ['updated_at'];
}
