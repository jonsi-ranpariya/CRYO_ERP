<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseReturnBilling;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseReturnBillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = PurchaseReturnBilling::all();

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
        $response = PurchaseReturnBilling::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  PurchaseReturnBilling  $purchaseReturnBilling
     * @return JsonResponse
     */
    public function show(PurchaseReturnBilling $purchaseReturnBilling): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseReturnBilling;

        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  PurchaseReturnBilling  $purchaseReturnBilling
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseReturnBilling $purchaseReturnBilling): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $purchaseReturnBilling::updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data update';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PurchaseReturnBilling  $purchaseReturnBilling
     * @return JsonResponse
     */
    public function destroy(PurchaseReturnBilling $purchaseReturnBilling): JsonResponse
    {
        $data['message'] = 'Data Deleted';
        $data['data'] = $purchaseReturnBilling->delete();

        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getPurchaseReturnBillingTerm($id): JsonResponse
    {
        $response = PurchaseReturnBilling::getData(['purchaseReturnId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deletePurchaseReturnBillingTerm($id): JsonResponse
    {
        $response = PurchaseReturnBilling::deleteData(['purchaseReturnId' => $id]);

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }
}
