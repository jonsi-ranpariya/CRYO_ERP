<?php

namespace App\Http\Controllers\QualityControl;

use App\Http\Controllers\Controller;
use App\Models\QualityControl\JobWorkOutsideQc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobWorkOutsideQcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $response = JobWorkOutsideQc::all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request  $request
     * @return JsonResponse
     */
    public function store(Request $request, JobWorkOutsideQc $jobWorkOutsideQc): JsonResponse
    {
        $dataInsert = $request->all();
        $response = $jobWorkOutsideQc->saveData($dataInsert);

        $data['message'] = 'Data saved';
        $data['data'] = $response;
        return jsonData($data);

    }

    /**
     * Display the specified resource.
     *
     * @param JobWorkOutsideQc  $jobWorkOutsideQc
     * @return JsonResponse
     */
    public function show(JobWorkOutsideQc $jobWorkOutsideQc): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $jobWorkOutsideQc;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param JobWorkOutsideQc  $jobWorkOutsideQc
     * @return JsonResponse
     */
    public function update(Request $request, JobWorkOutsideQc $jobWorkOutsideQc): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $jobWorkOutsideQc->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param JobWorkOutsideQc  $jobWorkOutsideQc
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        JobWorkOutsideQc::destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        return jsonData($data);
    }
}
