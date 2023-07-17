<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;

class PurchaseOrderItem extends BaseModel
{
    protected $collection = 'purchase_order_items';

    protected $fillable = [
        'purchaseOrderId',
        'itemId',
        'itemCode',
        'itemDescription',
        'itemDescVendor',
        'itemAddDescription',
        'itemDetailDescription',
        'itemUom',
        'itemup',
        'itemFactor',
        'itemQty',
        'itemQuantityUm',
        'itemQuantityUp',
        'pendingQtyUm',
        'pendingQtyUp',
        'itemRate',
        'itemDiscount',
        'itemDiscountValue',
        'itemAmount',
        'itemNetAmount',
        'itemSize',
        'itemIndentNo',
        'itemIndentDate',
        'itemIndenter',
        'itemRemark',
        'itemJobNumber',
        'itemMake',
        'itemStore',
        'itemDrowingNo',
        'itemRev',
        'itemStatus',
        'itemDeliveryDate',
        'itemSoNumber',
        'itemWoNumber',
        'itemHsnNumber',
        'itemCgstPercent',
        'itemSgstPercent',
        'itemIgstUgstPercent',
        'itemCgstAmount',
        'itemSgstAmount',
        'itemIgstUgstAmount',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];

    protected $appends = ['item_name','uom_details'];

    public function itemDetails()
    {
        return $this->hasOne(ItemMaster::class,'_id','itemCode');
    }

    public function getItemNameAttribute()
    {
        return $this->itemDetails()->first(['itemCode','itemDescription', 'generalData.location']);
    }

    public function uomDetail()
    {
        return $this->hasOne(UnitMeasurment::class,'_id','itemUom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uomDetail()->first(['uom']);
    }

    public function purchaseOrderDetail()
    {
        return $this->hasOne(PurchaseOrder::class,'_id','purchaseOrderId');
    }
}
