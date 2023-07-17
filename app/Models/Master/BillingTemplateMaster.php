<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class BillingTemplateMaster extends BaseModel
{
    protected $collection = 'billing_template_master';
    protected $fillable = [
        'templateName',
        'status',
        'addedFrom',
        'updatedFrom',
        'created_at',
        'updated_at',
        'companyId',
    ];

    protected $appends = ['billing_items'];

    public function billingItems()
    {
        return $this->hasMany(BillingTemplateItemsMaster::class,'templateId','_id');
    }

    public function getBillingItemsAttribute()
    {
        return $this->billingItems()->oldest('serialNo')->get();
    }
}
