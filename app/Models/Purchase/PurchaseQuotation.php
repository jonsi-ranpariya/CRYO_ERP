<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;
use App\Models\Partymaster\PartyMaster;

class PurchaseQuotation extends BaseModel
{
    protected $collection = 'purchase_qoutation';

    protected $fillable = [
        'referenceId',
        'referenceNumber',
        'referenceDate',
        'currencyId',
        'dueDate',
        'vendorQtnNo',
        'vendorQtnDate',
        'conversationRate',
        'status',
        'purchaseQtnNo',
        'purchaseQtnDate',
        'qtnType',
        'purchaseQuotationRounding',
        'vendorDetails',
        'noteDetails',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];

    protected $appends = ['party_details' , 'grand_total'];

    public function partyDetail()
    {
        return $this->hasOne(PartyMaster::class,'_id','vendorDetails.vendorCode');
    }

    public function getPartyDetailsAttribute()
    {
        return $this->partyDetail()->first(['partyCode','partyName']);
    }

    public function billingDetails()
    {
        return $this->hasMany(PurchaseQuotationBillingTerm::class, 'purchaseQuotationId', '_id');
    }

    public function getGrandTotalAttribute()
    {
        return $this->billingDetails()
            ->where('calCode', 'GRD')
            ->first()
            ?->calculateAmount ?? 0;
    }
}
