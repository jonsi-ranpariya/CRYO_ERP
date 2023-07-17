<?php

namespace App\Http\Controllers\Purchase;

use App\Actions\Purchase\PurchaseOrderModalItemsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\PurchaseOrderItemUpdateRequest;
use App\Models\Inventory\GoodsReceiptNoteItem;
use App\Models\Purchase\PurchaseOrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PurchaseOrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = PurchaseOrderItem::all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
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
        $response = PurchaseOrderItem::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param PurchaseOrderItem $purchaseOrderItem
     * @return JsonResponse
     */
    public function show(PurchaseOrderItem $purchaseOrderItem): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseOrderItem;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PurchaseOrderItemUpdateRequest $request
     * @param PurchaseOrderItem $purchaseOrderItem
     * @return JsonResponse
     */
    public function update(PurchaseOrderItemUpdateRequest $request, PurchaseOrderItem $purchaseOrderItem): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $purchaseOrderItem->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PurchaseOrderItem $purchaseOrderItem
     * @return JsonResponse
     */
    public function destroy(PurchaseOrderItem $purchaseOrderItem): JsonResponse
    {
        if ($purchaseOrderItem->itemQuantityUm === $purchaseOrderItem->pendingQtyUm) {
            $data['message'] = 'Data Deleted';
            $data['data'] = $purchaseOrderItem->delete();
            return jsonData($data);
        } else {
            return jsonData(
                ['message' => 'Item Quantity already in used.']
                , Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    /**
     * Display a listing of the resource for particular order.
     *
     * @param $id
     * @param PurchaseOrderItem $purchaseOrderItem
     * @return JsonResponse
     */
    public function getPurchaseOrderItems($id, PurchaseOrderItem $purchaseOrderItem): JsonResponse
    {
        $response = $purchaseOrderItem->getData(['purchaseOrderId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param PurchaseOrderModalItemsAction $purchaseOrderModalItemsAction
     * @return JsonResponse
     */
    public function addPurchaseOrderMultipleItems(Request $request, PurchaseOrderModalItemsAction $purchaseOrderModalItemsAction): JsonResponse
    {
        $response = $purchaseOrderModalItemsAction->handle($request);

        $data['message'] = $response ? 'Data Saved' : 'Data Not Saved';
        $data['data'] = $response;
        return jsonData($data, $response ? ResponseAlias::HTTP_OK : ResponseAlias::HTTP_BAD_REQUEST);
    }


    /**
     * @param $purchaseOrderId
     * @return JsonResponse
     */
    public function getPurchaseOrderItemList($purchaseOrderId): JsonResponse
    {
        $grnIds = GoodsReceiptNoteItem::query()->pluck('poItemId')->toArray();
        $response = PurchaseOrderItem::query()
            ->where('purchaseOrderId', $purchaseOrderId)
            ->whereNotIn('_id', $grnIds)
            ->get();

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
