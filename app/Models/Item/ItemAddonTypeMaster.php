<?php

namespace App\Models\Item;

use App\Models\BaseModel;

class ItemAddonTypeMaster extends BaseModel
{
    protected $collection = 'item_addon_type';
    protected $fillable = [
        'addonType',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
