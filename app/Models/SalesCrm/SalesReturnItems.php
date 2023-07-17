<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;
use App\Models\Master\UnitMeasurment;

class SalesReturnItems extends BaseModel
{
    protected $collection = 'sales_return_items';
    protected $fillable = [
        'salesReturnId',
        'invoiceNo',
        'invoiceDate',
        'itemId',
        'itemCode',
        'itemName',
        'itemCustomDescription',
        'itemAddonDescription',
        'itemDetailDescription',
        'itemDrawingNo',
        'itemDrawingRev',
        'itemProject',
        'itemInternalNote',
        'itemUom',
        'itemCustPartNo',
        'itemNote',
        'itemQuantity',
        'itemRate',
        'itemDiscount',
        'itemDiscountVal',
        'itemNetAmount',
        'itemAmount',
        'itemMsnNumber',
        'itemHsnSacNo',
        'rejectedItemId',
        'rejectedItemCode',
        'rejectedItemName',
        'reason',
        'cgstPercentage',
        'sgstPercentage',
        'igstPercentage',
        'cgstAmount',
        'sgstAmount',
        'igstAmount',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $hidden = ['updated_at'];

    protected $appends = ['uom_details'];

    public function uomData()
    {
        return $this->hasOne(UnitMeasurment::class, '_id', 'itemUom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uomData()->first();
    }
}
