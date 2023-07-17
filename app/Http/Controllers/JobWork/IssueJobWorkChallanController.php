<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\IssueJobWorkChallan;
use App\Models\JobWork\IssueJobWorkChallanItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IssueJobWorkChallanController extends Controller
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
        $data['data'] = IssueJobWorkChallan::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param IssueJobWorkChallan $issueJobWorkChallan
     * @return JsonResponse
     */
    public function store(Request $request, IssueJobWorkChallan $issueJobWorkChallan)
    {
        $dataInsert = $request->all();

        $latest = $issueJobWorkChallan->query()->latest()->first();

        if (!$latest) {
            $newNumber = 'C00001';
        } else {
            $string = preg_replace("/[^0-9\.]/", '', $latest->challanNo);
            $newNumber =  'C' .sprintf('%05d', $string + 1);
        }
        $dataInsert['challanNo'] = $newNumber;

        $response = $issueJobWorkChallan->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }


    /**
     * Display the specified resource.
     *
     *
     * @param  IssueJobWorkChallan  $issueJobWorkChallan
     * @return JsonResponse
     */
    public function show(IssueJobWorkChallan $issueJobWorkChallan)
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $issueJobWorkChallan;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param IssueJobWorkChallan $issueJobWorkChallan
     * @return JsonResponse
     */
    public function update(Request $request, IssueJobWorkChallan $issueJobWorkChallan)
    {
        $dataUpdated = $request->all();
        $response = $issueJobWorkChallan->updateData($issueJobWorkChallan->_id, $dataUpdated);

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
        IssueJobWorkChallan::destroyData($id);
        IssueJobWorkChallanItems::deleteData(['jobWorkId' => $id]);

        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }
}
