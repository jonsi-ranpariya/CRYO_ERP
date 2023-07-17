<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class SerialMaster extends BaseModel
{
    protected $collection = 'serial_master';

    protected $fillable = [
        'description',
        'initial',
        'startingNumber',
        'endingNumber',
        'currentNumber',
        'addedFrom',
        'updateFrom',
        'companyId',
    ];
}
