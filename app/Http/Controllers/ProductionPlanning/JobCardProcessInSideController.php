<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\ProductionPlanning\JobCardProcessDetails;
use App\Models\ProductionPlanning\JobCardProcessInSide;
use App\Models\ProductionPlanning\ShowIssueItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobCardProcessInSideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = JobCardProcessInSide::all();

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobCardProcessInSide $jobCardProcessInSide
     * @return JsonResponse
     */
    public function store(Request $request, JobCardProcessInSide $jobCardProcessInSide)
    {
        $dataInsert = $request->all();
        $response = $jobCardProcessInSide->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = JobCardProcessInSide::getDataFromId($id);
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  JobCardProcessInSide  $jobCardProcessInSide
     * @return JsonResponse
     */
    public function update(Request $request, JobCardProcessInSide $jobCardProcessInSide)
    {
        $dataUpdate = $request->all();
        $response = $jobCardProcessInSide->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param JobCardProcessInSide $jobCardProcessInSide
     * @return JsonResponse
     */
    public function destroy($id, JobCardProcessInSide $jobCardProcessInSide)
    {
        $response = $jobCardProcessInSide->destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);

    }

    public function getProcessInside($id)
    {
        $response = JobCardProcessInSide::getData(['jobId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
