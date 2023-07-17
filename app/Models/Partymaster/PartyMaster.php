<?php

namespace App\Models\Partymaster;

use App\Models\BaseModel;
use App\Models\Master\CurrencyMaster;
use App\Models\Master\PartyTypes;
use Jenssegers\Mongodb\Relations\HasOne;

class PartyMaster extends BaseModel
{
    protected $collection = 'party_masters';
    protected $fillable = [
        'partyCode',
        'partyName',
        'partyType',
        'PartyTypeDealIn',
        'partyTypeStatus',
        'partyTypeBusinessType',
        'partyTypeIndustry',
        'partyBranch',
        'partySupplyType',
        'partyGstType',
        'partyOpeningBalance',
        'partyBalanceType',
        'partyCreditLimit',
        'partyGroup',
        'partyCurrencyType',
        'partyStatus',
        'partyActive',
        'companyId',
        'addedFrom',
        'partyDetails',
        'partyAddress',
        'taxDetails',
        'bankDetails',
        'companyProfile',
        'generalData',
        'loginDetails',
    ];

    protected $appends = ['party_type_name'];

    public function partyTypeData(): HasOne
    {
        return $this->hasOne(PartyTypes::class,'_id','partyType');
    }

    public function getPartyTypeNameAttribute()
    {
        return $this->partyTypeData()->first()->partyType ?? null;
    }

    public function scopeOnlyCustomer($query)
    {
        return $query->where('partyType', getPartyTypeIdByName('Customer'));
    }

    public function scopeOnlyVendor($query)
    {
        return $query->where('partyType', getPartyTypeIdByName('Vendor'));
    }

    public function scopeIndustryWise($query, $value)
    {
        return $query->where('partyTypeIndustry', getPartyIndustryTypeIdByName($value));
    }

    public function scopeOnlyWithoutCustomer($query)
    {
        return $query->where('partyType', '!=', getPartyTypeIdByName('Customer'));
    }

    public function currenyDetails()
    {
        return $this->hasOne(CurrencyMaster::class,'_id', 'partyCurrencyType');
    }
}
