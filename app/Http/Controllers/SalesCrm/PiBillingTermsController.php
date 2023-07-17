<?php

namespace App\Http\Controllers\SalesCrm;

use App\Http\Controllers\Controller;
use App\Models\SalesCrm\PiBillingTerms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PiBillingTermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = PiBillingTerms::all();

        $data['message'] = "Sales Order Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return jsonResponse
     */
    public function store(Request $request)
    {
        $dataInsert = $request->all();

        $party_master = PiBillingTerms::saveData($dataInsert);

        $data['message'] = "Billing Terms Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = PiBillingTerms::getDataFromId($id);

        $data['message'] = "Billing Terms found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $updateData = $request->all();

        $response = PiBillingTerms::updateData($id,$updateData);

        $data['message'] = "Billing Terms Updated";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        PiBillingTerms::destroy($id);

        $data['message'] = "Billing Terms Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getPiBillingTermDetails($id)
    {
        $partyData = PiBillingTerms::getData(['pInvoiceId' => $id]);
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $partyData;
        return jsonData($data, Response::HTTP_OK);
    }

    public function deleteOldProformaBillingTerms($id)
    {
        PiBillingTerms::deleteData(['pInvoiceId' => $id]);

        $data['message'] = "Data Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }
}
