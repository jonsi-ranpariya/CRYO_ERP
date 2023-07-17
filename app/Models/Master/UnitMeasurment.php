<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class UnitMeasurment extends BaseModel
{
    protected $collection = 'unit_measurments';
    protected $fillable = [
        'uom',
        'uomEreturn',
        'uomEwayBill',
        'uomEinvoice',
        'uomCalculation',
        'addedFrom',
        'companyId'
    ];
    protected $hidden = ['updated_at'];
}
