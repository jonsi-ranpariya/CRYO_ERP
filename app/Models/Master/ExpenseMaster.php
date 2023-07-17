<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class ExpenseMaster extends BaseModel
{
    protected $collection = 'expense_masters';
    protected $fillable = [
        'expense',
        'companyId',
        'addedFrom'

    ];
    protected $hidden = ['updated_at'];
}
