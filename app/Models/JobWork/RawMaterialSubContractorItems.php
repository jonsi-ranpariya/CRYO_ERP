<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;

class RawMaterialSubContractorItems extends BaseModel
{

    protected $collection = '';
    protected $fillable = [
        'rawId',
        'itemId',
        'showIssueItemId',
        'jobCardId',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrawingNumber',
        'itemDrawingRevision',
        'itemUom',
        'itemQuntity',
        'itemRate',
        'itemAcceptQty',
        'itemRejectQty',
        'itemJobCardNo',
        'itemNote',
        'rejectionItemCode',
        'rejectItemDescription',
    ];
    protected $appends = ['uom_details','item_name'];

    public function uomDetail()
    {
        return $this->hasOne(UnitMeasurment::class,'_id','itemUom');
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
