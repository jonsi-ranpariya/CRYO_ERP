<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemMake extends BaseModel
{
    use HasFactory;
    protected $collection = 'item_make_masters';
    protected $fillable = [
        'make',
        'companyId',
        'addedFrom',
        'makeName',
    ];
    protected $hidden = ['updated_at'];
}
