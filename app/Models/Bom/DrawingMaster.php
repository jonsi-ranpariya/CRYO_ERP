<?php

namespace App\Models\Bom;

use App\Models\BaseModel;

class DrawingMaster extends BaseModel
{
    protected $collection = 'drawing_master';
    protected $fillable = [
        'drawingNo',
        'drawingTitle',
        'drawingSize',
        'drawingScale',
        'drawingLocation',
        'partyID',
        'partyCode',
        'partyName',
        'itemId',
        'itemCode',
        'itemName',
        'salesOrderId',
        'salesOrderNo',
        'preparedBy',
        'preparedDate',
        'isChecked',
        'checkedBy',
        'checkedDate',
        'isApproved',
        'approvedBy',
        'approvedDate',
        'remarkNote',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $hidden = ['updated_at'];

    protected $appends = ['rev_detail'];

    public function drawingRevision()
    {
        return $this->hasMany(DrawingRevision::class,'drawingId', '_id');
    }

    public function getRevDetailAttribute()
    {
        return self::drawingRevision()->latest()->first(['drawingRev']);
    }
}
