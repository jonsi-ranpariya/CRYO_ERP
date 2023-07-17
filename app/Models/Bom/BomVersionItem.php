<?php

namespace App\Models\Bom;

use App\Models\BaseModel;
use App\Models\Bom\BillOfMaterialVersion;
use App\Models\Master\ItemMaster;
use App\Models\Bom\BillOfMaterial;
use App\Models\Master\UnitMeasurment;

class BomVersionItem extends BaseModel
{
    protected $collection = 'bill_of_material_version_item';

    protected $fillable = [
        'bomId',
        'versionId',
        'versionItemId',
        'itemType',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemDrawingNumber',
        'itemMaterialSpecification',
        'itemBomQty',
        'itemBomQtyConv',
        'itemConvFactor',
        'itemUom',
        'itemConvUom',
        'itemConvQty',
        'itemMaterialProcessType',
        'itemAssemblyBomNumber',
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
        'itemRateFrom',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $appends = ['item_details', 'uom_detail'];

    public function uom()
    {
        return $this->hasOne(UnitMeasurment::class, '_id', 'itemUom');
    }

    public function getUomDetailAttribute()
    {
        return $this->uom()->first(['uom']);
    }

    public function itemDetail()
    {
        return $this->hasOne(ItemMaster::class, '_id', 'itemCode');
    }

    public function bomDetails()
    {
        return $this->hasOne(BillOfMaterial::class, '_id', 'bomId');
    }

    public function versionDetails()
    {
        return $this->hasOne(BillOfMaterialVersion::class, '_id', 'versionId');
    }

    public function getitemDetailsAttribute()
    {
        return $this->itemDetail()->first(['itemCode']);
    }

    public function bomVersion()
    {
        return $this->belongsTo(BillOfMaterialVersion::class, '_id', 'versionId');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'versionItemId', '_id')->with('children');
    }
}
