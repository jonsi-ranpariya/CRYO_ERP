<?php

namespace App\Http\Controllers\SalesCrm;

use App\Http\Controllers\Controller;
use App\Models\SalesCrm\SalesHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalesHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = SalesHistory::all();
        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $fetchData;
        return jsonData($res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $response = SalesHistory::saveData($data);
        $res['status'] = 200;
        $res['message'] = 'Data Inserted';
        $res['data'] = $response;
        return jsonData($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $fetchData = SalesHistory::getDataFromId($id);
        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $fetchData;
        return jsonData($res);
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
        $data = $request->all();
        $response = SalesHistory::updateData($id, $data);
        $res['status'] = 200;
        $res['message'] = 'Data Updated';
        $res['data'] = $response;
        return jsonData($res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        SalesHistory::destroy($id);
        $res['status'] = 200;
        $res['message'] = 'Data Deleted';
        $res['data'] = [];
        return jsonData($res);
    }

    public function getHistorySalesIqWise($id)
    {
        $fetchData = SalesHistory::getRelationData(['salesIqID' => $id],['user:_id,first_name,last_name']);
        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $fetchData;
        return jsonData($res);
    }
}
