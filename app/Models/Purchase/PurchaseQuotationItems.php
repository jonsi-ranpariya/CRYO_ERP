<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;

class PurchaseQuotationItems extends BaseModel
{
    protected $collection = 'purchase_quotation_item';

    protected $fillable = [
        'purchaseQuotationId',
        'itemCode',
        'itemDescription',
        'itemMake',
        'itemHsnNumber',
        'itemMsnNumber',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrawingNumber',
        'itemDrawingRevision',
        'itemUom',
        'itemConvUom',
        'itemFactor',
        'itemConvQty',
        'totalAmount',
        'itemNote',
        'itemQuantityUp',
        'itemQuantity',
        'itemRate',
        'itemDiscPercent',
        'itemDiscValue',
        'itemAmount',
        'itemNetAmount',
        'itemStore',
        'itemStatus',
        'itemCgstPercent',
        'itemSgstPercent',
        'itemIgstUgstPercent',
        'itemCgstAmount',
        'itemSgstAmount',
        'itemIgstUgstAmount'
    ];

    protected $appends = ['item_details', 'uom_details', 'quotation_number'];

    public function itemDetails()
    {
        return $this->hasOne(ItemMaster::class, '_id', 'itemCode');
    }

    public function getItemDetailsAttribute()
    {
        return $this->itemDetails()->first(['itemCode', 'itemDescription']);
    }

    public function uomDetails()
    {
        return $this->hasOne(UnitMeasurment::class, '_id', 'itemUom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uomDetails()->first(['uom']);
    }

    public function purchaseQuotation()
    {
        return $this->hasOne(PurchaseQuotation::class, '_id', 'purchaseQuotationId');
    }

    public function getQuotationNumberAttribute()
    {
        return $this->purchaseQuotation()->first(['referenceNumber']);
    }
}
