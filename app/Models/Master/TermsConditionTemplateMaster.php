<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TermsConditionTemplateMaster extends BaseModel
{

    protected $collection = 'terms_condition_template_master';
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
        return $this->hasMany(TermsConditionTemplateItemMaster::class,'templateId','_id');
    }

    public function getBillingItemsAttribute()
    {
        return $this->billingItems()->with('tcDetails')->get();
    }

}
