<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;

use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;
use App\Models\Upload\FileUpload;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SalesOrderItems extends BaseModel
{
    protected $collection = 'sales_order_items';
    protected $fillable = [
        'salesOrderId',
        'salesOrderNo',
        'itemId',
        'itemCode',
        'itemName',
        'itemCustomDescription',
        'itemAddonDescription',
        'itemDetailDescription',
        'itemMake',
        'itemDrawingNo',
        'itemDrawingRev',
        'itemProject',
        'itemInternalNote',
        'itemSalesType',
        'itemUom',
        'itemMsnNumber',
        'itemCustPartNo',
        'itemNote',
        'itemQuantity',
        'itemPendingQuantity',
        'itemRate',
        'itemDiscount',
        'itemDiscountVal',
        'itemNetAmount',
        'itemAmount',
        'itemStatus',
        'itemType',
        'itemQtnRefNo',
        'itemQtnSrNo',
        'itemDocuments',
        'itemStockStatus',
        'itemHolUnhold',
        'itemImage',
        'itemWorkOrderDetail',
        'itemDispatchDetail',
        'itemDeliverySchedule',
        'itemHsnSacNumber',
        'itemHsnSacId',
        'itemConvUom',
        'itemCFactor',
        'itemConvQty',
        'itemCgstPercentage',
        'itemSgstPercentage',
        'itemIgstPercentage',
        'itemCgstAmount',
        'itemSgstAmount',
        'itemIgstAmount'
    ];

    protected $appends = ['uom_details', 'po_number', 'itemMake'];

    public function getitemMakeAttribute(): ?string
    {
        if (isset($this->attributes['itemMake'])) {
            return match ($this->attributes['itemMake']) {
                is_string($this->attributes['itemMake']) => $this?->attributes['itemMake'] ?? null,
                is_array($this->attributes['itemMake']) => $this?->attributes['itemMake'][0] ?? null,
                default => null,
            };
        } else {
            return null;
        }

    }

    public function uom()
    {
        return $this->hasOne(UnitMeasurment::class, '_id', 'itemUom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uom()->first();
    }

    public function salesOrder()
    {
        return $this->hasOne(SalesOrder::class, '_id', 'salesOrderId');
    }

    public function getPoNumberAttribute()
    {
        return $this->salesOrder()->first([
            'customerPoNo',
            'salesOrderSalesType',
            'sellToPartyCustomerCode',
            'salesOrderPoDate',
            'salesOrderCommittedDate',
            'salesOrderPoDate'
        ]);
    }

    public function scopeOnlyPendingItem($query)
    {
        return $query->where('itemStatus', 'Pending');
    }

    public function itemMasterDetails()
    {
        return $this->hasOne(ItemMaster::class, '_id', 'itemId');
    }

    public function deliverySchedule()
    {
        return $this->hasMany(SalesDeliverySchedule::class, 'salesOrderItemId', '_id');
    }

    public function uploadItemDocument()
    {
        return $this->morphMany( FileUpload::class, 'itemable', 'itemable', '_id', '_id');
    }
}
