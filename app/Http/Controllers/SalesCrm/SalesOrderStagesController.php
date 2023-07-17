<?php

namespace App\Http\Controllers\SalesCrm;

use App\Http\Controllers\Controller;
use App\Models\SalesCrm\SalesOrderStages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalesOrderStagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = SalesOrderStages::all();

        $data['status'] = 200;
        $data['message'] = 'Stages Found';
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
        $insertData = $request->all();

        $response = SalesOrderStages::saveData($insertData);
        $data['status'] = 200;
        $data['message'] = 'Stages Saved';
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
        $response = SalesOrderStages::getDataFromId($id);

        $data['status'] = 200;
        $data['message'] = 'Stages Found';
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
        $insertData = $request->all();

        $response = SalesOrderStages::updateData($id, $insertData);
        $data['status'] = 200;
        $data['message'] = 'Stages Updated';
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
        SalesOrderStages::destroy($id);

        $data['status'] = 200;
        $data['message'] = 'Stages Deleted';
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getSalesOrderStages($id)
    {
        $response = SalesOrderStages::getData(['salesOrderId' => $id]);

        $data['status'] = 200;
        $data['message'] = 'Stages Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
