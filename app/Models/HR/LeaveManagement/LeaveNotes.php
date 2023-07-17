<?php

namespace App\Models\HR\LeaveManagement;

use App\Models\BaseModel;

class LeaveNotes extends BaseModel
{
    protected $collection = 'leave_notes';
    protected $fillable = [
        'select_module',
        'content',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
