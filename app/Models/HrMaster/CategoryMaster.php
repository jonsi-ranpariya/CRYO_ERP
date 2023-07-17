<?php

namespace App\Models\HrMaster;

use App\Models\BaseModel;

class CategoryMaster extends BaseModel
{
    protected $collection = 'category_master';
    protected $fillable = [
        'category',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
