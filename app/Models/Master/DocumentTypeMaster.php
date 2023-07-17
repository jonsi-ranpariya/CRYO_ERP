<?php

namespace App\Models\Master;

use App\Models\BaseModel;


class DocumentTypeMaster extends BaseModel
{
    protected $collection = 'document_type_masters';
    protected $fillable = [
        'docType',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
