<?php

namespace App\Models\Despatch;

use App\Models\Administration\Company;
use App\Models\BaseModel;
use App\Models\GST\MasterGst;
use App\Models\Master\CityMaster;
use App\Models\Master\CountryMaster;
use App\Models\Master\StateMaster;
use App\Models\Partymaster\PartyMaster;

class NewChallanInvoice extends BaseModel
{
    protected $collection = 'new_challan_and_invoice';

    protected $fillable = [
        'addedFrom',
        'UpdatedFrom',
        'companyId',
        'company',
        'SellToParty',
        'sellToDescription',
        'ShipToParty',
        'shipToDescription',
        'invoiceNo',
        'invoiceDate',
        'challanNo',
        'challanDate',
        'orderNo',
        'orderDate',
        'invoice',
        'invoiceType',
        'taxType',
        'gstInvoiceType',
        'salesOrderNumber',
        'sales',
        'supplyType',
        'interstateType',
        'gstCalculationType',
        'reverseCharge',
        'gstPercentage',
        'roundingType',
        'kindAttnId',
        'kindAttnName',
        'kindAttnMobile',
        'kindAttnEmail',
        'currency',
        'currencyRate',
        'partyDetails',
        'buyerDetails',
        'consigneeDetails',
        'dispatchDetails',
        'transportExportData',
        'reportTermAndCondition',
        'reportSupplyType',
    ];

    protected $appends = [
        'ship_to_party_details',
        'sell_to_party_details',
        'buyer_extra_data',
        'party_extra_data',
        'dispatch_extra_data',
        'consignee_extra_data',
        'company_details'
    ];

    public function masterGstDetails()
    {
        return $this->hasOne(MasterGst::class,'challanInvoiceId', '_id');
    }

    public function itemsDetail()
    {
        return $this->hasMany(NewChallanInvoiceItems::class,'challanInvoiceId','_id');
    }

    public function billingTerms()
    {
        return $this->hasMany(NewChallanInvoiceBillingTerm::class,'challanInvoiceId','_id');
    }

    public function companyData()
    {
        return $this->hasOne(Company::class,'_id','company');
    }

    public function getCompanyDetailsAttribute()
    {
        return $this->companyData()->latest()->first();
    }

    public function dispatchData()
    {
        $data['city'] = $this->hasOne(CityMaster::class,'_id','dispatchDetails.dispatchCity');
        $data['state'] = $this->hasOne(StateMaster::class,'_id','dispatchDetails.dispatchState');
        $data['country'] = $this->hasOne(CountryMaster::class,'_id','dispatchDetails.dispatchCountry');

        return $data;
    }

    public function getDispatchExtraDataAttribute()
    {
        $data['city'] = $this->dispatchData()['city']->first(['city']);
        $data['state'] = $this->dispatchData()['state']->first(['state','stateCode']);
        $data['country'] = $this->dispatchData()['country']->first(['country']);

        return $data;
    }

    public function buyerData()
    {
        $data['city'] = $this->hasOne(CityMaster::class,'_id','buyerDetails.buyerCity');
        $data['state'] = $this->hasOne(StateMaster::class,'_id','buyerDetails.buyerState');
        $data['country'] = $this->hasOne(CountryMaster::class,'_id','buyerDetails.buyerCountry');

        return $data;
    }

    public function getBuyerExtraDataAttribute()
    {
        $data['city'] = $this->buyerData()['city']->first(['city']);
        $data['state'] = $this->buyerData()['state']->first(['state','stateCode']);
        $data['country'] = $this->buyerData()['country']->first(['country']);

        return $data;
    }

    public function partyData()
    {
        $data['city'] = $this->hasOne(CityMaster::class,'_id','partyDetails.partyCity');
        $data['state'] = $this->hasOne(StateMaster::class,'_id','partyDetails.partyState');
        $data['country'] = $this->hasOne(CountryMaster::class,'_id','partyDetails.partyCountry');

        return $data;
    }

    public function getPartyExtraDataAttribute()
    {
        $data['city'] = $this->partyData()['city']->first(['city']);
        $data['state'] = $this->partyData()['state']->first(['state','stateCode']);
        $data['country'] = $this->partyData()['country']->first(['country']);

        return $data;
    }

    public function consigneeData()
    {
        $data['city'] = $this->hasOne(CityMaster::class,'_id','consigneeDetails.consigneeCity');
        $data['state'] = $this->hasOne(StateMaster::class,'_id','consigneeDetails.consigneeState');
        $data['country'] = $this->hasOne(CountryMaster::class,'_id','consigneeDetails.consigneeCountry');

        return $data;
    }

    public function getConsigneeExtraDataAttribute()
    {
        $data['city'] = $this->consigneeData()['city']->first(['city']);
        $data['state'] = $this->consigneeData()['state']->first(['state','stateCode']);
        $data['country'] = $this->consigneeData()['country']->first(['country']);

        return $data;
    }

    public function shipToPartyData()
    {
        return $this->hasOne(PartyMaster::class,'_id', 'ShipToParty');
    }

    public function getShipToPartyDetailsAttribute()
    {
        return $this->shipToPartyData()->first(['partyName']);
    }

    public function sellToPartyData()
    {
        return $this->hasOne(PartyMaster::class,'_id', 'SellToParty');
    }

    public function getSellToPartyDetailsAttribute()
    {
        return $this->sellToPartyData()->first(['partyName','partyCode']);
    }
}
