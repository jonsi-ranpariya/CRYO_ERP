<?php

namespace App\Models\Inventory;

use App\Enums\Inventory\TransactionTypeEnum;
use App\Models\BaseModel;
use App\Models\Master\ItemMaster;

class Transaction extends BaseModel
{
    protected $collection = 'transaction';
    protected $fillable = [
        'itemId',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrawingNo',
        'itemRev',
        'itemMake',
        'transaction',
        'documentNo',
        'documentDate',
        'transactionQty',
        'rejectedQty',
        'rate',
        'value',
        'woPoNo',
        'openingStock',
        'currentStock',
        'minimumStock',
        'leadTime',
        'reference',
        'party',
        'transactionType',
        'itemUom',
        'conversionUom',
        'cFactor',
        'conversionQty',
        'issueByPerson',
        'receivedByPerson',
        'remark',
        'materialIssueId',
        'lotNumber',
    ];

    protected $casts = [
        'transactionQty' => 'float',
        'rejectedQty' => 'float',
        'rate' => 'float',
        'value' => 'float',
        'openingStock' => 'float',
        'currentStock' => 'float',
        'minimumStock' => 'float',
        'leadTime' => 'integer',
        'cFactor' => 'float',
        'conversionQty' => 'float',
    ];

    public function transactionable()
    {
        return $this->morphTo(ownerKey: '_id');
    }

    public function stockLedger()
    {
        return $this->hasOne(StockLedger::class,'transaction_id','_id')->with('assignLot');
    }

    public function materialIssue()
    {
        return $this->hasOne(MaterialIssue::class,'_id','materialIssueId');
    }

    public function scopeOnlyOpeningStockItem($query)
    {
        return $query->where('transactionType', TransactionTypeEnum::Opening_Stock);
    }
    public function scopeOnlyIssueItem($query)
    {
        return $query->where('transactionType', TransactionTypeEnum::Issue);
    }
    public function scopeOnlyReceiptItem($query)
    {
        return $query->where('transactionType', TransactionTypeEnum::Receipt);
    }

    public function itemMaster()
    {
        return $this->hasOne(ItemMaster::class,'_id', 'itemId');
    }
}
