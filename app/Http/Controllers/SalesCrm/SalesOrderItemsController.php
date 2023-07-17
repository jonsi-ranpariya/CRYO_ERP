<?php

namespace App\Http\Controllers\SalesCrm;

use App\Actions\Sales\salesOrderAddRemoveAction;
use App\Actions\Sales\salesOrderListFilterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalesCrm\SalesOrderItemUpdateRequest;
use App\Models\SalesCrm\SalesOrderItems;
use App\Models\Upload\FileUpload;
use App\Services\sales\SalesOrderItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalesOrderItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $fetchData = SalesOrderItems::with('salesOrder')->get();

        $data['message'] = "Sales Order Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $dataInsert = $request->all();

        $response = salesOrderAddRemoveAction::run($dataInsert);

        $data['message'] = "Sales Quotation Saved";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $response = SalesOrderItems::getDataFromId($id);

        $data['message'] = "Sales Quotation found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SalesOrderItemUpdateRequest $request
     * @param  $id
     * @param  SalesOrderItemService $salesOrderItemService
     * @return JsonResponse
     */
    public function update(SalesOrderItemUpdateRequest $request, $id, SalesOrderItemService $salesOrderItemService): JsonResponse
    {
        $response = $salesOrderItemService->updateSalesOrderItem($id, $request);
        $data['message'] = "Sales Quotation Updated";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $salesOrderItem = SalesOrderItems::find($id);

        if ($salesOrderItem->itemQuantity == $salesOrderItem->itemPendingQuantity) {
            SalesOrderItems::destroy($id);

            $data['message'] = "Sales Quotation Deleted";
            $data['status'] = 200;
            $data['data'] = [];
            return jsonData($data);
        } else {
            return jsonData([
                'message' => 'Item Quantity already in used.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getSalesOrderItemDetails($id): JsonResponse
    {
        $partyData = SalesOrderItems::getData(['salesOrderId' => $id]);
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $partyData;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSalesOrderItems(Request $request): JsonResponse
    {
        $items = SalesOrderItems::whereInData('_id', $request->ids);

        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $items;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param salesOrderListFilterAction $orderListFilterAction
     * @return JsonResponse
     */
    public function getSalesOrderListFilter(Request $request, salesOrderListFilterAction $orderListFilterAction): JsonResponse
    {
        $response = $orderListFilterAction->handle($request);

        $data['message'] = "Sales Order Found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param SalesOrderItems $salesOrderItems
     * @return JsonResponse
     */
    public function getSalesOrderFilters(Request $request, SalesOrderItems $salesOrderItems): JsonResponse
    {
        $soNumber = $request->salesOrderNo;
        $itemCode = $request->itemCode;
        $description = $request->itemName;
        $drawingNumber = $request->itemDrawingNo;

        $itemDetails = $salesOrderItems->query();

        if (!empty($soNumber)) {
            $itemDetails->where('salesOrderNo', 'LIKE', "%{$soNumber}%");
        }

        if (!empty($itemCode)) {
            $itemDetails->where('itemCode', 'LIKE', "%{$itemCode}%");
        }

        if (!empty($description)) {
            $itemDetails->where('itemName', 'LIKE', "%{$description}%");
        }

        if (!empty($drawingNumber)) {
            $itemDetails->where('itemDrawingNo', 'LIKE', "%{$drawingNumber}%");
        }

        if (empty($soNumber) && empty($itemCode) && empty($description) && empty($drawingNumber)) {
            $response = [];
        } else {
            $response = $itemDetails->onlyPendingItem()->get();
        }

        $data['message'] = "Sales Order Item List";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    public function itemDocuments()
    {
        $SaveData = FileUpload::saveData(array());

        $Item = SalesOrderItems::find(1);

        $Item->uploadItemDocument()->save($SaveData);

        //SalesOrderItems::with('uploadItemDocument')->find(1);
    }

}
