<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\JobWorkOrderTermCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobWorkOrderTermConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = JobWorkOrderTermCondition::all();

        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $response = JobWorkOrderTermCondition::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  JobWorkOrderTermCondition  $jobWorkOrderTermCondition
     * @return JsonResponse
     */
    public function show(JobWorkOrderTermCondition $jobWorkOrderTermCondition)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $jobWorkOrderTermCondition;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  JobWorkOrderTermCondition  $jobWorkOrderTermCondition
     * @return JsonResponse
     */
    public function update(Request $request, JobWorkOrderTermCondition $jobWorkOrderTermCondition)
    {
        $dataUpdate = $request->all();
        $response = $jobWorkOrderTermCondition->updateData($dataUpdate['_id'],$dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param JobWorkOrderTermCondition $jobWorkOrderTermCondition
     * @return JsonResponse
     */
    public function destroy($id, JobWorkOrderTermCondition $jobWorkOrderTermCondition)
    {
        $data['message'] = 'Data Deleted';
        $data['data'] = $jobWorkOrderTermCondition->destroyData($id);
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getTermAndConditions($id)
    {
        $response = JobWorkOrderTermCondition::getData(['jobWorkId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
