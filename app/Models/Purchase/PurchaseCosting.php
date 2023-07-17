<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;
use App\Models\Master\CityMaster;
use App\Models\Master\CountryMaster;
use App\Models\Master\StateMaster;
use App\Models\Partymaster\PartyMaster;

class PurchaseCosting extends BaseModel
{
    protected $collection = 'purchase_costing';

    protected $fillable = [
        'pcPartyCode',
        'pcPartyName',
        'pcItemCode',
        'pcItemDescription',
        'pcCity',
        'pcDrawingNo',
        'pcDrawingRev',
        'partyDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];

    public function partyDetails()
    {
        return $this->hasOne(PartyMaster::class,'_id', 'pcPartyCode');
    }

    public function cityDetail()
    {
        return $this->hasOne(CityMaster::class,'_id','partyDetails.partyCity');
    }

    public function stateDetail()
    {
        return $this->hasOne(StateMaster::class,'_id','partyDetails.partyState');
    }

    public function countryDetail()
    {
        return $this->hasOne(CountryMaster::class,'_id','partyDetails.partyCountry');
    }
}
