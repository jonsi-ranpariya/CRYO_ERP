<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseQuotationBillingTerm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;

class PurchaseQuotationBillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = PurchaseQuotationBillingTerm::all();

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
        $response = PurchaseQuotationBillingTerm::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param PurchaseQuotationBillingTerm $purchaseQuotationBillingTerm
     * @return JsonResponse
     */
    public function show(PurchaseQuotationBillingTerm $purchaseQuotationBillingTerm): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseQuotationBillingTerm;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PurchaseQuotationBillingTerm $purchaseQuotationBillingTerm
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseQuotationBillingTerm $purchaseQuotationBillingTerm): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $purchaseQuotationBillingTerm->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Update';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PurchaseQuotationBillingTerm $purchaseQuotationBillingTerm
     * @return JsonResponse
     */
    public function destroy(PurchaseQuotationBillingTerm $purchaseQuotationBillingTerm): JsonResponse
    {
        $data['message'] = 'Data Deleted';
        $data['data'] = $purchaseQuotationBillingTerm->delete();
        return jsonData($data);
    }

    /**
     * @param $id
     * @param PurchaseQuotationBillingTerm $purchaseQuotationBillingTerm
     * @return JsonResponse
     */
    public function getPurchaseQuotaionBillingTerms($id, PurchaseQuotationBillingTerm $purchaseQuotationBillingTerm): JsonResponse
    {
        $response = $purchaseQuotationBillingTerm->where(['purchaseQuotationId' => $id])->get();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @param PurchaseQuotationBillingTerm $purchaseQuotationBillingTerm
     * @return JsonResponse
     */
    public function deletePurchaseBillingTerms($id, PurchaseQuotationBillingTerm $purchaseQuotationBillingTerm): JsonResponse
    {
        $response = $purchaseQuotationBillingTerm->deleteData(['purchaseQuotationId' => $id]);

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    public function bulkAddPurchaseBillingTerms(
        Request                      $request,
        PurchaseQuotationBillingTerm $purchaseQuotationBillingTerm
    ): JsonResponse
    {
        $billingTerm = collect($request->billingTerm);
        $response = false;
        if ($billingTerm->count() > 0) {
            $items = $billingTerm->map(callback: function ($item) {
                $item['created_at'] = new UTCDateTime(now()->format('Uv'));
                $item['addedFrom'] = auth()->id();
                return $item;
            });

            $response = $purchaseQuotationBillingTerm
                ->query()
                ->insert($items->toArray());
        }

        $data['message'] = $response ? 'Data Saved' : 'Data Not Saved';
        $data['data'] = $response;
        return jsonData($data);
    }
}
