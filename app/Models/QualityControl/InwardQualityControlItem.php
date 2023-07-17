<?php

namespace App\Models\QualityControl;

use App\Models\BaseModel;
use App\Models\Inventory\Transaction;
use App\Models\Master\ItemMaster;
use Jenssegers\Mongodb\Relations\HasOne;
use Jenssegers\Mongodb\Relations\MorphMany;

class InwardQualityControlItem extends BaseModel
{
    protected $collection = 'inward_quality_control_item';
    protected $fillable = [
        'inwardQcId',
        'itemId',
        'goodNoteId',
        'grnItemId',
        'poItemId',
        'purchaseOrderId',
        'poNo',
        'poDate',
        'itemCode',
        'itemDescription',
        'itemDescVendor',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrowingNo',
        'itemRev',
        'itemUom',
        'purchaseUom',
        'itemFactor',
        'grnNo',
        'grnDate',
        'challanNo',
        'challanDate',
        'girNo',
        'girDate',
        'lrNo',
        'lrDate',
        'itemMake',
        'itemStore',
        'deliveryDate',
        'location',
        'indentDate',
        'itemIndentNo',
        'poQuantityUm',
        'pendingQuantityUm',
        'poQuantityUp',
        'pendingQuantityUp',
        'rate',
        'inspQuantity',
        'challanQtyUp',
        'challanQtyUm',
        'acceptedQuantityUp',
        'acceptedQuantityUm',
        'rejectedQuantityUp',
        'rejectedQuantityUm',
        'hold',
        'inspactionDate',
        'grnConversion',
        'heatNo',
        'quantity',
        'manufacturedDate',
        'expiredDate',
        'remark',
    ];

    public function transactions(): MorphMany
    {
        return $this->morphMany(related: Transaction::class, name: 'transactionable', localKey: '_id');
    }

    public function inwardQuality(): HasOne
    {
        return $this->hasOne(InwardQualityControl::class, '_id', 'inwardQcId');
    }

    public function itemMaster(): HasOne
    {
        return $this->hasOne(ItemMaster::class,'_id', 'itemId');
    }
}
