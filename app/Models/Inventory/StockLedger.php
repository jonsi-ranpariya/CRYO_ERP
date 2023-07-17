<?php

namespace App\Models\Inventory;

use App\Models\BaseModel;
use Jenssegers\Mongodb\Relations\HasMany;

class StockLedger extends BaseModel
{
    protected $collection = 'stock_ledger';

    protected $fillable = [
        'stock_ledger_doc_number',
        'transaction_id',
        'transaction_type',
        'document_number',
        'document_date',
        'wo_po_number',
        'rate',
        'qty',
        'amount',
        'balance_qty',
        'item_id',
        'lot_number',
        "addedFrom",
        "updatedFrom",
        "companyId",
    ];

    protected $casts = [
        'rate' => 'float',
        'qty' => 'float',
        'amount' => 'float',
        'balance_qty' => 'float',
    ];

    public function assignLot(): HasMany
    {
        return $this->hasMany(LotOfStockLedger::class,'itemId','item_id');
    }
}
