<?php

namespace App\Http\Controllers\JobWork;


use App\Http\Controllers\Controller;
use App\Models\JobWork\JobWorkOrderItems;
use App\Models\ProductionPlanning\JobCards;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JobWorkOrderItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = JobWorkOrderItems::with([
            'jobWorkDetails:_id,subContractorCode,subContractorName,jobWorkNo',
            'processDetails:_id,processName'
        ])->get();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobWorkOrderItems $jobWorkOrderItems
     * @return JsonResponse
     */
    public function store(Request $request, JobWorkOrderItems $jobWorkOrderItems)
    {
        $dataInsert = $request->all();
        $response = $jobWorkOrderItems->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = JobWorkOrderItems::withJobWorkDetails()->withProcessDetails()->find($id);
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param JobWorkOrderItems $jobWorkOrderItems
     * @return JsonResponse
     */
    public function update(Request $request, JobWorkOrderItems $jobWorkOrderItems)
    {
        $dataUpdate = $request->all();
        $response = $jobWorkOrderItems->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param JobWorkOrderItems $jobWorkOrderItems
     * @return JsonResponse
     */
    public function destroy($id, JobWorkOrderItems $jobWorkOrderItems)
    {
        $response = $jobWorkOrderItems->destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param JobWorkOrderItems $jobWorkOrderItems
     * @return JsonResponse
     */
    public function addJobWorkOrderItem(Request $request, JobWorkOrderItems $jobWorkOrderItems)
    {
        $itemDetails = JobCards::whereInData('_id', $request->ids);
//        dd($itemDetails);
        foreach ($itemDetails as $itemDetail) {
            $dataInsert['jobWorkId'] = $request->jobWorkId;
            $dataInsert['itemId'] = $itemDetail->itemId;
            $dataInsert['itemCode'] = $itemDetail->itemCode ?? null;
            $dataInsert['itemDescription'] = $itemDetail->itemDescription ?? null;
            $dataInsert['itemAlice'] = null;
            $dataInsert['itemAddDescription'] = $itemDetail->addDescription ?? null;
            $dataInsert['itemDetailDescription'] = $itemDetail->detailDescription ?? null;
            $dataInsert['itemDrawingNumber'] = $itemDetail->drawingNumber ?? null;
            $dataInsert['itemDrawingRevision'] = $itemDetail->drawingRevesion ?? null;
            $dataInsert['itemUom'] = $itemDetail->uom ?? null;
            $dataInsert['itemConvUom'] = $itemDetail->convUom ?? null;
            $dataInsert['itemConvQty'] = $itemDetail->convQty ?? null;
            $dataInsert['itemcFactor'] = $itemDetail->cFactor ?? null;
            $dataInsert['itemProcess'] = null;
            $dataInsert['itemProcessRate'] = null;
            $dataInsert['itemProcessAmt'] = null;
            $dataInsert['itemProcessNote'] = null;
            $dataInsert['itemJobCardNumber'] = $itemDetail->jobCard ?? null;
            $dataInsert['itemWoNumber'] = $itemDetail->woNumber ?? null;
            $dataInsert['itemDelDate'] = null;
            $dataInsert['itemNote'] = $itemDetail->remark ?? null;
            $dataInsert['itemJobWorkQty'] = $itemDetail->jobQty ?? null;
            $dataInsert['itemAcctQty'] = $itemDetail->acceptedQty ?? null;
            $dataInsert['itemPendingQty'] = $itemDetail->pendingJobQty ?? null;
            $dataInsert['itemRejectedQty'] = $itemDetail->rejectedQty ?? null;
            $dataInsert['itemEstValue'] = null;
            $dataInsert['itemRwQty'] = $itemDetail->rwQty ?? null;
            $dataInsert['itemInternalNote'] = null;
            JobWorkOrderItems::saveData($dataInsert);
        }

        $data['message'] = 'Data Saved';
        $data['data'] = (object)[];
        return jsonData($data);
    }

    public function getJobWorkItems($id)
    {
        $response = JobWorkOrderItems::getData(['jobWorkId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    public function getJobOrderOption()
    {
        $fetchData = JobWorkOrderItems::getData([]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->itemCode . ' - ' . $value->itemDescription;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Item Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param JobWorkOrderItems $jobWorkOrderItems
     * @return JsonResponse
     */
    public function getJobWorkItemFilter(Request $request, JobWorkOrderItems $jobWorkOrderItems)
    {
        $itemCode = $request->itemCode;
        $itemDescription = $request->itemDescription;
        $itemDetailDescription = $request->itemDetailDescription;
        $itemDrawingNumber = $request->itemDrawingNumber;

        $itemDetails = $jobWorkOrderItems->query();

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


}
