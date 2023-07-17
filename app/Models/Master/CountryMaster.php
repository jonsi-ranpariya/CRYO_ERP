<?php

namespace App\Models\Master;

use App\Models\BaseModel;;


class CountryMaster extends BaseModel
{
    protected $collection = 'country_masters';
    protected $fillable = [
        'country',
        'countryCode',
        'addedFrom',
        'companyId',
    ];
    protected $hidden = ['updated_at'];
}
