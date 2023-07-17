<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class DesignationMaster extends BaseModel
{
    protected $collection = 'designation_masters';
    protected $fillable = [
        'department',
        'designation',
        'companyId',
        'addedFrom'
    ];

    public function departmentDetail()
    {
        return $this->belongsTo(DepartmentMaster::class,'department','_id', 'designations');
    }
}
