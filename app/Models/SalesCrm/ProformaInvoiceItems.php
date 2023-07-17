<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProformaInvoiceItems extends BaseModel
{
    use HasFactory;

    protected $collection = 'proforma_invoice_items';
    protected $fillable = [
        'pInvoiceId',
        'pInvoiceNo',
        'itemId',
        'itemCode',
        'itemName',
        'itemCustomDescription',
        'itemAddonDescription',
        'itemDetailDescription',
        'itemDrawingNo',
        'itemDrawingRev',
        'itemProject',
        'itemInternalNote',
        'itemSalesType',
        'itemUom',
        'itemCustPartNo',
        'itemNote',
        'itemQuantity',
        'itemRate',
        'itemDiscount',
        'itemDiscountVal',
        'itemNetAmount',
        'itemAmount',
        'itemStatus',
        'itemType',
        'itemSoNo',
        'itemQRevNo',
        'itemDocuments',
        'itemStockStatus',
        'itemHolUnhold',
        'itemImage',
        'itemWorkOrderDetail',
        'itemDispatchDetail',
        'itemDeliverySchedule',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $hidden = ['updated_at'];
}
