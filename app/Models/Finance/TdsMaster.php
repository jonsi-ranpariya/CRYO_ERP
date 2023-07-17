<?php

namespace App\Models\Finance;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TdsMaster extends BaseModel
{
    use HasFactory;

    protected $collection = 'tds_master';
    protected $fillable = [
        'tdsType',
        'tdsSection',
        'tdsPaymentCode',
        'tdsExemptionLimit',
        'tdsPercentage',
        'tdsRemark',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
