<?php

namespace App\Models\Upload;

use App\Listeners\Import\ItemMasterImportListener;
use App\Models\BaseModel;

class FileUpload extends BaseModel
{
    protected $collection = 'file_upload';

    protected $fillable = [
        'name',
        'path',
        'addedFrom',
        'companyId',
    ];

    public function itemable()
    {
        return $this->morphTo();
    }
}
