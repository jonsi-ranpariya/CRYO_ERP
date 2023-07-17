<?php

namespace App\Models\MRP;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;
use App\Models\ProductionPlanning\WorkOrder;
use App\Models\SalesCrm\SalesOrder;

class MrpIndent extends BaseModel
{
    protected $collection = 'mrp_indent';

    protected $fillable = [
        'woItemId',
        'itemId',
        'itemCode',
        'itemDescription',
        'addDescription',
        'detailDescription',
        'drawingNumber',
        'rev',
        'uom',
        'up',
        'cFactor',
        'reqQtyUm',
        'reqQtyUp',
        'conveQty',
        'size',
        'reqQtyConv',
        'qtyNos',
        'planningType',
        'itemMake',
        'store',
        'leadTime',
        'deliveryDate',
        'indentDate',
        'indentNo',
        'minOrderQty',
        'maxOrderQty',
        'soId',
        'soNumber',
        'woId',
        'woNumber',
        'forecastNo',
        'remark',
        'currentStock',
        'pendingIndent',
        'pendingPurchaseOrder',
        'pendingForInspection',
        'reqQtyAgainstWo',
        'mrpConversion',
        'itemMsnNumber',
        'itemHsnNumber',
        'indentCreatedFrom',
        'indentCreatedMenuId',
        'loginDetails',
    ];

    protected $appends = ['so_name', 'wo_name', 'item_name', 'uom_details'];

    public function soDetails()
    {
        return $this->hasOne(SalesOrder::class, '_id', 'soId');
    }

    public function woDetails()
    {
        return $this->hasOne(WorkOrder::class, '_id', 'woId');
    }

    public function getSoNameAttribute()
    {
        return $this->soDetails()->first(['salesOrderNo']);
    }

    public function getWoNameAttribute()
    {
        return $this->woDetails()->first(['woNumber']);
    }

    public function itemDetail()
    {
        return $this->hasOne(ItemMaster::class, '_id', 'itemId');
    }

    public function getItemNameAttribute()
    {
        return $this->itemDetail()->first(['itemCode', 'itemDescription']);
    }

    public function uomDetail()
    {
        return $this->hasOne(UnitMeasurment::class, '_id', 'uom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uomDetail()->first(['uom']);
    }
}
