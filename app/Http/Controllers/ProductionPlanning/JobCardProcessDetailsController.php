<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\Master\TermsConditionDetailsMaster;
use App\Models\ProductionPlanning\JobCardProcessDetails;
use App\Models\ProductionPlanning\JobCardProcessInSide;
use App\Models\ProductionPlanning\ProcessSheetList;
use App\Services\ProductionPlanning\JobCardProcessDetailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobCardProcessDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = JobCardProcessDetails::all();
        $data['message'] = 'Process Detail Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobCardProcessDetailService $jobCardProcessDetailService
     * @return JsonResponse
     */
    public function store(Request $request, JobCardProcessDetailService $jobCardProcessDetailService)
    {
        $dataInsert = $request->all();
        $response = $jobCardProcessDetailService->saveProcessDetails($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param JobCardProcessDetails $JobCardProcessDetails
     * @return JsonResponse
     */
    public function show($id, JobCardProcessDetails $JobCardProcessDetails)
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $JobCardProcessDetails->getDataFromId($id);
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $id
     * @param Request $request
     * @param JobCardProcessDetails $JobCardProcessDetails
     * @return JsonResponse
     */
    public function update($id, Request $request, JobCardProcessDetails $JobCardProcessDetails)
    {
        $dataUpdate = $request->all();
        $response = $JobCardProcessDetails->updateData($id, $dataUpdate);

        $data['message'] = 'process details Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param JobCardProcessDetails $JobCardProcessDetails
     * @return JsonResponse
     */
    public function destroy(JobCardProcessDetails $JobCardProcessDetails, $id)
    {
        $JobCardProcessDetails->destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }


    /**
     * @param $id
     * @param JobCardProcessDetails $jobCardProcessDetails
     * @return JsonResponse
     */
    public function getJobProcessDetails($id, JobCardProcessDetails $jobCardProcessDetails)
    {
        $response = $jobCardProcessDetails->getData(['jobId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

}
