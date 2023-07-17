<?php

namespace App\Models\Item;

use App\Models\BaseModel;

class ItemMainSubGroupMaster extends BaseModel
{
    protected $collection = 'item_main_sub_group';
    protected $fillable = [
        'groupDescription',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
