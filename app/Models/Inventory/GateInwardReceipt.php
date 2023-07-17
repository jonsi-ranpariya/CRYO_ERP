<?php

namespace App\Models\Inventory;

use App\Models\Partymaster\PartyMaster;
use App\Models\Purchase\PurchaseOrder;
use App\Models\BaseModel;
use Jenssegers\Mongodb\Relations\HasOne;

class GateInwardReceipt extends BaseModel
{
    protected $collection = 'gate_inward_receipt';
    protected $fillable = [
        'purchaseOrderId',
        'partyId',
        'girNo',
        'girDate',
        'partyCode',
        'partyName',
        'poNo',
        'jwNo',
        'manualPoNo',
        'poJobtype',
        'poJobDate',
        'invoiceNo',
        'invoiceDate',
        'challanNo',
        'challanDate',
        'remark',
        'partyAddress',
        'partyCountry',
        'partyState',
        'partyCity',
        'partyFaxNo',
        'partyEmailId',
        'partyPinCode',
        'partyPhoneCountry',
        'partyPhoneNo',
        'partyWebsite',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];

    protected $appends = ['party_detail'];

    public function partyDetails(): HasOne
    {
        return $this->hasOne(PartyMaster::class,'_id', 'partyId');
    }

    public function getPartyDetailAttribute()
    {
        return $this->partyDetails()->first(['partyName', 'partyCode']);
    }

    public function purchaseOrderDetail()
    {
        return $this->hasOne(PurchaseOrder::class, '_id', 'partyCode');
    }
}
