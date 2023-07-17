<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;
use App\Models\Inventory\Transaction;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;
use Jenssegers\Mongodb\Relations\MorphMany;

class ShowIssueItems extends BaseModel
{

    protected $collection = 'show_issue_items_process';
    protected $fillable = [
        'jobId',
        'itemId',
        'issueItemCode',
        'issueItemDescription',
        'issueItemAddDescription',
        'issueItemDetailDescription',
        'issueItemDrawingNo',
        'issueItemRevision',
        'issueRequiredQty',
        'issueRequiredQtyConv',
        'issueItemQty',
        'issueItemPendingQty',
        'issueItemUom',
        'issueItemConvUom',
        'issueItemConvFactor',
        'issueItemConvQty',
        'issueCurrentStock',
        'issueStockSubContractor',
        'issueItemremark',
    ];
    protected $appends = ['item_name', 'jobCard_number', 'uom_detail', 'conv_uom_detail'];

    public function uomData()
    {
        return $this->hasOne(UnitMeasurment::class, '_id', 'issueItemUom');
    }

    public function getUomDetailAttribute()
    {
        return $this->uomData()->first(['_id', 'uom']);
    }

    public function convUomData()
    {
        return $this->hasOne(UnitMeasurment::class, '_id', 'issueItemConvUom');
    }

    public function getConvUomDetailAttribute()
    {
        return $this->convUomData()->first(['_id', 'uom']);
    }

    public function itemDetails()
    {
        return $this->hasOne(ItemMaster::class, '_id', 'issueItemCode');
    }

    public function getItemNameAttribute()
    {
        return $this->itemDetails()->first(['itemCode']);
    }

    public function jobCards()
    {
        return $this->hasOne(JobCards::class, '_id', 'jobId');
    }

    public function getJobCardNumberAttribute()
    {
        return $this->jobCards()->first(['jobCardNumber','jobCardDate', 'jobQty', 'pendingJobQty']);
    }

    public function transaction(): MorphMany
    {
        return $this->morphMany(related: Transaction::class, name: 'transactionable', localKey: '_id')->with('stockLedger');
    }
}
