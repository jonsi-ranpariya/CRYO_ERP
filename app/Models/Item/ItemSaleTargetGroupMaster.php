<?php

namespace App\Models\Item;

use App\Models\BaseModel;

class ItemSaleTargetGroupMaster extends BaseModel
{
    protected $collection = 'item_sales_target_group';
    protected $fillable = [
        'itemGroup',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
