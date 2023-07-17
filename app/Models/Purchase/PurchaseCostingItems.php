<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;
use App\Models\JobWork\JobWorkOrderItems;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;

class PurchaseCostingItems extends BaseModel
{
    protected $collection = 'purchase_costing_item';

   protected $fillable = [
       'purchaseCostingId',
       'itemCode',
       'itemDescription',
       'itemAddDescription',
       'itemDetailDescription',
       'itemDrawingNo',
       'itemRevision',
       'itemUom',
       'itemRate',
   ];

    protected $appends = ['item_details','uom_details'];

        public  function itemDetail()
        {
            return $this->hasOne(ItemMaster::class,'_id','itemCode');
        }

        public function getItemDetailsAttribute()
        {
            return $this->itemDetail()->first(['itemCode','itemDescription']);
        }


        public function uomDetail()
        {
            return $this->hasOne(UnitMeasurment::class,'_id','itemUom');
        }

        public function getUomDetailsAttribute()
        {
            return $this->uomDetail()->first(['uom']);
        }
}
