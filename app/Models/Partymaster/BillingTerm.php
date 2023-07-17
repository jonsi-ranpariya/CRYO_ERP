<?php

namespace App\Models\Partymaster;

use App\Models\BaseModel;

class BillingTerm extends BaseModel
{
    protected $collection = 'party_billing_term';
    protected $fillable = [
        'partyId',
        'billing',
        'calCode',
        'calCodeLabel',
        'description',
        'calDefination',
        'operation',
        'percentage',
        'byValue',
        'narration',
        'templateId',
        'type',
        'addedFrom',
        'companyId',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
