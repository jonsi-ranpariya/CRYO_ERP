<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\IssueJobWorkChallanItems;
use App\Models\ProductionPlanning\ShowIssueItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IssueJobWorkChallanItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['data'] = IssueJobWorkChallanItems::all();

        $data['message'] = 'Data Found';
        $data['status'] = 200;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param IssueJobWorkChallanItems $issueJobWorkChallanItems
     * @return JsonResponse
     */
    public function store(Request $request, IssueJobWorkChallanItems $issueJobWorkChallanItems)
    {
        $dataInsert = $request->all();
        $response = $issueJobWorkChallanItems->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = IssueJobWorkChallanItems::getDataFromId($id);
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  IssueJobWorkChallanItems  $issueJobWorkChallanItems
     * @return JsonResponse
     */
    public function update(Request $request, IssueJobWorkChallanItems $issueJobWorkChallanItems)
    {
        $dataUpdate = $request->all();
        $response = $issueJobWorkChallanItems->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param IssueJobWorkChallanItems $issueJobWorkChallanItems
     * @return JsonResponse
     */
    public function destroy($id, IssueJobWorkChallanItems $issueJobWorkChallanItems)
    {
        $response = $issueJobWorkChallanItems->destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }



    /**
     * @param Request $request
     * @param IssueJobWorkChallanItems $issueJobWorkChallanItems
     * @return JsonResponse
     */
    public function addShowIssueItem(Request $request, IssueJobWorkChallanItems $issueJobWorkChallanItems)
    {
        $itemDetails = ShowIssueItems::whereInData('_id', $request->ids);
        foreach ($itemDetails as $itemDetail) {
            $dataInsert['jobWorkId'] = $request->jobWorkId;
            $dataInsert['itemId'] = $itemDetail->itemId;
            $dataInsert['showIssueItemId'] = $itemDetail->_id;
            $dataInsert['jobCardId'] = $itemDetail->jobId ?? null;
            $dataInsert['itemCode'] = $itemDetail->item_name['itemCode'] ?? null;
            $dataInsert['itemDescription'] = $itemDetail->issueItemDescription ?? null;
            $dataInsert['itemAddDescription'] = $itemDetail->issueItemAddDescription ?? null;
            $dataInsert['itemDetailDescription'] = $itemDetail->issueItemDetailDescription ?? null;
            $dataInsert['itemDrawingNumber'] = $itemDetail->issueItemDrawingNo ?? null;
            $dataInsert['itemDrawingRevision'] = $itemDetail->issueItemRevision ?? null;
            $dataInsert['itemUom'] = $itemDetail->issueItemUom ?? null;
            $dataInsert['itemQuntity'] = $itemDetail->jobCard_number['jobQty'] ?? null;
            $dataInsert['issueItemQty'] = $itemDetail->issueItemQty ?? null;
            $dataInsert['jobCardNumber'] = $itemDetail->jobCard_number['jobCardNumber'] ?? null;
            $dataInsert['pendingJobQty'] = $itemDetail->jobCard_number['pendingJobQty'] ?? null;
            $issueJobWorkChallanItems->saveData($dataInsert);
        }

        $data['message'] = 'Data Saved';
        $data['data'] = (object)[];
        return jsonData($data);
    }

    public function getJobWorkChallanItems($id)
    {
        $response = IssueJobWorkChallanItems::getData(['jobWorkId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param IssueJobWorkChallanItems $issueJobWorkChallanItems
     * @return JsonResponse
     */
    public function getIssueJobChallanItemFilter(Request $request, IssueJobWorkChallanItems $issueJobWorkChallanItems)
    {
        $itemCode = $request->itemCode;
        $itemDescription = $request->itemDescription;
        $itemDetailDescription = $request->itemDetailDescription;
        $itemDrawingNumber = $request->itemDrawingNumber;

        $itemDetails = $issueJobWorkChallanItems->query();

        if (!empty($itemCode)) {
            $itemDetails->where('itemCode', 'LIKE', "%{$itemCode}%");
        }

        if (!empty($itemDescription)) {
            $itemDetails->where('itemDescription', 'LIKE', "%{$itemDescription}%");
        }

        if (!empty($itemDetailDescription)) {
            $itemDetails->where('itemDetailDescription', 'LIKE', "%{$itemDetailDescription}%");
        }

        if (!empty($itemDrawingNumber)) {
            $itemDetails->where('itemDrawingNumber', 'LIKE', "%{$itemDrawingNumber}%");
        }

        if (empty($itemCode) && empty($itemDescription) && empty($itemDetailDescription) && empty($itemDrawingNumber)) {
            $response = [];
        } else {
            $response = $itemDetails->get();
        }

        $data['message'] = "Item Job Work List";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    public function getJobWorkChallanItemOptions()
    {
        $fetchData = IssueJobWorkChallanItems::getData();
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->itemCode . ' - ' . $value->itemDescription;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Job Work Challan Item Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }


}
