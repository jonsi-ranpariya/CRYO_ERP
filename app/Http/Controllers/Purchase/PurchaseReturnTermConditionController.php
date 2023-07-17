<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseReturnTermCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseReturnTermConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = PurchaseReturnTermCondition::all();

        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $dataInsert = $request->all();
        $response = PurchaseReturnTermCondition::saveData($dataInsert);

        $data['message'] = 'Data saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  PurchaseReturnTermCondition  $purchaseReturnTermCondition
     * @return JsonResponse
     */
    public function show(PurchaseReturnTermCondition $purchaseReturnTermCondition): JsonResponse
    {
        $data['message'] = 'Data found';
        $data['data'] = $purchaseReturnTermCondition;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  PurchaseReturnTermCondition  $purchaseReturnTermCondition
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseReturnTermCondition $purchaseReturnTermCondition): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $purchaseReturnTermCondition->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @param PurchaseReturnTermCondition $purchaseReturnTermCondition
     * @return JsonResponse
     */
    public function destroy(string $id, PurchaseReturnTermCondition $purchaseReturnTermCondition): JsonResponse
    {
        $data['message'] = 'Data deleted';
        $data['data'] = $purchaseReturnTermCondition->destroyData($id);

        return jsonData($data);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getPurchaseReturnTermCondition(string $id): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = PurchaseReturnTermCondition::getData(['purchaseReturnId' => $id]);
        return jsonData($data);
    }
}
