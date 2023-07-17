<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseReturn;
use App\Models\Purchase\PurchaseReturnBilling;
use App\Models\Purchase\PurchaseReturnItem;
use App\Models\Purchase\PurchaseReturnTermCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = PurchaseReturn::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $dataInsert = $request->all();
        $response = PurchaseReturn::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param PurchaseReturn $purchaseReturn
     * @return JsonResponse
     */
    public function show(PurchaseReturn $purchaseReturn): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseReturn;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PurchaseReturn $purchaseReturn
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseReturn $purchaseReturn): JsonResponse
    {
        $dataUpdated = $request->all();
        $response = $purchaseReturn->updateData($purchaseReturn->_id, $dataUpdated);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param PurchaseReturn $purchaseReturn
     * @return JsonResponse
     */
    public function destroy(PurchaseReturn $purchaseReturn): JsonResponse
    {
        $response = $purchaseReturn->delete();
        PurchaseReturnItem::deleteData(['purchaseReturnId' => $purchaseReturn->_id]);
        PurchaseReturnBilling::deleteData(['purchaseReturnId' => $purchaseReturn->_id]);
        PurchaseReturnTermCondition::deleteData(['purchaseReturnId' => $purchaseReturn->_id]);

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }
}
