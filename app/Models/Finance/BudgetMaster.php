<?php

namespace App\Models\Finance;

use App\Models\BaseModel;

class BudgetMaster extends BaseModel
{
    protected $collection = 'budget_master';
    protected $fillable = [
        'groupType',
        'accountGroup',
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
        'monthlyBudget',
        'yearlyBudget',
        'addedFrom',
        'companyId',
        'companyId',
        'year'
    ];
    protected $hidden = ['updated_at'];
}
