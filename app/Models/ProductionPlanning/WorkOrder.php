<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;
use App\Models\Partymaster\PartyMaster;
use App\Models\Master\UnitMeasurment;
use App\Models\Bom\BillOfMaterialVersion;
use App\Models\SalesCrm\SalesOrder;

class WorkOrder extends BaseModel
{
    protected $collection = 'work_orders';

    protected $fillable = [
        'woNumber',
        'woDate',
        'soId',
        'soNumber',
        'soDate',
        'partyCode',
        'custPoNo',
        'itemId',
        'assemblyCode',
        'assembly',
        'itemMake',
        'addDescription',
        'detailDescription',
        'itemMsnNumber',
        'drawingNo',
        'drawingRev',
        'woQty',
        'woType',
        'salesType',
        'status',
        'woStatus',
        'uom',
        'bomNo',
        'prodEngineer',
        'poDate',
        'woStartDate',
        'woDeliveryDate',
        'dsNo',
        'remark',
        'reGenerateWoItem',
        'LoginData',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
    protected $appends = ['uom_details','bomNumber'];
//    bomNumber

    public function uomDetail()
    {
        return $this->hasOne(UnitMeasurment::class,'_id','uom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uomDetail()->first(['uom']);
    }

    public function partyDetails()
    {
        return $this->hasOne(PartyMaster::class,'partyCode','partyCode');
    }

    public function bomNumber()
    {
        return $this->hasOne(BillOfMaterialVersion::class,'_id','bomNo');
    }

    public function getBomNumberAttribute()
    {
        return $this->bomNumber()->first(['bomNumber']);
    }

    public function salesOrder()
    {
        return $this->hasOne(SalesOrder::class, '_id', 'soId')->with('salesOrderItemDetails');
    }
}
