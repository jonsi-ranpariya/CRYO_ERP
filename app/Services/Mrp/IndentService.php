<?php

namespace App\Services\Mrp;

use App\Models\Master\ItemMaster;
use App\Models\MRP\MrpIndent;
use Carbon\Carbon;

class IndentService
{
    /**
     * Type: 1 = IndentItem | Purchase Enquiry Sales Order Item
     * Type: 2 = SalesOrderItem
     * Type: 3 = purchaseQuotationItem
     *
     * @param string|int $type
     * @param object $item
     */
    public function __construct(protected string|int $type, protected object $item)
    {
    }

    /**
     * Type: 1 = IndentItem | Purchase Enquiry Sales Order Item
     * Type: 2 = SalesOrderItem
     * Type: 3 = purchaseQuotationItem
     *
     * @return object|null
     */
    public function execute(): object|null
    {
        return match ($this->type) {
            '2', '1' => $this->fromSalesOrder(),
            '3' => $this->fromPurchaseQuotation(),
            default => null,
        };
    }

    private function fromSalesOrder(): object
    {
        $item = MrpIndent::query()->where(['itemId' => $this->item->itemId])->latest()->first();
        $itemMaster = ItemMaster::query()->find($this->item->itemId);

        if (!empty($item)) {
            return $item;
        } else {
            $dataInsert = [
                'itemId' => $this->item->itemId,
                'itemCode' => $this->item->itemCode,
                'itemDescription' => $this->item->itemName,
                'addDescription' => $this->item->itemAddonDescription ?? null,
                'detailDescription' => $this->item->itemDetailDescription ?? null,
                'drawingNumber' => $this->item->itemDrawingNo ?? null,
                'rev' => $this->item->itemDrawingRev ?? null,
                'uom' => $this->item->itemUom ?? null,
                'up' => $this->item->itemConvUom ?? null,
                'cFactor' => $this->item->itemCFactor ?? $itemMaster->cFactor ?? null,
                'reqQtyUm' => null,
                'reqQtyUp' => null,
                'conveQty' => $itemMaster->convQty ?? null,
                'size' => null,
                'qtyNos' => $this->item->itemQuantity ?? 0,
                'planningType' => 7,
                'itemMake' => $itemMaster->make[0] ?? $itemMaster->make ?? null,
                'store' => null,
                'leadTime' => $itemMaster->purchaseData['leadTime'] ?? 1,
                'deliveryDate' => now()->addDays($itemMaster->purchaseData['leadTime'] ?? 1)->format('d/m/Y'),
                'indentDate' => now()->format('d/m/Y'),
                'indentNo' => generateCodes(new MrpIndent(), 'I00001', 'indentNo', 'I'),
                'minOrderQty' => $itemMaster->purchaseData['minimumOrderQuantity'] ?? null,
                'maxOrderQty' => $itemMaster->purchaseData['maximumOrderQuantity'] ?? null,
                'soId' => $this->item->salesOrderNo,
                'woId' => null,
                'forecastNo' => null,
                'remark' => $this->item->itemNote ?? null,
                'loginDetails' => [
                    'createdBy' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                    'dateTime' => now()->format('d/m/Y H:i'),
                    'lastModifiedBy' => null,
                    'modifiedDateTime' => null,
                    'approvedBy' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                    'approveDate' => now()->format('d/m/Y H:i'),
                    'stage' => 2,
                ],
            ];

            return MrpIndent::saveData($dataInsert);
        }
    }

    private function fromPurchaseQuotation(): object
    {
        $item = MrpIndent::query()->where(['itemId' => $this->item->itemCode])->latest()->first();
        $itemMaster = ItemMaster::query()->find($this->item->itemCode);

        if (!empty($item)) {
            return $item;
        } else {
            $dataInsert = [
                'itemId' => $this->item->itemCode,
                'itemCode' => $this->item->itemCode,
                'itemDescription' => $this->item->itemDescription,
                'addDescription' => $this->item->itemAddDescription ?? null,
                'detailDescription' => $this->item->itemDetailDescription ?? null,
                'drawingNumber' => $this->item->itemDrawingNumber ?? null,
                'rev' => $this->item->itemDrawingRevision ?? null,
                'uom' => $this->item->itemUom ?? null,
                'up' => $this->item->itemUom ?? null,
                'cFactor' => $itemMaster->cFactor ?? null,
                'reqQtyUm' => null,
                'reqQtyUp' => null,
                'conveQty' => $itemMaster->convQty ?? null,
                'size' => null,
                'qtyNos' => $this->item->itemQuantity ?? 0,
                'planningType' => 7,
                'itemMake' => $itemMaster->make[0] ?? $itemMaster->make ?? null,
                'store' => null,
                'leadTime' => $itemMaster->purchaseData['leadTime'] ?? 1,
                'deliveryDate' => now()->addDays($itemMaster->purchaseData['leadTime'] ?? 1)->format('d/m/Y'),
                'indentDate' => now()->format('d/m/Y'),
                'indentNo' => generateCodes(new MrpIndent(), 'I00001', 'indentNo', 'I'),
                'minOrderQty' => $itemMaster->purchaseData['minimumOrderQuantity'] ?? null,
                'maxOrderQty' => $itemMaster->purchaseData['maximumOrderQuantity'] ?? null,
                'soId' => null,
                'woId' => null,
                'forecastNo' => null,
                'remark' => $this->item->itemNote ?? null,
                'loginDetails' => [
                    'createdBy' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                    'dateTime' => now()->format('d/m/Y H:i'),
                    'lastModifiedBy' => null,
                    'modifiedDateTime' => null,
                    'approvedBy' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                    'approveDate' => now()->format('d/m/Y H:i'),
                    'stage' => 2,
                ],
            ];

            return MrpIndent::saveData($dataInsert);
        }
    }
}
