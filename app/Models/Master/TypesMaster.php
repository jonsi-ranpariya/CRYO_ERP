<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class TypesMaster extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'types_masters';
    protected $fillable = [
        'business_type',



    ];
    protected $hidden = ['updated_at'];
}
