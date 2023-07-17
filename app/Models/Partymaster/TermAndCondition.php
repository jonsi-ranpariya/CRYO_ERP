<?php

namespace App\Models\Partymaster;

use App\Models\BaseModel;

class TermAndCondition extends BaseModel
{
    protected $collection = 'party_term_condition';
    protected $fillable = [
        'partyId',
        'group',
        'groupName',
        'termDetails',
        'addedFrom',
        'companyId'
    ];
}
