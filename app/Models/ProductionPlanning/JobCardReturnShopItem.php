<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;

class JobCardReturnShopItem extends BaseModel
{
    protected $collection = 'job_card_return_shop_item';

    protected $fillable = [
        'returnId',
        'itemCode',
        'itemDescription',
        'addDescription',
        'detailDescription',
        'drawingNumber',
        'drawingRevision',
        'quantity',
        'acceptQuantity',
        'rejectQuantity',
        'rate',
        'uom',
        'note',
        'returnItemCode',
        'returnItemDescription',
        'returnItemRate',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];

    protected $appends = ['item_name','uom_details'];

    public function uomDetail()
    {
        return $this->hasOne(UnitMeasurment::class,'_id','uom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uomDetail()->first(['uom']);
    }

    public function itemDetail()
    {
        return $this->hasOne(ItemMaster::class,'_id','itemCode');
    }

    public function getItemNameAttribute()
    {
        return $this->itemDetail()->first(['itemCode','itemDescription']);
    }
}
