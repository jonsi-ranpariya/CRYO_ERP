<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\JobWorkRateTermsCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobWorkRateTermsConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = JobWorkRateTermsCondition::all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
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
        $response = JobWorkRateTermsCondition::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  JobWorkRateTermsCondition  $jobWorkRateTermsCondition
     * @return JsonResponse
     */
    public function show(JobWorkRateTermsCondition $jobWorkRateTermsCondition)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $jobWorkRateTermsCondition;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  JobWorkRateTermsCondition  $jobWorkRateTermsCondition
     * @return JsonResponse
     */
    public function update(Request $request, JobWorkRateTermsCondition $jobWorkRateTermsCondition)
    {
        $dataUpdate = $request->all();
        $response = $jobWorkRateTermsCondition->updateData($jobWorkRateTermsCondition->_id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  JobWorkRateTermsCondition  $jobWorkRateTermsCondition
     * @return JsonResponse
     */
    public function destroy(JobWorkRateTermsCondition $jobWorkRateTermsCondition)
    {
        $data['message'] = 'Data Delete';
        $data['data'] = $jobWorkRateTermsCondition->delete();
        return jsonData($data);
    }

    /**
     * @param $id
     * @param JobWorkRateTermsCondition $jobWorkRateTermsCondition
     * @return JsonResponse
     */
    public function getJobWorkRateMasterTermCondition($id, JobWorkRateTermsCondition $jobWorkRateTermsCondition)
    {
        $response = $jobWorkRateTermsCondition->getData(['jobRateId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
