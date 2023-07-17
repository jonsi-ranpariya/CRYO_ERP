<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseEnquiryItemDetail;
use App\Services\purchase\PurchaseEnquiryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseEnquiryItemDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = PurchaseEnquiryItemDetail::all();

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
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $response = PurchaseEnquiryItemDetail::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param PurchaseEnquiryItemDetail $purchaseEnquiryItemDetail
     * @return JsonResponse
     */
    public function show(PurchaseEnquiryItemDetail $purchaseEnquiryItemDetail)
    {
        $data['message'] = 'Data Saved';
        $data['data'] = $purchaseEnquiryItemDetail;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PurchaseEnquiryItemDetail $purchaseEnquiryItemDetail
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseEnquiryItemDetail $purchaseEnquiryItemDetail)
    {
        $dataUpdate = $request->all();
        $response = $purchaseEnquiryItemDetail->updateData($purchaseEnquiryItemDetail->_id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PurchaseEnquiryItemDetail $purchaseEnquiryItemDetail
     * @return JsonResponse
     */
    public function destroy(PurchaseEnquiryItemDetail $purchaseEnquiryItemDetail)
    {
        $data['message'] = 'Data Deleted';
        $data['data'] = $purchaseEnquiryItemDetail->delete();
        return jsonData($data);
    }

    /**
     * @param $referenceId
     * @param PurchaseEnquiryItemDetail $purchaseEnquiryItemDetail
     * @return JsonResponse
     */
    public function getPurchaseEnquiryItemDetails($referenceId, PurchaseEnquiryItemDetail $purchaseEnquiryItemDetail)
    {
        $response = $purchaseEnquiryItemDetail->getData(['referenceId' => $referenceId]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param PurchaseEnquiryService $purchaseEnquiryService
     * @return JsonResponse
     */
    public function addPurchaseItemFromSalesOrder(Request $request, PurchaseEnquiryService $purchaseEnquiryService)
    {
        $response = $purchaseEnquiryService->addMultipleItemsFromSalesOrder($request);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param PurchaseEnquiryService $purchaseEnquiryService
     * @return JsonResponse
     */
    public function addPurchaseItemFromIndent(Request $request, PurchaseEnquiryService $purchaseEnquiryService)
    {
        $response = $purchaseEnquiryService->addMultipleItemsFromIndent($request);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }
}
