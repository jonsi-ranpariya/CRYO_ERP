<?php

namespace App\Models\Item;

use App\Models\BaseModel;

class ItemGroupMaster extends BaseModel
{
    protected $collection = 'item_group_master';
    protected $fillable = [
        'groupCode',
        'groupDescription',
        'groupRemark',
        'groupGlAccount',
        'groupSalesTargetGroup',
        'groupUsers',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
