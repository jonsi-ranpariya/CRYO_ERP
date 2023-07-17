<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Jenssegers\Mongodb\Relations\HasOne;

class DefaultTermsConditionDetailsMaster extends BaseModel
{
    protected $collection = 'default_terms_condition_master';
    protected $fillable = [
        'tcFor',
        'status',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];

    protected $appends = ['billing_items'];

    public function billingItems()
    {
        return $this->hasMany(DefaultTermsConditionItem::class, 'defaultId', '_id');
    }

    public function getBillingItemsAttribute()
    {
        return $this->billingItems()->with('tcDetails')->get();
    }

}
