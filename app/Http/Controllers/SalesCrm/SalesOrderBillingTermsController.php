<?php

namespace App\Http\Controllers\SalesCrm;

use App\Http\Controllers\Controller;
use App\Models\SalesCrm\SalesOrderBillingTerms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalesOrderBillingTermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = SalesOrderBillingTerms::all();

        $data['message'] = "Sales Order Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data, Response::HTTP_OK);
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

        $party_master = SalesOrderBillingTerms::saveData($dataInsert);

        $data['message'] = "Sales Quotation Saved";
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
        $response = SalesOrderBillingTerms::getDataFromId($id);

        $data['message'] = "Sales Quotation found";
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

        $response = SalesOrderBillingTerms::updateData($id,$updateData);

        $data['message'] = "Sales Quotation Updated";
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
        SalesOrderBillingTerms::destroy($id);

        $data['message'] = "Sales Quotation Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getSalesOrderBillingTermDetails($id)
    {
        $partyData = SalesOrderBillingTerms::query()->where(['salesOrderId' => $id])->oldest('srNo')->get();
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $partyData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteOldBillingTerms($id)
    {
        SalesOrderBillingTerms::deleteData(['salesOrderId' => $id]);

        $data['message'] = "Data Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    public function bulkInsertBillingTerm(Request $request): JsonResponse
    {
        $billingTerm = $request->billingTerm;
        $response = SalesOrderBillingTerms::query()->insert($billingTerm);

        $data['message'] = "Data added";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }
}
