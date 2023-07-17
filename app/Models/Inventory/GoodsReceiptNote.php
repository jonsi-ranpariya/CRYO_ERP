<?php

namespace App\Models\Inventory;


use App\Models\BaseModel;
use App\Models\Inventory\GoodsReceiptNoteItem;
use App\Models\Purchase\PurchaseOrder;
use App\Models\Purchase\PurchaseOrderItem;
use Jenssegers\Mongodb\Relations\HasMany;


class GoodsReceiptNote extends BaseModel
{
//        protected $connection = 'mongodb';
    protected $collection = 'goods_receipt_note';
    protected $fillable = [
        'purchaseOrderId',
        'partyId',
        'partyCode',
        'partyName',
        'remarkDetails',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
    protected $appends = ['party_details','grn_Details'];

    public function purchaseOrderDetail()
    {
        return $this->hasOne(PurchaseOrder::class,'_id','partyCode');
    }

    public function getPartyDetailsAttribute()
    {
        return $this->purchaseOrderDetail()->first(['vendorDetails.vendorCode']);
    }

    public function grnDetails()
    {
        return $this->hasMany(GoodsReceiptNoteItem::class,'goodNoteId','_id');
    }

    public function getGRnDetailsAttribute()
    {
        return $this->grnDetails()->first(['grnNo','grnDate','poNo']);
    }

    public function itemDetails(): HasMany
    {
        return $this->hasMany(GoodsReceiptNoteItem::class, 'goodNoteId', '_id');
    }

    public function scopeWithoutInwardItem($query, $ids)
    {
        return $query->with(['itemDetails' => function ($query) use ($ids) {
            $query->whereNotIn('_id', $ids);
        }]);
    }

}
