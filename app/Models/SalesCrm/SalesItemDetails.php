<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;
use App\Models\Master\UnitMeasurment;
use \Jenssegers\Mongodb\Relations\HasOne;

class SalesItemDetails extends BaseModel
{
    protected $collection = 'sales_item_details';
    protected $fillable = [
        'salesIqID',
        'itemCode',
        'itemDescription',
        'itemDescCust',
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
        'companyId',
        'addedFrom',
    ];
    protected $hidden = ['created_at','updated_at'];

    /**
     * @return HasOne
     */
    public function uomDetails()
    {
        return $this->hasOne(UnitMeasurment::class,'_id','uom');
    }
}
