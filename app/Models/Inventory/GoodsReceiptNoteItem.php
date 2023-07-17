<?php

namespace App\Models\Inventory;

use App\Models\Master\ItemMaster;
use App\Models\Inventory\GoodsReceiptNote;
use App\Models\BaseModel;
use Jenssegers\Mongodb\Relations\HasOne;

class GoodsReceiptNoteItem extends BaseModel
{
    //protected $primaryKey = '_id';
    protected $collection = 'goods_receipt_note_item';
    protected $fillable = [
        'goodNoteId',
        'poItemId',
        'itemId',
        'purchaseOrderId',
        'poNo',
        'poDate',
        'itemCode',
        'itemDescription',
        'itemDescVendor',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrowingNo',
        'itemRev',
        'itemUom',
        'purchaseUom',
        'itemFactor',
        'challanNo',
        'challanDate',
        'girNo',
        'girDate',
        'lrNo',
        'lrDate',
        'itemMake',
        'itemStore',
        'location',
        'deliveryDate',
        'itemIndentNo',
        'indentDate',
        'poQuantityUm',
        'pendingQuantityUm',
        'poQuantityUp',
        'pendingQuantityUp',
        'rate',
        'inspQuantity',
        'grnNo',
        'grnDate',
        'challanQuantityUp',
        'challanQuantityUm',
        'actualQuantityUp',
        'actualQuantityUm',
        'grnConversion',
    ];
    protected $appends = ['party_detail'];

    public function itemDetails(): hasOne
    {
        return $this->hasOne(ItemMaster::class,'_id','itemId');
    }

    public function partyDetail(): hasOne
    {
        return $this->hasone(GoodsReceiptNote::class,'_id', 'goodNoteId');
    }

    public function getPartyDetailAttribute()
    {
        return $this->partyDetail()->first(['partyName','partyId','partyCode']);
    }
}
