<?php

namespace App\Models\Purchase;

use App\Models\Administration\Company;
use App\Models\GST\MasterGst;
use App\Models\BaseModel;
use App\Models\Master\InvoiceTypeMaster;
use App\Models\Partymaster\PartyMaster;

class PurchaseReturn extends BaseModel
{
    protected $collection = 'purchase_return';
    protected $fillable = [
        'prSellToParty',
        'prSellToDescription',
        'prShipToParty',
        'prShipToDescription',
        'prInvoiceNo',
        'prInvoiceDate',
        'prInvoice',
        'prInvoiceType',
        'prTaxType',
        'prGstInvoiceType',
        'prSales',
        'prSupplyType',
        'prReverseCharge',
        'prReportSupplyType',
        'prPurchaseBillNo',
        'prPurchaseDate',
        'prReason',
        'prRound',
        'prCompanyId',
        'partyDetails',
        'buyerDetails',
        'consigneeDetails',
        'dispatchDetails',
        'transportExportData',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];

    protected $appends = ['company_detail','master_gst', 'extra_data'];

    public function companyDetails()
    {
        return $this->hasOne(Company::class,'_id','prCompanyId');
    }

    public function getCompanyDetailAttribute()
    {
        return $this->companyDetails()->first();
    }

    public function masterGstData()
    {
        return $this->hasOne(MasterGst::class,'purchaseReturnId','_id');
    }

    public function getMasterGstAttribute()
    {
        return $this->masterGstData()->latest()->first();
    }

    public function sellToPartyData()
    {
        return $this->hasOne(PartyMaster::class,'_id','prSellToParty');
    }

    public function shipToPartyData()
    {
        return $this->hasOne(PartyMaster::class,'_id','prShipToParty');
    }

    public function invoiceTypeData()
    {
        return $this->hasOne(InvoiceTypeMaster::class,'_id','prInvoiceType');
    }

    public function getExtraDataAttribute()
    {
        $data['sellToParty'] = $this->sellToPartyData()->select(['partyName'])->latest()->first();
        $data['shipToParty'] = $this->shipToPartyData()->select(['partyName'])->latest()->first();
        $data['invoiceType'] = $this->invoiceTypeData()->select(['description'])->latest()->first();

        return $data;
    }
}
