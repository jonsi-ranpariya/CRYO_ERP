<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;

class JobCardReturnShop extends BaseModel
{
    protected $collection = 'job_card_return_shop';

    protected $fillable = [
        'returnNumber',
        'jobCardNumber',
        'jobCardId',
        'returnDate',
        'remarkData',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
}
