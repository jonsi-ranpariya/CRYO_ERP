<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\JobWorkOrderBillingTerm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobWorkOrderBillingTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = JobWorkOrderBillingTerm::all();

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
        $response = JobWorkOrderBillingTerm::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  JobWorkOrderBillingTerm  $jobWorkOrderItemsBillingTerm
     * @return JsonResponse
     */
    public function show(JobWorkOrderBillingTerm $jobWorkOrderItemsBillingTerm)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $jobWorkOrderItemsBillingTerm;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  JobWorkOrderBillingTerm  $jobWorkOrderItemsBillingTerm
     * @return JsonResponse
     */
    public function update(Request $request, JobWorkOrderBillingTerm $jobWorkOrderItemsBillingTerm)
    {
        $dataUpdate = $request->all();
        $response = $jobWorkOrderItemsBillingTerm->updateData($dataUpdate['_id'],$dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  JobWorkOrderBillingTerm  $jobWorkOrderItemsBillingTerm
     * @return JsonResponse
     */
    public function destroy(JobWorkOrderBillingTerm $jobWorkOrderItemsBillingTerm)
    {
        $data['message'] = 'Data Deleted';
        $data['data'] = $jobWorkOrderItemsBillingTerm->delete();
        return jsonData($data);
    }
}
