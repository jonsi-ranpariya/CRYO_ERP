<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class DocumentHeaderMaster extends BaseModel
{
    protected $collection = 'document_headers';
    protected $fillable = [
        'headerName',
        'header',
        'headerType',
        'isDefault',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
