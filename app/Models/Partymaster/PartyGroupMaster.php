<?php

namespace App\Models\Partymaster;

use App\Models\BaseModel;


class PartyGroupMaster extends BaseModel
{
    protected $collection = 'party_group_masters';
    protected $fillable = [
        'groupName',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];


}
