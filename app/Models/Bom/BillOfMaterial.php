<?php

namespace App\Models\Bom;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\User;

class BillOfMaterial extends BaseModel
{
    protected $collection = 'bill_of_material';

    protected $fillable = [
        'itemCode',
        'itemDescription',
        'addDescription',
        'drawingNumber',
        'drawingRevision',
        'detailDescription',
        'uom',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $appends = ['item_name','bom_version','created_detail','updated_detail','bom_details'];

    public function itemDetails()
    {
        return $this->hasOne(ItemMaster::class,'_id','itemCode');
    }

    public function getItemNameAttribute()
    {
        return $this->itemDetails()->first(['itemCode']);
    }

    public function bomVersion()
    {
        return $this->hasMany(BillOfMaterialVersion::class,'bomId','_id');
    }

    public function getBomVersionAttribute()
    {
        return $this->bomVersion()->get();
    }

    public function bomDetails()
    {
        return $this->hasOne(BillOfMaterialVersion::class,'bomId','_id');
    }

    public function getBomDetailsAttribute()
    {
        return $this->bomDetails()->first(['bomNumber','bomDescription']);
    }

    public function createdDetails()
    {
        return $this->hasOne(User::class,'_id','addedFrom');
    }

    public function getCreatedDetailAttribute()
    {
        return $this->createdDetails()->first(['first_name','last_name']);
    }

    public function updatedDetails()
    {
        return $this->hasOne(User::class,'_id','updatedFrom');
    }

    public function getUpdatedDetailAttribute()
    {
        return $this->updatedDetails()->first(['first_name','last_name']);
    }

    public function scopeActiveOnly($query)
    {
        return $query->where('bomActive', '1');
    }

    public function scopeDefaultOnly($query)
    {
        return $query->where('bomDefault', '1');
    }
}
