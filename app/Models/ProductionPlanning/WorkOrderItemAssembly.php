<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;

class WorkOrderItemAssembly extends BaseModel
{
    protected $table = 'work_order_item_assembly';

    protected $fillable = [
        'woId',
        'woItemId',
        'bomVersionIds',
        'itemType',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
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
        'itemDrawingRevision',
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
        'itemLocation',
        'itemBinNumber',
        'bomItemCopy',
        'itemStatus',
        'addedFrom',
        'updatedFrom'
    ];

    protected $appends = ['item_name'];

    public function itemDetail()
    {
        return $this->hasOne(ItemMaster::class,'_id','itemCode');
    }

    public function getItemNameAttribute()
    {
        return $this->itemDetail()->first(['itemCode','itemDescription']);
    }

    public function workOrderDetails()
    {
        return $this->hasOne(WorkOrder::class,'_id','woId');
    }
}
