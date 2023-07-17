<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;
use App\Models\Master\UnitMeasurment;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class PurchaseReturnItem extends BaseModel
{
    protected $collection = 'purchase_return_item';
    protected $fillable = [
        'purchaseReturnId',
        'itemCodeId',
        'itemCode',
        'itemDescription',
        'itemMsnNumber',
        'itemDetailDescription',
        'itemCustDescription',
        'itemAddDescription',
        'itemDrawingNo',
        'itemRevision',
        'itemUom',
        'itemHsnNumber',
        'itemQuantity',
        'itemRate',
        'itemDiscount',
        'itemDiscountValue',
        'itemAmount',
        'itemNetAmount',
        'itemCgstPercent',
        'itemSgstPercent',
        'itemIgstPercent',
        'itemCgstAmount',
        'itemSgstAmount',
        'itemIgstAmount',
        'itemRemark',
    ];

    protected $appends = ['uom_detail'];

    public function uomData()
    {
        return $this->hasOne(UnitMeasurment::class,'_id','itemUom');
    }

    public function getUomDetailAttribute()
    {
        return $this->uomData()->first();
    }
}
