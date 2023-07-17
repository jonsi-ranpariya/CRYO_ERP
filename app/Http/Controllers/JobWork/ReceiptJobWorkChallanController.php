<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\ReceiptJobWorkChallan;
use App\Models\ProductionPlanning\JobCards;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReceiptJobWorkChallanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = ReceiptJobWorkChallan::with([
            'partyDetails:_id,partyCode,partyName',
            'jobWorkDetail:_id,itemJobWorkNo',
        ])->get();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param ReceiptJobWorkChallan $receiptJobWorkChallan
     * @return JsonResponse
     */
    public function store(Request $request, ReceiptJobWorkChallan $receiptJobWorkChallan)
    {
        $dataInsert = $request->all();
        $response = $receiptJobWorkChallan->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  ReceiptJobWorkChallan  $receiptJobWorkChallan
     * @return JsonResponse
     */
    public function show(ReceiptJobWorkChallan $receiptJobWorkChallan)
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $receiptJobWorkChallan;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ReceiptJobWorkChallan $receiptJobWorkChallan
     * @return JsonResponse
     */
    public function update(Request $request, ReceiptJobWorkChallan $receiptJobWorkChallan)
    {
        $dataUpdated = $request->all();
        $response = $receiptJobWorkChallan->updateData($receiptJobWorkChallan->_id, $dataUpdated);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReceiptJobWorkChallan $receiptJobWorkChallan
     * @return JsonResponse
     */
    public function destroy(ReceiptJobWorkChallan $receiptJobWorkChallan)
    {
        $response = $receiptJobWorkChallan->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    public function getReceiptJobWorkItemOption()
    {
        $fetchData = ReceiptJobWorkChallan::getData([]);
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->itemCode . ' - ' . $value->itemDescription;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Job Work Receipt Item Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);

    }

    /**
         * @param Request $request
         * @param JobCards $jobCards
         * @return JsonResponse
         */
    public function getReceiptJobWorkItemFilter(Request $request, ReceiptJobWorkChallan $receiptJobWorkChallan)
    {
        $itemCode = $request->itemCode;
        $itemDescription = $request->itemDescription;
        $detailDescription = $request->itemDetailDescription;
        $drawingNumber = $request->itemDrawingNo;

        $itemDetails = $receiptJobWorkChallan->query();

        if (!empty($itemCode)) {
            $itemDetails->where('itemCode', 'LIKE', "%{$itemCode}%");
        }

        if (!empty($itemDescription)) {
            $itemDetails->where('itemDescription', 'LIKE', "%{$itemDescription}%");
        }

        if (!empty($detailDescription)) {
            $itemDetails->where('itemDetailDescription', 'LIKE', "%{$detailDescription}%");
        }

        if (!empty($drawingNumber)) {
            $itemDetails->where('itemDrawingNo', 'LIKE', "%{$drawingNumber}%");
        }

        if (empty($itemCode) && empty($itemDescription) && empty($detailDescription) && empty($drawingNumber)) {
            $response = [];
        } else {
            $response = $itemDetails->get();
        }

        $data['message'] = "Item Job Work Receipt List";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

}
