<?php

namespace App\Models\Bom;

use App\Models\BaseModel;
use App\Models\User;

class DrawingDocuments extends BaseModel
{
    protected $collection = 'drawing_master_documents';

    protected $fillable = [
        'drawingId',
        'documentName',
        'documentItem',
        'addedFrom',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['upload_by'];

    public function userDetail()
    {
        return $this->hasOne(User::class,'_id','addedFrom');
    }

    public function getUploadByAttribute()
    {
        return $this->userDetail()->first(['first_name','last_name']);
    }
}
