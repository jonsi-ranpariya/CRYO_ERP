<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\ProductionPlanning\JobCardProcessDetails;
use App\Models\ProductionPlanning\JobCardProcessInSide;
use App\Models\ProductionPlanning\JobCardProcessOutSide;
use App\Models\ProductionPlanning\JobCards;
use App\Models\ProductionPlanning\ShowIssueItems;
use App\Services\ProductionPlanning\JobCardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     *
     */
    public function index(): JsonResponse
    {
        $response = JobCards::all();

        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobCardService $jobCardService
     * @return JsonResponse
     */
    public function store(Request $request, JobCardService $jobCardService): JsonResponse
    {
        $response = $jobCardService->handle($request);

        $data['message'] = 'data saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     * @param $id
     * @param JobCards $jobCards
     * @return JsonResponse
     */
    public function show($id, JobCards $jobCards): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $jobCards->getDataFromId($id);
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     * @param $id
     * @param Request $request
     * @param JobCards $jobCards
     * @return JsonResponse
     */
    public function update($id, Request $request, JobCards $jobCards): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $jobCards->updateData($id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @param JobCards $jobCards
     * @return JsonResponse
     */
    public function destroy(JobCards $jobCards, $id): JsonResponse
    {
        $jobCards->destroyData($id);
        JobCardProcessDetails::deleteData(['jobId' => $id]);
        JobCardProcessInSide::deleteData(['jobId' => $id]);
        JobCardProcessOutSide::deleteData(['jobId' => $id]);
        ShowIssueItems::deleteData(['jobId' => $id]);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    public function getJobCardItemOptions(): JsonResponse
    {
        $fetchData = JobCards::getData();
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->itemCode . ' - ' . $value->itemDescription;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Job Work Challan Item Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);

    }

    /**
     * @return object
     */
    public function getJobCardOptions(): object
    {
        $items = JobCards::all();
        return $items->map(fn ($item) => [
            'label' => $item->jobCardNumber,
            'value' => $item->_id
        ]);
    }

    /**
     * @param Request $request
     * @param JobCards $jobCards
     * @return JsonResponse
     */
    public function getJobCardItemFilter(Request $request, JobCards $jobCards): JsonResponse
    {
        $itemCode = $request->itemCode;
        $itemDescription = $request->itemDescription;
        $detailDescription = $request->detailDescription;
        $drawingNumber = $request->drawingNumber;

        $itemDetails = $jobCards->query();

        if (!empty($itemCode)) {
            $itemDetails->where('itemCode', 'LIKE', "%{$itemCode}%");
        }

        if (!empty($itemDescription)) {
            $itemDetails->where('itemDescription', 'LIKE', "%{$itemDescription}%");
        }

        if (!empty($detailDescription)) {
            $itemDetails->where('detailDescription', 'LIKE', "%{$detailDescription}%");
        }

        if (!empty($drawingNumber)) {
            $itemDetails->where('drawingNumber', 'LIKE', "%{$drawingNumber}%");
        }

        if (empty($itemCode) && empty($itemDescription) && empty($detailDescription) && empty($drawingNumber)) {
            $response = [];
        } else {
            $response = $itemDetails->get();
        }

        $data['message'] = "Item Job Card List";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }
}
