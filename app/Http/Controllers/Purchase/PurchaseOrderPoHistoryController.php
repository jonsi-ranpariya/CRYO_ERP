<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseOrderPoHistory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Psy\Util\Json;

class PurchaseOrderPoHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = PurchaseOrderPoHistory::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $response = PurchaseOrderPoHistory::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param c $purchaseCosting
     * @return JsonResponse
     */
    public function show(PurchaseOrderPoHistory $purchaseOrderPoHistory)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseOrderPoHistory;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PurchaseCosting $purchaseCosting
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseOrderPoHistory $purchaseOrderPoHistory)
    {
        $dataUpdated = $request->all();
        $response = $purchaseOrderPoHistory->updateData($purchaseOrderPoHistory->_id, $dataUpdated);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PurchaseCosting $purchaseCosting
     * @return JsonResponse
     */
    public function destroy(PurchaseOrderPoHistory $purchaseOrderPoHistory)
    {
        $response = $purchaseOrderPoHistory->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @param PurchaseOrderPoHistory $purchaseOrderPoHistory
     * @return JsonResponse
     */
    public function getPoHistoryDetails($id, PurchaseOrderPoHistory $purchaseOrderPoHistory)
    {
        $response = $purchaseOrderPoHistory->getData(['purchaseOrderId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }


}
