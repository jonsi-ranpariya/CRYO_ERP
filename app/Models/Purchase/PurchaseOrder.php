<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;
use App\Models\Partymaster\PartyMaster;
use Jenssegers\Mongodb\Relations\HasMany;
use Jenssegers\Mongodb\Relations\HasOne;

class PurchaseOrder extends BaseModel
{
    protected $collection = 'purchase_order';

    protected $fillable = [
        'poVendorId',
        'poVendorCode',
        'poVendorName',
        'poStatus',
        'poCurrency',
        'poNumber',
        'poDate',
        'poConversionRate',
        'poAmdNo',
        'poAmdDate',
        'poQtnNo',
        'poQtnDate',
        'purchaseType',
        'poKindAttn',
        'poPhoneCountry',
        'poMobileNo',
        'poEmailId',
        'poRefId',
        'refNo',
        'QuotationNo',
        'poStage',
        'poReviewDate',
        'poSupplyType',
        'poRound',
        'ammendmentDescription',
        'vendorDetails',
        'headerFooterDetails',
        'noteDetails',
        'workAddressDetails',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
//
    protected $appends = ['party_details', 'net_amount', 'gross_amount'];

    public function itemDetails(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchaseOrderId', '_id');
    }

    public function getNetAmountAttribute()
    {
        return $this->itemDetails()->get()->sum('itemNetAmount');
    }


    public function partyDetail(): HasOne
    {
        return $this->hasOne(PartyMaster::class, '_id', 'poVendorCode');
    }

    public function getPartyDetailsAttribute()
    {
        return $this->partyDetail()->first(['partyCode', 'partyName']);
    }

    public function scopeCheckStatus($query, int $status)
    {
        return $query->where('poStatus', $status)->where('poStage' , 'Approved');
    }

    public function scopeWithoutGRNItem($query, $ids)
    {
        return $query->with(['itemDetails' => function ($query) use ($ids) {
            $query->whereNotIn('_id', $ids);
        }]);
    }

    public function billingTermDetails()
    {
        return $this->hasMany(PurchaseOrderBillingTerm::class,'purchaseOrderId', '_id');
    }

    public function getGrossAmountAttribute()
    {
        //testDie($this->billingTermDetails()->get()->toArray());
        return $this->billingTermDetails()
            ->where('calCodeLabel','GRD')
            ->first()
            ?->calculateAmount ?? 0;
    }
}
