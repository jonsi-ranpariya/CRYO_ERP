<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseEnquiryVendorDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PurchaseEnquiryVendorDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = PurchaseEnquiryVendorDetail::with(['enquiryDetails:referenceNumber,referenceDate'])->get();

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
        $vendorExist = PurchaseEnquiryVendorDetail::query()
            ->where([
                'referenceId' => $request->referenceId,
                'vendorCode' => $request->vendorCode
            ])
            ->exists();
        if ($vendorExist) {
            return jsonData(['message' => 'Vendor Already Exist'], Response::HTTP_BAD_REQUEST);
        }

        $dataInsert = $request->all();
        $response = PurchaseEnquiryVendorDetail::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param PurchaseEnquiryVendorDetail $purchaseEnquiryVendorDetail
     * @return JsonResponse
     */
    public function show(PurchaseEnquiryVendorDetail $purchaseEnquiryVendorDetail)
    {
        $response = PurchaseEnquiryVendorDetail::query()
            ->with([
                'enquiryDetails:_id,referenceNumber,referenceDate',
                'partyMasterDetails' => fn ($partyQuery) => [
                    $partyQuery->select(['_id', 'partyCurrencyType']),
                    $partyQuery->with('currenyDetails'),
                ]
            ])
            ->find($purchaseEnquiryVendorDetail->_id);
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PurchaseEnquiryVendorDetail $purchaseEnquiryVendorDetail
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseEnquiryVendorDetail $purchaseEnquiryVendorDetail)
    {
        $dataUpdate = $request->all();
        $response = $purchaseEnquiryVendorDetail->updateData($purchaseEnquiryVendorDetail->_id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PurchaseEnquiryVendorDetail $purchaseEnquiryVendorDetail
     * @return JsonResponse
     */
    public function destroy(PurchaseEnquiryVendorDetail $purchaseEnquiryVendorDetail)
    {
        $response = $purchaseEnquiryVendorDetail->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $referenceId
     * @param PurchaseEnquiryVendorDetail $purchaseEnquiryVendorDetail
     * @return JsonResponse
     */
    public function purchaseEnquiryVendorDetails($referenceId, PurchaseEnquiryVendorDetail $purchaseEnquiryVendorDetail)
    {
        $response = $purchaseEnquiryVendorDetail->getData(['referenceId' => $referenceId]);

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }
}
