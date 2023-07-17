<?php

namespace App\Models\Item;

use App\Models\BaseModel;

class ItemHsnSacMaster extends BaseModel
{
    protected $collection = 'item_hsn_sac_master';
    protected $fillable = [
        'codeDescription',
        'codeNo',
        'codeGlAcc',
        'codeCGSTPercentage',
        'codeCGSTGlAcc',
        'codeSGSTPercentage',
        'codeSGSTGlAcc',
        'codeIGSTPercentage',
        'codeIGSTGlAcc',
        'codeCessPercentage',
        'codeCessGlAcc',
        'codeExciseRegister',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
