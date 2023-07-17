<?php

namespace App\Http\Controllers\SalesCrm;

use App\Http\Controllers\Controller;
use App\Models\SalesCrm\SalesOrderAgent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalesOrderAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = SalesOrderAgent::all();

        $data['status'] = 200;
        $data['message'] = 'Agents Found';
        $data['data'] = $response;
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
        $insertData = $request->all();

        $response = SalesOrderAgent::saveData($insertData);
        $data['status'] = 200;
        $data['message'] = 'Agents Created';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = SalesOrderAgent::getDataFromId($id);

        $data['status'] = 200;
        $data['message'] = 'Agents Found';
        $data['data'] = $response;
        return jsonData($data);
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

        $response = SalesOrderAgent::updateData($id, $updateData);
        $data['status'] = 200;
        $data['message'] = 'Agents Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        SalesOrderAgent::destroy($id);

        $data['status'] = 200;
        $data['message'] = 'Agents Deleted';
        $data['data'] = [];
        return jsonData($data);
    }

    public function getSalesOrderAgents($id)
    {
        $response = SalesOrderAgent::getData(['salesOrderId' => $id]);

        $data['status'] = 200;
        $data['message'] = 'Agents Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
