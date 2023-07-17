<?php

namespace App\Models\Bom;


use App\Models\BaseModel;
use App\Models\Master\ItemMaster;

class BillOfMaterialModel extends BaseModel
{
    protected $collection = 'bill_of_material';

    public function itemDetails()
    {
        return $this->hasOne(ItemMaster::class, '_id', 'itemCode');
    }

    public function bomDetails()
    {
        return $this->hasOne(BillOfMaterialVersion::class,'bomId','_id');
    }
}
