<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class CertificateTypes extends BaseModel
{
    protected $collection = 'certificate_types';
    protected $fillable = [
        'code',
        'tcType',
        'companyId',
        'addedFrom'

    ];
    protected $hidden = ['updated_at'];
}
