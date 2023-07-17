<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class DocumentFooterMaster extends BaseModel
{
    protected $collection = 'document_footers';
    protected $fillable = [
        'footerName',
        'footer',
        'footerType',
        'isDefault',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
