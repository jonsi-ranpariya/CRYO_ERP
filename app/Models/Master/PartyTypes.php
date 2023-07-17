<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class PartyTypes extends BaseModel
{
    protected $collection = 'party_types';
    protected $fillable = [
        'partyType',
        'partyCategory',
        'companyId',
        'addedFrom'

    ];
    protected $hidden = ['updated_at'];
}
