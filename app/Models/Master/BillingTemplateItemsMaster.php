<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class BillingTemplateItemsMaster extends BaseModel
{
    protected $collection = 'billing_template_items';
    protected $fillable = [
        'templateId',
        'serialNo',
        'calCode',
        'calCodeLabel',
        'description',
        'calDefination',
        'percentage',
        'byValue',
        'operation',
        'narration',
        'type',
        'addedFrom',
        'updatedFrom',
        'created_at',
        'updated_at',
        'companyId',
    ];
}
