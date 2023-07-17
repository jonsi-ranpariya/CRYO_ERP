<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class BankMaster extends BaseModel
{
    protected $collection = 'bank_masters';
    protected $fillable = [
        'bankName',
        'bankBranch',
        'bankAccNo',
        'bankAddress',
        'bankCity',
        'bankPinCode',
        'bankState',
        'bankCountry',
        'bankStdCode',
        'bankPhoneNo',
        'bankFax',
        'bankEmail',
        'bankWebsite',
        'bankIfsCode',
        'bankMicrCode',
        'bankSwiftCode',
        'bankOthersDetail',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
