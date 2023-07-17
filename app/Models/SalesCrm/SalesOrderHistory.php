<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;
use App\Models\User;

class SalesOrderHistory extends BaseModel
{
    protected $collection = 'sales_order_history';
    protected $fillable = [
        'addedFrom',
        'updatedFrom',
        'created_at',
        'updated_at',
        'date',
        'history',
        'createdUser',
        'salesOrderId',
    ];

    protected $appends = ['user_details'];

    public function userDetails()
    {
        return $this->hasOne(User::class,'_id', 'createdUser');
    }

    public function getUserDetailsAttribute()
    {
        return $this->userDetails()->first(['_id','first_name','last_name']);
    }
}
