<?php

namespace App\Http\Controllers\QualityControl;

use App\Enums\Inventory\TransactionTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\QualityControl\InwardQualityControlItem;
use App\Services\Inventory\StockLedgerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InwardQualityControlItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = InwardQualityControlItem::all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param StockLedgerService $service
     * @return JsonResponse
     */
    public function store(Request $request, StockLedgerService $service): JsonResponse
    {
        $dataInsert = $request->all();
        $items = InwardQualityControlItem::query()->where('inwardQcId', $dataInsert['inwardQcId'])->count();
        if ($items == 1) {
            return jsonData([
                'message' => 'One Item already exists.'
            ], Response::HTTP_NOT_ACCEPTABLE);
        }

        $inwardQcItem = InwardQualityControlItem::saveData($dataInsert);
        if (!is_null($inwardQcItem)) {
            $inwardQc = $inwardQcItem->inwardQuality()->first();
            $service->createTransactionWithStockLedger(transactionData: [
                "cFactor" => $inwardQcItem->itemFactor ,
                "conversionQty" => $inwardQcItem->challanQtyUm,
                "conversionUom" => $inwardQcItem->purchaseUom,
                "currentStock" => 0,
                "documentDate" => $inwardQcItem->grnDate,
                "documentNo" => $inwardQcItem->grnNo,
                "issueByPerson" => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                "itemAddDescription" => $inwardQcItem->itemAddDescription,
                "itemCode" => $inwardQcItem->itemCode,
                "itemDescription" => $inwardQcItem->itemDescription,
                "itemDetailDescription" => $inwardQcItem->itemDetailDescription,
                "itemDrawingNo" => $inwardQcItem->itemDrowingNo,
                "itemId" => $inwardQcItem->itemId,
                "itemMake" => $inwardQcItem->itemMake,
                "itemRev" => $inwardQcItem->itemRev,
                "itemUom" => $inwardQcItem->itemUom,
                "leadTime" => $inwardQcItem->itemMaster()->first()?->purchaseData['leadTime'] ?? 0,
                "minimumStock" => $inwardQcItem->itemMaster()->first()?->purchaseData['minimumStockQuantity'] ?? 0,
                "openingStock" => null,
                "party" => $inwardQc->partyName ?? null,
                "rate" => (float)$inwardQcItem->rate,
                "receivedByPerson" => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                "reference" => null,
                "rejectedQty" => (float)$inwardQcItem->rejectedQuantityUp ?? 0,
                "remark" => $inwardQcItem->remark ?? null,
                "transaction" => 2,
                "transactionQty" => (float)$inwardQcItem->poQuantityUp ?? 0,
                "transactionType" => TransactionTypeEnum::Receipt,
                "value" => (float)$inwardQcItem->poQuantityUp * (float)$inwardQcItem->rate,
                "woPoNo" => $inwardQcItem->poNo ?? null
            ]);
        }

        $data['message'] = 'Data saved';
        $data['data'] = $inwardQcItem;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     * @param string $id
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $response = InwardQualityControlItem::getDataFromId($id);
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param InwardQualityControlItem $inwardQualityControlItem
     * @return JsonResponse
     */
    public function update(Request $request, InwardQualityControlItem $inwardQualityControlItem): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $inwardQualityControlItem->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $response = InwardQualityControlItem::find($id);
        $response->transactions()->delete();
        $response->delete();

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getInwardQualityControlItem($id): JsonResponse
    {
        $response = InwardQualityControlItem::getData(['inwardQcId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

}
