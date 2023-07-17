<?php


namespace App\Services\purchase;


use App\Models\MRP\MrpIndent;
use App\Models\Purchase\PurchaseEnquiryItemDetail;
use App\Models\SalesCrm\SalesOrderItems;
use App\Services\Mrp\IndentService;
use Illuminate\Http\Request;

class PurchaseEnquiryService
{
    private SalesOrderItems $salesOrderItem;
    private PurchaseEnquiryItemDetail $purchaseEnquiryItemDetail;
    private MrpIndent $mrpIndent;

    /**
     * purchaseEnquiryService constructor.
     * @param SalesOrderItems $salesOrderItems
     * @param PurchaseEnquiryItemDetail $purchaseEnquiryItemDetail
     * @param MrpIndent $mrpIndent
     */
    public function __construct(SalesOrderItems           $salesOrderItems,
                                PurchaseEnquiryItemDetail $purchaseEnquiryItemDetail,
                                MrpIndent                 $mrpIndent)
    {
        $this->salesOrderItem = $salesOrderItems;
        $this->purchaseEnquiryItemDetail = $purchaseEnquiryItemDetail;
        $this->mrpIndent = $mrpIndent;
    }


    /**
     * @param Request $request
     * @return bool|object|null
     */
    public function addMultipleItemsFromSalesOrder(Request $request): bool|null|object
    {
        $type = $request->type;
        $ids = $request->ids;
        $referenceId = $request->referenceId;


        if ($type === '1' && !empty($ids)) {
            $itemsDetails = $this->salesOrderItem->whereInData('_id', $ids);
            foreach ($itemsDetails as $detail) {
                $intendItem = (new IndentService($type, $detail))->execute();
                if ($intendItem == null) {
                    return false;
                }
                $dataInsert['referenceId'] = $referenceId;
                $dataInsert['itemCode'] = $detail->itemId;
                $dataInsert['itemDescription'] = $detail->itemName ?? null;
                $dataInsert['itemAddDescription'] = $detail->itemAddonDescription ?? null;
                $dataInsert['itemMake'] = $detail->itemMake ?? null;
                $dataInsert['itemDetailDescription'] = $detail->itemDetailDescription ?? null;
                $dataInsert['itemDrawingNumber'] = $detail->itemDrawingNo ?? null;
                $dataInsert['itemDrawingRevision'] = $detail->itemDrawingRev ?? null;
                $dataInsert['itemUom'] = $detail->itemUom ?? null;
                $dataInsert['itemConvUom'] = $detail->itemConvUom ?? null;
                $dataInsert['itemFactor'] = $detail->itemCFactor ?? null;
                $dataInsert['itemConvQty'] = $detail->itemConvQty ?? null;
                $dataInsert['itemRequireQuantity'] = $detail->itemQuantity ?? null;
                $dataInsert['itemSoNumber'] = $detail->salesOrderNo ?? null;
                $dataInsert['itemIndentNumber'] = $intendItem->indentNo;
                $dataInsert['itemStatus'] = 1;
                $response = $this->purchaseEnquiryItemDetail->saveData($dataInsert);
            }
            return $response;
        }

        return null;
    }

    /**
     * @param Request $request
     * @return object|null
     */
    public function addMultipleItemsFromIndent(Request $request): ?object
    {
        $type = $request->type;
        $ids = $request->ids;
        $referenceId = $request->referenceId;

        if ($type === '2' && !empty($ids)) {
            $indentDetails = $this->mrpIndent->whereInData('_id', $ids);
            foreach ($indentDetails as $indentDetail) {
                $dataInsert['referenceId'] = $referenceId;
                $dataInsert['itemCode'] = $indentDetail->itemCode;
                $dataInsert['itemDescription'] = $indentDetail->itemDescription ?? null;
                $dataInsert['itemAddDescription'] = $indentDetail->addDescription ?? null;
                $dataInsert['itemMake'] = $indentDetail->itemMake ?? null;
                $dataInsert['itemDetailDescription'] = $indentDetail->detailDescription ?? null;
                $dataInsert['itemDrawingNumber'] = $indentDetail->drawingNumber ?? null;
                $dataInsert['itemDrawingRevision'] = $indentDetail->rev ?? null;
                $dataInsert['itemUom'] = $indentDetail->uom ?? null;
                $dataInsert['itemConvUom'] = $indentDetail->up ?? null;
                $dataInsert['itemFactor'] = $indentDetail->cFactor ?? null;
                $dataInsert['itemConvQty'] = $indentDetail->conveQty ?? null;
                $dataInsert['itemRequireQuantity'] = $indentDetail->qtyNos ?? 0;
                $dataInsert['itemQuantityUp'] = $indentDetail->reqQtyUp ?? $indentDetail->reqQtyConv ?? null;
                $dataInsert['itemSoNumber'] = getSalesOrderNumberFromId(salesOrderId: $indentDetail->soId) ?? null;
                $dataInsert['itemIndentNumber'] = $indentDetail->indentNo ?? null;
                $dataInsert['itemStatus'] = 1;
                $dataInsert['itemHsnNumber'] = $indentDetail->itemHsnNumber ?? null;
                $dataInsert['itemMsnNumber'] = $indentDetail->itemMsnNumber ?? null;
                $dataInsert['itemStore'] = $indentDetail->store ?? null;
                $response = $this->purchaseEnquiryItemDetail->saveData($dataInsert);
            }
            return $response;
        }

        return null;
    }
}
