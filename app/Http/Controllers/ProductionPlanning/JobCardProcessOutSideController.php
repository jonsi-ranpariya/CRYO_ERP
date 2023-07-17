<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\ProductionPlanning\JobCardProcessInSide;
use App\Models\ProductionPlanning\JobCardProcessOutSide;
use App\Models\ProductionPlanning\JobCardReturnShopItem;
use App\Models\ProductionPlanning\ShowIssueItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobCardProcessOutSideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = JobCardProcessOutSide::all();

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobCardProcessOutSide $jobCardProcessOutSide
     * @return JsonResponse
     */
    public function store(Request $request, JobCardProcessOutSide $jobCardProcessOutSide)
    {
        $dataInsert = $request->all();
        $response = $jobCardProcessOutSide->saveData($dataInsert);

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
        $response = JobCardProcessOutSide::getDataFromId($id);
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  JobCardProcessOutSide  $jobCardProcessOutSide
     * @return JsonResponse
     */
    public function update(Request $request, JobCardProcessOutSide $jobCardProcessOutSide)
    {
        $dataUpdate = $request->all();
        $response = $jobCardProcessOutSide->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param JobCardProcessOutSide $jobCardProcessOutSide
     * @return JsonResponse
     */
    public function destroy($id, JobCardProcessOutSide $jobCardProcessOutSide)
    {
        $response = $jobCardProcessOutSide->destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    public function getProcessOutSide($id)
{
    $response = JobCardProcessOutSide::getData(['jobId' => $id]);

    $data['message'] = 'Data Found';
    $data['data'] = $response;
    return jsonData($data);
}

}
