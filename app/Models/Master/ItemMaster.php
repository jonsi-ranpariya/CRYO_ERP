<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use App\Models\Item\ItemHsnSacMaster;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ItemMaster extends BaseModel
{
    protected $collection = 'item_masters';
    protected $fillable = [
        'make',
        'batchWiseStock',
        'cFactor',
        'considerInAccount',
        'convQty',
        'convUom',
        'date',
        'itemCategory',
        'itemCode',
        'itemDescription',
        'itemGroup',
        'itemType',
        'materialProcessType',
        'planning',
        'reason',
        'serialNoWiseStock',
        'status',
        'stockAllocationAtWo',
        'uom',
        'itemDetails',
        'purchaseData',
        'generalData',
        'hsnSacDetails',
        'peso_approve',
        'peso_reason',
        'companyId',
        'addedFrom',
        'updatedFrom',
        'created_at',
        'updated_at',
    ];


    public function createdBy()
    {
        return $this->hasOne(User::class, '_id', 'addedFrom');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, '_id', 'updatedFrom');
    }

    public function uomDetails()
    {
        return $this->hasOne(UnitMeasurment::class, '_id', 'convUom');
    }

    public function uomItem()
    {
        return $this->hasOne(UnitMeasurment::class, '_id', 'uom');
    }

    public function hsnDetails()
    {
        return $this->hasOne(ItemHsnSacMaster::class, '_id', 'hsnSacDetails.hsnSacDescription.value');
    }
}
