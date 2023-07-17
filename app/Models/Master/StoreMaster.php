<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class StoreMaster extends BaseModel
{
    protected $collection = 'store_masters';
    protected $fillable = [
        'storeName',
        'storeAddress',
        'storeCity',
        'storeArea',
        'storePinCode',
        'storeState',
        'storeCountry',
        'storeStdCode',
        'storePhoneNo',
        'storeFax',
        'storeEmail',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
