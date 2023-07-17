<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;
use App\Models\User;

class SalesOrderStages extends BaseModel
{
    protected $collection = 'sales_order_stages';
    protected $fillable = [
        'addedFrom',
        'updatedFrom',
        'salesOrderId',
        'stage',
        'requireDays',
        'stageDetails',
        'responsibleUser',
        'startDate',
        'endDate',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $appends = ['user_details'];

    public function userDetails()
    {
        return $this->hasOne(User::class,'_id', 'responsibleUser');
    }

    public function getUserDetailsAttribute()
    {
        return $this->userDetails()->first(['_id','first_name','last_name']);
    }
}
