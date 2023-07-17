<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseReturnItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseReturnItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = PurchaseReturnItem::all();
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
        $response = PurchaseReturnItem::saveData($dataInsert);

        $data['message'] = 'Data Save';
        $data['data'] = $response;
        return jsonData($data);

    }

    /**
     * Display the specified resource.
     *
     * @param PurchaseReturnItem $purchaseReturnItem
     * @return JsonResponse
     */
    public function show(PurchaseReturnItem $purchaseReturnItem): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseReturnItem;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PurchaseReturnItem $purchaseReturnItem
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseReturnItem $purchaseReturnItem): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $purchaseReturnItem->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Update';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PurchaseReturnItem $purchaseReturnItem
     * @return JsonResponse
     */
    public function destroy(PurchaseReturnItem $purchaseReturnItem): JsonResponse
    {
        $data['message'] = 'Data Update';
        $data['data'] = $purchaseReturnItem->delete();
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getPurchaseReturnItems($id): JsonResponse
    {
        $response = PurchaseReturnItem::getData(['purchaseReturnId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
