<?php

namespace App\Models\Finance;

use App\Models\BaseModel;

class ChequePrintingFormatMaster extends BaseModel
{
    protected $collection = 'cheque_printing_format_master';
    protected $fillable = [
        'formatName',
        'leftMarginDate',
        'leftMarginPayee',
        'leftMarginAcPayee',
        'leftMarginAmount',
        'leftMarginAmountInWord',
        'topMarginDate',
        'topMarginPayee',
        'topMarginAcPayee',
        'topMarginAmount',
        'topMarginAmountInWord',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
