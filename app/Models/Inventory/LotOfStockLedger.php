<?php

namespace App\Models\Inventory;

use App\Models\BaseModel;
use Jenssegers\Mongodb\Relations\HasOne;
use Jenssegers\Mongodb\Relations\MorphMany;

class LotOfStockLedger extends BaseModel
{
    protected $collection = 'lot_of_stock_ledger';

    protected $fillable = [
        'lotNumber',
        'quantity',
        'itemName',
        'itemId',
        'documentName',
        'documentNumber',
        'documentDate'
    ];

    public function stockLedger(): HasOne
    {
        return $this->hasOne(StockLedger::class,'lotNumber','lotNumber');
    }

    /*public function stockLedger(): MorphMany
    {
        return $this->morphMany(related: StockLedger::class, name: 'stockLedgerAble', localKey: '_id');
    }*/
}
