<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\ReturnRejectionBillingTerm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReturnRejectionBillingTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = ReturnRejectionBillingTerm::all();

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
        $response = ReturnRejectionBillingTerm::saveData($dataInsert);

        $data['message'] = 'Data saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  ReturnRejectionBillingTerm  $returnRejectionBillingTerm
     * @return JsonResponse
     */
    public function show(ReturnRejectionBillingTerm $returnRejectionBillingTerm)
    {
        $data['message'] = 'Data found';
        $data['data'] = $returnRejectionBillingTerm;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  ReturnRejectionBillingTerm  $returnRejectionBillingTerm
     * @return JsonResponse
     */
    public function update(Request $request, ReturnRejectionBillingTerm $returnRejectionBillingTerm)
    {
        $dataUpdate = $request->all();
        $response = $returnRejectionBillingTerm->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ReturnRejectionBillingTerm  $returnRejectionBillingTerm
     * @return JsonResponse
     */
    public function destroy(ReturnRejectionBillingTerm $returnRejectionBillingTerm)
    {
        $data['message'] = 'Data Deleted';
        $data['data'] = $returnRejectionBillingTerm->delete();
        return jsonData($data);
    }

    public function getReturnRejectionBillingTerm($id)
    {
        $response = ReturnRejectionBillingTerm::getData(['returnRejectMemoId' => $id]);

        $data['message'] = 'Data found';
        $data['data'] = $response;
        return jsonData($data);
    }

    public function deleteReturnRejectionBillingTerm($id)
    {
        $response = ReturnRejectionBillingTerm::deleteData(['returnRejectMemoId' => $id]);

        $data['message'] = 'Data deleted';
        $data['data'] = $response;
        return jsonData($data);
    }
}
