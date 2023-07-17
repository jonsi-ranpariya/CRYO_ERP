<?php

namespace App\Http\Controllers\SalesCrm;

use App\Http\Controllers\Controller;
use App\Models\SalesCrm\SrBillingTerms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SrBillingTermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $fetchData = SrBillingTerms::all();

        $data['message'] = "Sales Order Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $dataInsert = $request->all();
        $party_master = SrBillingTerms::saveData($dataInsert);

        $data['message'] = "Billing Terms Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $response = SrBillingTerms::getDataFromId($id);

        $data['message'] = "Billing Terms found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $updateData = $request->all();
        $response = SrBillingTerms::updateData($id, $updateData);

        $data['message'] = "Billing Terms Updated";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        SrBillingTerms::destroy($id);

        $data['message'] = "Billing Terms Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getSRBillingTermDetails($id): JsonResponse
    {
        $partyData = SrBillingTerms::query()->where('salesReturnId', $id)->oldest('srNo')->get();
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $partyData;
        return jsonData($data);
    }

    public function deleteBillingTerms($id): JsonResponse
    {
        SrBillingTerms::deleteData(['salesReturnId' => $id]);

        $data['message'] = "Data Found";
        $data['status'] = 200;
        return jsonData($data);
    }
}
