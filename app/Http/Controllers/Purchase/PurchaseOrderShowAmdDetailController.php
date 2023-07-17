<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Inventory\GoodsReceiptNoteItem;
use App\Models\Purchase\PurchaseOrderItem;
use App\Models\Purchase\PurchaseOrderShowAmdDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseOrderShowAmdDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = PurchaseOrderShowAmdDetail::all();

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param PurchaseOrderShowAmdDetail $purchaseOrderShowAmdDetail
     * @return JsonResponse
     */
    public function store(Request $request, PurchaseOrderShowAmdDetail $purchaseOrderShowAmdDetail)
    {
        $dataInsert = $request->all();
        $response = $purchaseOrderShowAmdDetail->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = PurchaseOrderShowAmdDetail::getDataFromId($id);
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  PurchaseOrderShowAmdDetail  $purchaseOrderShowAmdDetail
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseOrderShowAmdDetail $purchaseOrderShowAmdDetail)
    {
        $dataUpdate = $request->all();
        $response = $purchaseOrderShowAmdDetail->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PurchaseOrderShowAmdDetail $purchaseOrderShowAmdDetail
     * @return JsonResponse
     */
    public function destroy(PurchaseOrderShowAmdDetail $purchaseOrderShowAmdDetail)
    {
        $response = $purchaseOrderShowAmdDetail->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display a listing of the resource for particular order.
     *
     * @param $id
     * @param PurchaseOrderShowAmdDetail $purchaseOrderShowAmdDetail
     * @return JsonResponse
     */
    public function getPurchaseOrderShowAmdDetails($id, PurchaseOrderShowAmdDetail $purchaseOrderShowAmdDetail)
    {
        $response = $purchaseOrderShowAmdDetail->getData(['purchaseOrderId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }


//    /**
//     * @param $purchaseOrderId
//     * @return JsonResponse
//     */
//    public function getPurchaseOrderShowAmdDetails($purchaseOrderId): JsonResponse
//    {
//        $response = PurchaseOrderShowAmdDetail::query()
//            ->where('purchaseOrderId', $purchaseOrderId)
//            ->get();
//
//        $data['status'] = 200;
//        $data['message'] = 'data found';
//        $data['data'] = $response;
//        return jsonData($data);
//    }

}
