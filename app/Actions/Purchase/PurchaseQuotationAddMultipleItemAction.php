<?php

namespace App\Actions\Purchase;

use App\Models\Purchase\PurchaseEnquiryItemDetail;
use App\Models\Purchase\PurchaseQuotationItems;
use Lorisleiva\Actions\Concerns\AsAction;

class PurchaseQuotationAddMultipleItemAction
{
    use AsAction;

    public function handle($purchaseQuotationId, $itemIds): void
    {
        $items = PurchaseEnquiryItemDetail::whereInData('_id', $itemIds);
        $items->each(function (PurchaseEnquiryItemDetail $item) use ($purchaseQuotationId) {
            $itemMaster = $item->itemDetail()->first();
            $hsnMaster = $itemMaster->hsnDetails()->first();
            $itemData = [
                'purchaseQuotationId' => $purchaseQuotationId,
                'itemCode' => $item->itemCode,
                'itemDescription' => $item->itemDescription,
                'itemMake' => $itemMaster->make ?? null,
                'itemHsnNumber' => $hsnMaster->codeNo ?? null,
                'itemAddDescription' => $item->itemAddDescription,
                'itemDetailDescription' => $item->itemDetailDescription,
                'itemDrawingNumber' => $item->itemDrawingNumber,
                'itemDrawingRevision' => $item->itemDrawingRevision,
                'itemUom' => $item->itemUom,
                'itemFactor' => $itemMaster->cFactor,
                'itemConvQty' => $itemMaster->convQty,
                'itemNote' => null,
                'itemStatus' => (int)$item->itemStatus,
                'itemQuantity' => $item->itemRequireQuantity,
                'itemRate' => 0,
                'itemDiscPercent' => 0,
                'itemDiscValue' => 0,
                'itemAmount' => 0,
                'itemNetAmount' => 0,
                'totalAmount' => 0,
                'itemCgstPercent' => $hsnMaster->codeCGSTPercentage ?? 0,
                'itemSgstPercent' => $hsnMaster->codeSGSTPercentage ?? 0,
                'itemIgstUgstPercent' => $hsnMaster->codeIGSTPercentage ?? 0,
                'itemCgstAmount' => 0,
                'itemSgstAmount' => 0,
                'itemIgstUgstAmount' => 0
            ];

            PurchaseQuotationItems::saveData($itemData);
            $item->itemStatus = 3;
            $item->save();
        });
    }
}
