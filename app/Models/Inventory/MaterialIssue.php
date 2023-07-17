<?php

namespace App\Models\Inventory;

use App\Models\BaseModel;
use Jenssegers\Mongodb\Relations\HasOne;

class MaterialIssue extends BaseModel
{
    protected $table = 'material_issue';

    protected $fillable = [
        'issueSlipNumber',
        'issueSlipDate',
        'issueSlipPerson',
        'receivePerson',
        'addedFrom',
        'companyId',
    ];

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class,'materialIssueId', '_id');
    }
}
