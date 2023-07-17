<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\JobWorkRateMasterProcess;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobWorkRateMasterProcessController extends Controller
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
        $data['data'] = JobWorkRateMasterProcess::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobWorkRateMasterProcess $jobWorkRateMasterProcess
     * @return JsonResponse
     */
    public function store(Request $request, JobWorkRateMasterProcess $jobWorkRateMasterProcess)
    {
        $dataInsert = $request->all();
        $response = $jobWorkRateMasterProcess->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  JobWorkRateMasterProcess  $jobWorkRateMasterProcess
     * @return JsonResponse
     */
    public function show(JobWorkRateMasterProcess $jobWorkRateMasterProcess)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $jobWorkRateMasterProcess;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param JobWorkRateMasterProcess $jobWorkRateMasterProcess
     * @return JsonResponse
     */
    public function update(Request $request, JobWorkRateMasterProcess $jobWorkRateMasterProcess)
    {
        $dataUpdated = $request->all();
        $response = $jobWorkRateMasterProcess->updateData($jobWorkRateMasterProcess->_id, $dataUpdated);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param JobWorkRateMasterProcess $jobWorkRateMasterProcess
     * @return JsonResponse
     */
    public function destroy(JobWorkRateMasterProcess $jobWorkRateMasterProcess)
    {
        $response = $jobWorkRateMasterProcess->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @param JobWorkRateMasterProcess $jobWorkRateMasterProcess
     * @return JsonResponse
     */
    public function getJobWorkRateProcessDetail($id, JobWorkRateMasterProcess $jobWorkRateMasterProcess)
    {
        $response = $jobWorkRateMasterProcess->getData(['RateProcessId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

}
