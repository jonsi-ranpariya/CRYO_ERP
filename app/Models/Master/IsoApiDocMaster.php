<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class IsoApiDocMaster extends BaseModel
{
    protected $collection = 'iso_api_doc_master';
    protected $fillable = [
        'docName',
        'docFormNo',
        'docFormName',
        'docRevNo',
        'docIssueDate',
        'docRemark',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
