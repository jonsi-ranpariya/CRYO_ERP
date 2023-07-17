<?php

namespace App\Actions\Dispatch;

use App\Models\Master\ItemMaster;
use App\Models\Despatch\NewChallanInvoice;
use App\Models\Despatch\NewChallanInvoiceItems;
use App\Models\SalesCrm\SalesOrderItems;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class AddMultipleSalesOrderItemAction
{
    use AsAction;

    public function __construct(protected SalesOrderItems        $salesOrderItems,
                                protected NewChallanInvoiceItems $newChallanInvoiceItems,
                                protected ItemMaster             $itemMaster,
                                protected NewChallanInvoice      $newChallanInvoice)
    {
    }

    public function handle(Request $request): void
    {
        $salesItems = $this->salesOrderItems->withWhereInData('_id', $request->ids, ['salesOrder:_id,salesOrderNo']);
        $roundingType = $this->newChallanInvoice->query()->find($request->challanInvoiceId, ['roundingType'])->roundingType;

        foreach ($salesItems as $salesItem) {
            $itemMaster = $this->itemMaster->getDataFromId($salesItem->itemId);
            $itemData['challanInvoiceId'] = $request->challanInvoiceId;
            $itemData['salesOrderNo'] = $salesItem->salesOrderNo;
            $itemData['salesOrderId'] = $salesItem->salesOrderId;
            $itemData['salesOrderItemId'] = $salesItem->_id;
            $itemData['itemCode'] = $salesItem->itemCode;
            $itemData['itemDescription'] = $salesItem->itemName;
            $itemData['itemCustomDescription'] = $salesItem->itemCustomDescription;
            $itemData['itemAddDescription'] = $salesItem->itemAddonDescription;
            $itemData['itemDetailDescription'] = $salesItem->itemDetailDescription;
            $itemData['itemMsnNumber'] = $salesItem->itemMsnNumber ?? null;
            $itemData['itemDrawingNo'] = $salesItem->itemDrawingNo;
            $itemData['itemRevision'] = $salesItem->itemDrawingRev;
            $itemData['itemUom'] = $salesItem->itemUom;
            $itemData['itemCustPartNo'] = $salesItem->itemCustPartNo;
            $itemData['itemStore'] = null;
            $itemData['itemErAndComm'] = 'No';
            $itemData['itemPartialDespatch'] = 'No';
            $itemData['itemNoPackage'] = null;
            $itemData['itemMarkAndNos'] = null;
            $itemData['itemPackageDescription'] = null;
            $itemData['itemAvgPkg'] = null;
            $itemData['itemQuantity'] = $salesItem->itemPendingQuantity ?? $salesItem->itemQuantity;
            $itemData['itemRate'] = $salesItem->itemRate;
            $itemData['itemDiscount'] = $salesItem->itemDiscount;
            $itemData['itemDiscountValue'] = $roundingType == '2' ? round($salesItem->itemDiscountVal) : $salesItem->itemDiscountVal;
            $itemData['itemAmount'] = $roundingType == '2' ? round($salesItem->itemAmount) : $salesItem->itemAmount;
            $itemData['itemNetAmount'] = $roundingType == '2' ? round($salesItem->itemNetAmount) : $salesItem->itemNetAmount;
            $itemData['itemWtInKg'] = null;
            $itemData['itemRemark'] = $salesItem->itemNote;
            $itemData['warrantyRequired'] = 'No';
            $itemData['soNumber'] = $salesItem->salesOrder->salesOrderNo;
            $itemData['itemHsnSacNo'] = $itemMaster->hsnSacDetails['hsnSacNo'] ?? null;
            $itemData['serialNoCode'] = $itemMaster->itemDetails['serialNoCode'] ?? null;

            $itemData['itemMake'] = $salesItem->itemMake ?? null;
            $itemData['itemHsnSacId'] = null;

            $itemData['cgstPercentage'] = $salesItem->itemCgstPercentage ?? 0;
            $itemData['sgstPercentage'] = $salesItem->itemSgstPercentage ?? 0;
            $itemData['igstPercentage'] = $salesItem->itemIgstPercentage ?? 0;
            $itemData['cgstAmount'] = $salesItem->itemCgstAmount ?? 0;
            $itemData['sgstAmount'] = $salesItem->itemSgstAmount ?? 0;
            $itemData['igstAmount'] = $salesItem->itemIgstAmount ?? 0;
            $itemData['itemConvUom'] = $salesItem->itemConvUom ?? null;
            $itemData['itemCFactor'] = $salesItem->itemCFactor ?? null;
            $itemData['itemConvQty'] = $salesItem->itemConvQty ?? null;
            $this->newChallanInvoiceItems->saveData($itemData);
        }
    }
}
