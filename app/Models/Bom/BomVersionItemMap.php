<?php

namespace App\Models\Bom;

use App\Models\BaseModel;

class BomVersionItemMap extends BaseModel
{
    protected $collection = 'bom_version_item_map';

    protected $fillable = [
        'versionItemId',
        'versionItemCurrentId',
        'level',
    ];

    public function versionItemDetails()
    {
        return $this->belongsTo(BomVersionItem::class,'_id', 'versionItemId');
    }
}
