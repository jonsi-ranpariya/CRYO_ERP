<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\JobWorkOrderItems;
use App\Models\JobWork\JobWorkReWorkChallanItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobWorkReWorkChallanItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = JobWorkReWorkChallanItem::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobWorkReWorkChallanItem $jobWorkReWorkChallanItem
     * @return JsonResponse
     */
    public function store(Request $request, JobWorkReWorkChallanItem $jobWorkReWorkChallanItem)
    {
        $dataInsert = $request->all();
        $response = $jobWorkReWorkChallanItem->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param JobWorkReWorkChallanItem $jobWorkReWorkChallanItem
     * @return JsonResponse
     */
    public function show(JobWorkReWorkChallanItem $jobWorkReWorkChallanItem)
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $jobWorkReWorkChallanItem;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  JobWorkReWorkChallanItem  $jobWorkReWorkChallanItem
     * @return JsonResponse
     */
    public function update(Request $request, JobWorkReWorkChallanItem $jobWorkReWorkChallanItem)
    {
        $dataUpdate = $request->all();
        $response = $jobWorkReWorkChallanItem->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param JobWorkReWorkChallanItem $jobWorkReWorkChallanItem
     * @return JsonResponse
     */
    public function destroy($id, JobWorkReWorkChallanItem $jobWorkReWorkChallanItem)
    {
        $response = $jobWorkReWorkChallanItem->destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param JobWorkReWorkChallanItem $jobWorkReWorkChallanItem
     * @return JsonResponse
     */
    public function addJobReWorkChallanItem(Request $request, JobWorkReWorkChallanItem $jobWorkReWorkChallanItem)
    {
        $itemDetails = JobWorkOrderItems::whereInData('_id', $request->ids);
        // dd($itemDetails);
        foreach ($itemDetails as $itemDetail) {
            $dataInsert['jobReWorkId'] = $request->jobReWorkId;
            $dataInsert['jobWorkItemId'] = $itemDetail->_id ?? null;
            $dataInsert['itemId'] = $itemDetail->itemId ?? null;
            $dataInsert['jobWorkId'] = $itemDetail->jobWorkId ?? null;
            $dataInsert['itemCode'] = $itemDetail->itemCode ?? null;
            $dataInsert['itemDescription'] = $itemDetail->itemDescription ?? null;
            $dataInsert['itemAddDescription'] = $itemDetail->itemAddDescription ?? null;
            $dataInsert['itemDetailDescription'] = $itemDetail->itemDetailDescription ?? null;
            $dataInsert['itemDrawingNumber'] = $itemDetail->itemDrawingNumber ?? null;
            $dataInsert['itemDrawingRevision'] = $itemDetail->itemDrawingRevision ?? null;
            $dataInsert['itemUom'] = $itemDetail->itemUom ?? null;
            $dataInsert['itemQuntity'] = $itemDetail->itemJobWorkQty ?? null;
            $dataInsert['itemPendingQty'] = $itemDetail->itemPendingQty ?? null;
            JobWorkReWorkChallanItem::saveData($dataInsert);
        }

        $data['message'] = 'Data Saved';
        $data['data'] = (object)[];
        return jsonData($data);
    }

    public function getJobReWorkChallanItem($id)
    {
        $response = JobWorkReWorkChallanItem::getData(['jobReWorkId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

}
