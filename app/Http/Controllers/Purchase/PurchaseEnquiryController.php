<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseEnquiry;
use App\Models\Purchase\PurchaseEnquiryVendorDetail;
use App\Models\Purchase\PurchaseEnquiryItemDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = PurchaseEnquiry::all();
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

        $dataInsert['referenceNumber'] = generateCodes(new PurchaseEnquiry(), 'R22230001', 'referenceNumber', 'R');
        $response = PurchaseEnquiry::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param PurchaseEnquiry $purchaseEnquiry
     * @return JsonResponse
     */
    public function show(PurchaseEnquiry $purchaseEnquiry)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseEnquiry;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PurchaseEnquiry $purchaseEnquiry
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseEnquiry $purchaseEnquiry)
    {
        $dataUpdated = $request->all();
        $response = $purchaseEnquiry->updateData($purchaseEnquiry->_id, $dataUpdated);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        PurchaseEnquiry::destroyData($id);
        PurchaseEnquiryVendorDetail::deleteData(['referenceId' => $id]);
        PurchaseEnquiryItemDetail::deleteData(['referenceId' => $id]);

        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }

}
