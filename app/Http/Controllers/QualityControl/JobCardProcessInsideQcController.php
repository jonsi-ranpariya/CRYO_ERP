<?php

namespace App\Http\Controllers\QualityControl;

use App\Http\Controllers\Controller;
use App\Models\QualityControl\JobCardProcessInsideQc;
use App\Services\ProductionPlanning\JobCardProcessInsideQcService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobCardProcessInsideQcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = JobCardProcessInsideQc::all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobCardProcessInsideQcService $service
     * @return JsonResponse
     */
    public function store(Request $request, JobCardProcessInsideQcService $service): JsonResponse
    {
        $response = $service->handle($request);

        $data['message'] = 'Data saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param JobCardProcessInsideQc $jobCardProcessInsideQc
     * @return JsonResponse
     */
    public function show(JobCardProcessInsideQc $jobCardProcessInsideQc): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $jobCardProcessInsideQc;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param JobCardProcessInsideQc $jobCardProcessInsideQc
     * @return JsonResponse
     */
    public function update(Request $request, JobCardProcessInsideQc $jobCardProcessInsideQc): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $jobCardProcessInsideQc->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $response = JobCardProcessInsideQc::find($id);
        $response->transactions()->delete();
        $response->delete();

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        return jsonData($data);
    }
}
