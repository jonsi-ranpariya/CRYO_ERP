<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;

class PurchaseEnquiryItemDetail extends BaseModel
{
    protected $collection = 'purchase_enquiry_item_details';

    protected $fillable = [
        'referenceId',
        'itemId',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemMake',
        'itemHsnNumber',
        'itemMsnNumber',
        'itemDetailDescription',
        'itemDrawingNumber',
        'itemDrawingRevision',
        'itemUom',
        'itemConvUom',
        'itemFactor',
        'itemConvQty',
        'itemRequireQuantity',
        'itemRequireQuantityConv',
        'itemQuantityUp',
        'itemStore',
        'itemSoNumber',
        'itemIndentNumber',
        'itemStatus',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];

    protected $appends = ['item_name','uom_detail'];

    public function itemDetail()
    {
        return $this->hasOne(ItemMaster::class,'_id','itemCode');
    }

    public function getItemNameAttribute()
    {
        return $this->itemDetail()->first(['itemCode','itemDescription']);
    }

    public function uom()
    {
        return $this->hasOne(UnitMeasurment::class,'_id','itemUom');
    }

    public function getUomDetailAttribute()
    {
        return $this->uom()->first(['uom']);
    }
}
