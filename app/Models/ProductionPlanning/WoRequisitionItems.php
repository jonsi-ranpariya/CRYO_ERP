<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;
use Jenssegers\Mongodb\Relations\HasOne;

class WoRequisitionItems extends BaseModel
{
    protected $collection = 'wo_requisition_items';

    protected $fillable = [
        'woRequitionId',
        'jobCardId',
        'jobCardItemId',
        'itemType',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemDrawingNumber',
        'itemDrawingRevision',
        'itemUom',
        'itemConvUom',
        'itemDetailDescription',
        'itemReqQty',
        'itemReqQtyConv',
        'itemPendingQty',
        'itemIssueQty',
        'itemCfactor',
        'itemCurrentStock',
        'itemConvQty',
        'itemWorkOrderId',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];

    protected $appends = ['item_name', 'conv_uom_details'];

    protected $casts = [
        'itemReqQty' => 'float',
        'itemReqQtyConv' => 'float',
        'itemPendingQty' => 'float',
        'itemIssueQty' => 'float',
        'itemCfactor' => 'float',
        'itemCurrentStock' => 'float',
        'itemConvQty' => 'float',
    ];

    public function itemDetail(): HasOne
    {
        return $this->hasOne(ItemMaster::class, '_id', 'itemCode');
    }

    public function getItemNameAttribute(): ?object
    {
        return $this->itemDetail()->first(['itemCode', 'itemDescription']);
    }

    public function convUom(): HasOne
    {
        return $this->hasOne(UnitMeasurment::class, '_id', 'itemConvUom');
    }

    public function getConvUomDetailsAttribute(): ?object
    {
        return $this->convUom()->first(['_id', 'uom']);
    }
}
