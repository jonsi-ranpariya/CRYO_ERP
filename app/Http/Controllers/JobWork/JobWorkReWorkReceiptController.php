<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\JobWorkReWorkReceipt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobWorkReWorkReceiptController extends Controller
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
        $data['data'] = JobWorkReWorkReceipt::with([
            'partyDetails:_id,partyCode,partyName',
        ])->get();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobWorkReWorkReceipt $jobWorkReWorkReceipt
     * @return JsonResponse
     */
    public function store(Request $request, JobWorkReWorkReceipt $jobWorkReWorkReceipt)
    {
        $dataInsert = $request->all();
        $response = $jobWorkReWorkReceipt->saveData($dataInsert);

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
        $response = JobWorkReWorkReceipt::getDataFromId($id);
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
        $updateData = JobWorkReWorkReceipt::updateData($id, $request->all());

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
        JobWorkReWorkReceipt::destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

}
