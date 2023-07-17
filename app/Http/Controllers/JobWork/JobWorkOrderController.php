<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\JobWorkOrder;
use App\Models\JobWork\JobWorkOrderBillingTerm;
use App\Models\JobWork\JobWorkOrderItems;
use App\Models\JobWork\JobWorkOrderTermCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobWorkOrderController extends Controller
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
        $data['data'] = JobWorkOrder::with(['cityDetails'])->get();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobWorkOrder $jobWorkOrder
     * @return JsonResponse
     */
    public function store(Request $request, JobWorkOrder $jobWorkOrder)
    {
        $dataInsert = $request->all();
        $response = $jobWorkOrder->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param JobWorkOrder $jobWorkOrder
     * @return JsonResponse
     */
    public function show(JobWorkOrder $jobWorkOrder)
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $jobWorkOrder;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param JobWorkOrder $jobWorkOrder
     * @return JsonResponse
     */
    public function update(Request $request, JobWorkOrder $jobWorkOrder)
    {
        $dataUpdated = $request->all();
        $response = $jobWorkOrder->updateData($jobWorkOrder->_id, $dataUpdated);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        JobWorkOrder::destroyData($id);
        JobWorkOrderItems::deleteData(['jobWorkId' => $id]);
        JobWorkOrderTermCondition::deleteData(['jobWorkId' => $id]);
        JobWorkOrderBillingTerm::deleteData(['jobWorkOrderId' => $id]);

        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }

    public function getJobWorkNoByParty(string $partyId)
    {
        $response = JobWorkOrder::query()->where('subContractorId', $partyId)->get();

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
