<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderShowAmdDetail extends BaseModel
{
    protected $collection = 'purchase-order-show-amd-detail';
    protected $fillable = [
        'purchaseOrderId',
        'ammendmentDescription',
        'createdBy'
      ];
}
