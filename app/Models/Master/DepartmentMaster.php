<?php

namespace App\Models\Master;

use App\Models\BaseModel;


class DepartmentMaster extends BaseModel
{
    protected $collection = 'department_masters';
    protected $fillable = [
        'department',
        'addedFrom',
        'companyId'
    ];
    protected $hidden = ['updated_at'];

    public function designations()
    {
        return $this->hasMany(DesignationMaster::class, 'department', '_id');
    }
}
