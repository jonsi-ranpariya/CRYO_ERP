<?php

namespace App\Models\Bom;

use App\Models\BaseModel;

class BillOfMaterialVersion extends BaseModel
{
    protected $collection = 'bill_of_material_version';

    protected $fillable = [
        'bomId',
        'bomDescription',
        'bomNumber',
        'bomUnit',
        'bomValidFrom',
        'bomDrawingRevision',
        'bomDrawingNumber',
        'bomActive',
        'bomDefault',
        'bomNote',
        'bomVersion',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    public function versionItems()
    {
        return $this->hasMany(BomVersionItem::class,'versionId','_id');
    }

    public function bomDetails()
    {
        return $this->hasOne(BillOfMaterial::class,'_id' ,'bomId');
    }
    public function bomDetail()
    {
        return $this->hasOne(BillOfMaterialModel::class,'_id' ,'bomId');
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
