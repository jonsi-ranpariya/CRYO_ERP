<?php

namespace App\Models\Despatch;


use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;

class NewChallanInvoiceItems extends BaseModel
{
    protected $collection = 'new_challan_and_invoice_item';

    protected $fillable = [
        'addedFrom',
        'updatedFrom',
        'companyId',
        'challanInvoiceId',
        'salesOrderNo',
        'salesOrderId',
        'salesOrderItemId',
        'itemCode',
        'itemDescription',
        'itemCustomDescription',
        'itemAddDescription',
        'itemDetailDescription',
        'itemMsnNumber',
        'itemDrawingNo',
        'itemRevision',
        'itemUom',
        'itemCustPartNo',
        'itemStore',
        'itemErAndComm',
        'itemPartialDespatch',
        'itemNoPackage',
        'itemMarkAndNos',
        'itemPackageDescription',
        'itemAvgPkg',
        'itemQuantity',
        'itemRate',
        'itemDiscount',
        'itemDiscountValue',
        'itemAmount',
        'itemNetAmount',
        'itemWtInKg',
        'itemRemark',
        'warrantyRequired',
        'cgstPercentage',
        'sgstPercentage',
        'igstPercentage',
        'cgstAmount',
        'sgstAmount',
        'igstAmount',
        'soNumber',
        'itemHsnSacNo',
        'itemHsnSacId',
        'serialNoCode',
        'itemMake',
        'itemConvUom',
        'itemCFactor',
        'itemConvQty',
        'isService',
    ];

    protected $appends = ['uom_details'];

    public function uom()
    {
        return $this->hasOne(UnitMeasurment::class, '_id', 'itemUom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uom()->first();
    }
}
