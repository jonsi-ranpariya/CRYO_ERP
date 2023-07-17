<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\BillingTemplateItemsMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillingTemplateItemsMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = BillingTemplateItemsMaster::all();

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $response = BillingTemplateItemsMaster::saveData($dataInsert);

        $data['status'] = 200;
        $data['message'] = 'Data Saved';
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
        $response = BillingTemplateItemsMaster::getDataFromId($id);

        $data['status'] = 200;
        $data['message'] = 'Data Found';
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
        $dataUpdate = $request->all();
        $response = BillingTemplateItemsMaster::updateData($id, $dataUpdate);

        $data['status'] = 200;
        $data['message'] = 'Data Updated';
        $data['data'] = $response;
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
        BillingTemplateItemsMaster::destroy($id);

        $data['status'] = 200;
        $data['message'] = 'Data Deleted';
        $data['data'] = [];
        return jsonData($data);
    }
}
