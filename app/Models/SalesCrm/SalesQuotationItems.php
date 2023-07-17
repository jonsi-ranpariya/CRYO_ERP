<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;

class SalesQuotationItems extends BaseModel
{
    protected $collection = 'sales_quotation_items';

    protected $fillable = [
        'totalAmount',
        'salesIqID',
        'itemCode',
        'itemDescription',
        'addDescription',
        'detailDescription',
        'drawingNumber',
        'rev',
        'uom',
        'requireQty',
        'custPartNo',
        'itemNote',
        'leadNo',
        'status',
        'itemDescCust',
        'addedFrom',
        'companyId',
        'amount',
        'rate',
        'requireQty',
        'netAmount',
        'discValue',
        'discPercent',
        'totalAmount',
        'salesQuotationId',
    ];

    protected $appends = ['total_amount','uom_details'];

    /**
     * @return mixed
     */
    protected function getTotalAmountAttribute()
    {
        return $this->query()->where('salesQuotationId', $this->salesQuotationId)->sum('netAmount');
    }

    public function uomDetails()
    {
        return $this->hasOne(UnitMeasurment::class,'_id','uom');
    }

    protected function getUomDetailsAttribute()
    {
        return $this->uomDetails()->select('_id','uom')->first();
    }

    public function itemDetails()
    {
        return $this->hasOne(ItemMaster::class,'_id', 'itemCode.value');
    }

}
