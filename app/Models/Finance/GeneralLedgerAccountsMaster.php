<?php

namespace App\Models\Finance;

use App\Models\BaseModel;

class GeneralLedgerAccountsMaster extends BaseModel
{
    protected $collection = 'general_ledger_accounts_master';
    protected $fillable = [
        'accountNo',
        'accountName',
        'opBalBook',
        'opBalBook1',
        'opBalBookOption',
        'opBalBookOption1',
        'accountGroup',
        'remarks',
        'tdsPaymentType',
        'chequePrintingFormat',
        'rateOfDepreciationAnual',
        'rateOfDepreciationHalfYear',
        'rateOfDepreciation',
        'opBal',
        'country',
        'state',
        'city',
        'address',
        'PhoneCountry',
        'phoneNo',
        'email',
        'webSite',
        'gstin',
        'hsaSac',
        'hsaSacNo',
        'gstCalCode',
        'hsaSac',
        'isEnableCostCenter',
        'isBankOrCash',
        'isTdsAcc',
        'isFixedAssets',
        'companyId',
        'addedFrom',
    ];
    protected $hidden = ['updated_at'];
}
