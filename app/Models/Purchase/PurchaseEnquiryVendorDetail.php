<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;
use App\Models\Master\CityMaster;
use App\Models\Master\StateMaster;
use App\Models\Partymaster\PartyMaster;
use App\Models\Partymaster\ContactPerson;

class PurchaseEnquiryVendorDetail extends BaseModel
{
    protected $collection = 'purchase_enquiry_vendor_details';

    protected $fillable = [
        'referenceId',
        'vendorCode',
        'vendorName',
        'vendorAddress',
        'vendorCountry',
        'vendorState',
        'vendorCity',
        'vendorFaxNo',
        'vendorEmailId',
        'vendorWebSite',
        'vendorKindAttn',
        'vendorStatus',
        'vendorPinCode',
        'vendorPhoneCountry',
        'vendorPhoneNo',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];

    protected $appends = ['party_code','city_name','state_name','kind_attn_name'];

    public function partyMasterDetails()
    {
        return $this->hasOne(PartyMaster::class,'_id','vendorCode');
    }

    public function getPartyCodeAttribute()
    {
        return $this->partyMasterDetails()->first(['partyCode','partyName']);
    }

    public function cityDetails()
    {
        return $this->hasOne(CityMaster::class,'_id','vendorCity');
    }

    public function getCityNameAttribute()
    {
        return $this->cityDetails()->first(['city']);
    }

    public function stateDetails()
    {
        return $this->hasOne(StateMaster::class,'_id','vendorState');
    }

    public function getStateNameAttribute()
    {
        return $this->stateDetails()->first(['state']);
    }

    public function kindDetails()
    {
        return $this->hasOne(ContactPerson::class,'_id','vendorKindAttn');
    }

    public function getKindAttnNameAttribute()
    {
        return $this->kindDetails()->first(['personName']);
    }

    public function enquiryDetails()
    {
        return $this->hasOne(PurchaseEnquiry::class,'_id','referenceId');
    }
}
