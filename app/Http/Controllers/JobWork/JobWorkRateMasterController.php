<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\JobWorkRateMaster;
use App\Models\JobWork\JobWorkRateMasterProcess;
use App\Models\JobWork\JobWorkRateTermsCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobWorkRateMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = JobWorkRateMaster::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobWorkRateMaster $jobWorkRateMaster
     * @return JsonResponse
     */
    public function store(Request $request, JobWorkRateMaster $jobWorkRateMaster)
    {
        $dataInsert = $request->all();
        $response = $jobWorkRateMaster->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = JobWorkRateMaster::getDataFromId($id);
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $updateData = JobWorkRateMaster::updateData($id, $request->all());

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $updateData;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        JobWorkRateMaster::destroyData($id);
        JobWorkRateMasterProcess::deleteData(['RateProcessId' => $id]);
        JobWorkRateTermsCondition::deleteData(['jobRateId' => $id]);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    public function getSubContractorByItemCode(string $itemCode)
    {
        $contactors = JobWorkRateMaster::getRelationData(['itemCode' => $itemCode]);
        foreach ($contactors as $key => $contactor) {
            if (!empty($contactor->subContractorDetails['subContractorCode'])){
                $response[$key]['label'] = '('.$contactor->subContractorDetails['subContractorCode'].') - '.$contactor->subContractorDetails['subContractorName'];
                $response[$key]['value'] = $contactor->subContractorDetails['subContractorId'];
            }
        }

        $data['message'] = 'Data Found';
        $data['data'] = array_values($response ?? []);
        return jsonData($data);
    }
}
