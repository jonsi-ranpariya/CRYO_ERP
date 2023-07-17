<?php

namespace App\Models\Item;

use App\Models\BaseModel;

class ItemCategoryMaster extends BaseModel
{
    protected $collection = 'item_category';
    protected $fillable = [
        'itemDescription',
        'stockAllowAtWo',
        'planning',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
