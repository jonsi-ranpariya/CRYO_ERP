<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;
use App\Models\Inventory\Transaction;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;
use Jenssegers\Mongodb\Relations\MorphMany;

class WorkOrderItem extends BaseModel
{
    protected $table = 'work_order_items';

    protected $fillable = [
        'woId',
        'bomVersionIds',
        'versionItemId',
        'itemType',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemAssemblyBomNumber',
        'itemDrawingNumber',
        'itemBomQty',
        'itemBomQtyConv',
        'itemConvFactor',
        'itemUom',
        'itemConvUom',
        'itemConvQty',
        'itemMaterialProcessType',
        'itemNote',
        'itemDetailDescription',
        'itemCurrentStock',
        'itemPositionNumber',
        'itemRevision',
        'itemIssueAtProcess',
        'itemMake',
        'itemStore',
        'itemMaterialInput1',
        'itemMaterialInput2',
        'itemMaterialLenght',
        'itemMaterialQty',
        'itemMaterialWeight',
        'itemReqQty',
        'itemReqQtyConv',
        'itemPendingQty',
        'itemPendingQtyConv',
        'itemIssueQty',
        'itemIssueQtyConv',
        'itemLocation',
        'itemBinNumber',
        'bomItemCopy',
        'itemStatus',
        'onlyAlternateItem',
        'onlyAlternateItemFromBom',
        'isPrint',
        'addedFrom',
        'updatedFrom'
    ];

    protected $appends = ['item_name','wo_details', 'uom_detail', 'conv_uom_detail'];

    protected $casts = [
        'itemPendingQty' => 'float',
        'itemReqQty' => 'float',
        'itemIssueQty' => 'float',
    ];

    public function itemDetail()
    {
        return $this->hasOne(ItemMaster::class,'_id','itemCode');
    }

    public function getItemNameAttribute()
    {
        return $this->itemDetail()->first(['itemCode','itemDescription','purchaseData.minimumOrderQuantity','purchaseData.maximumOrderQuantity','purchaseData.leadTime']);
    }

    public function workOrderDetail()
    {
        return $this->hasOne(WorkOrder::class,'_id','woId');
    }

    public function getWoDetailsAttribute()
    {
        return $this->workOrderDetail()->first();
    }

    public function uomDetail()
    {
        return $this->hasOne(UnitMeasurment::class,'_id', 'itemUom');
    }

    public function getUomDetailAttribute()
    {
        return $this->uomDetail()->first(['_id','uom']);
    }

    public function convUomDetail()
    {
        return $this->hasOne(UnitMeasurment::class,'_id', 'itemConvUom');
    }

    public function getConvUomDetailAttribute()
    {
        return $this->convUomDetail()->first(['_id','uom']);
    }

    public function transaction(): MorphMany
    {
        return $this->morphMany(related: Transaction::class, name: 'transactionable', localKey: '_id')->with('stockLedger');
    }
}
