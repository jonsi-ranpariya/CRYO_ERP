<?php

namespace App\Models\Item;

use App\Models\BaseModel;

class ItemAddonDetailMaster extends BaseModel
{
    protected $collection = 'item_addon_detail';
    protected $fillable = [
        'addonDetailType',
        'addonDetailTitle',
        'addonDetailDescription',
        'addonDetailIsPrint',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
