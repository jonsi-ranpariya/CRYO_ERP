<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class NoteMaster extends BaseModel
{
    protected $collection = 'note_master';
    protected $fillable = [
        'noteName',
        'note',
        'companyId',
        'addedFrom'

    ];
    protected $hidden = ['updated_at'];
}
