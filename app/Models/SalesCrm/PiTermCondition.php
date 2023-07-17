<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PiTermCondition extends BaseModel
{
    use HasFactory;

    protected $collection = 'pi_term_condition';
    protected $fillable = [
        'pInvoiceId',
        'termConditionId',
        'termGroupName',
        'termDetail',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $hidden = ['updated_at'];
}
