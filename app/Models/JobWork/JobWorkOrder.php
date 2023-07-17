<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Master\CityMaster;
use App\Models\Partymaster\PartyMaster;
use App\Models\User;

class JobWorkOrder extends BaseModel
{
    protected $collection = 'job_work_order';
    protected $fillable = [
        'jobWorkNo',
        'jobWorkDate',
        'subContractorId',
        'subContractorCode',
        'subContractorName',
        'status',
        'isExcisable',
        'jwType',
        'rounding',
        'subContractorDetails',
        'noteDetail',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];

    protected $appends = ['net_amount', 'gross_amount', 'created_by'];

    public function subContractorDetails()
    {
        return $this->hasOne(JobWorkOrder::class, '_id', 'subContractorCode');
    }

    public function cityDetails()
    {
        return $this->hasOne(CityMaster::class, '_id', 'subContractorDetails.contractorCity');
    }

    public function partyDetails()
    {
        return $this->hasOne(PartyMaster::class, '_id', 'subContractorDetails.contractorState');
    }

    public function itemDetails()
    {
        return $this->hasMany(JobWorkOrderItems::class, 'jobWorkId', '_id');
    }

    public function getNetAmountAttribute()
    {
        return $this->itemDetails()->sum('itemEstValue');
    }

    public function billingDetails()
    {
        return $this->hasMany(JobWorkOrderBillingTerm::class, 'jobWorkOrderId', '_id');
    }

    public function getGrossAmountAttribute()
    {
        return $this->billingDetails()->where('calCodeLabel', 'GRD')->first()?->total_amount ?? 0;
    }

    public function createdDetails()
    {
        return $this->hasOne(User::class, '_id', 'addedFrom');
    }

    public function getCreatedByAttribute()
    {
        $user = $this->createdDetails()->first(['first_name', 'last_name']);
        if (!empty($user)) {
            return $user->first_name . ' ' . $user->last_name;
        } else {
            return null;
        }
    }
}
