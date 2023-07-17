<?php

namespace App\Models\Bom;

use App\Models\BaseModel;

class DrawingRevision extends BaseModel
{
    protected $collection = 'drawing_master_revision';
    protected $fillable = [
        'drawingId',
        'drawingRev',
        'drawingRevDate',
        'drawingRevNote',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $hidden = ['updated_at'];
}
