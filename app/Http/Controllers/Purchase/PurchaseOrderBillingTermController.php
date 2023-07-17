<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseOrderBillingTerm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseOrderBillingTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = PurchaseOrderBillingTerm::all();

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
        $response = PurchaseOrderBillingTerm::saveData($dataInsert);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return  jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param PurchaseOrderBillingTerm $purchaseOrderBillingTerm
     * @return JsonResponse
     */
    public function show(PurchaseOrderBillingTerm $purchaseOrderBillingTerm): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseOrderBillingTerm;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PurchaseOrderBillingTerm $purchaseOrderBillingTerm
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseOrderBillingTerm $purchaseOrderBillingTerm): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $purchaseOrderBillingTerm->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PurchaseOrderBillingTerm $purchaseOrderBillingTerm
     * @return JsonResponse
     */
    public function destroy(PurchaseOrderBillingTerm $purchaseOrderBillingTerm): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseOrderBillingTerm->delete();
        return jsonData($data);
    }

    /**
     * @param $id
     * @param PurchaseOrderBillingTerm $purchaseOrderBillingTerm
     * @return JsonResponse
     */
    public function getPurchaseOrderBillingTerm($id, PurchaseOrderBillingTerm $purchaseOrderBillingTerm): JsonResponse
    {
        $response = $purchaseOrderBillingTerm->getData(['purchaseOrderId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    public function deletePurchaseBillingTerms($id, PurchaseOrderBillingTerm $purchaseOrderBillingTerm): JsonResponse
    {
        $response = $purchaseOrderBillingTerm->deleteData(['purchaseOrderId' => $id]);

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    public function bulkAddBillingTerm(Request $request)
    {
        $billingTerm = $request->billingTerm;

        if (count($billingTerm) > 0){
            $response = PurchaseOrderBillingTerm::query()->insert($billingTerm);
        }

        $data['message'] = 'Data Added';
        $data['data'] = $response ?? false;
        return jsonData($data);
    }
}
