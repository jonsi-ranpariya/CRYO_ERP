<?php

namespace App\Http\Controllers\SalesCrm;

use App\Http\Controllers\Controller;
use App\Models\SalesCrm\SalesOrderChecklist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalesOrderChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = SalesOrderChecklist::all();

        $data['status'] = 200;
        $data['message'] = 'Checklist Found';
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
        $dataInsert = $request->all();
        $response = SalesOrderChecklist::saveData($dataInsert);

        $data['status'] = 200;
        $data['message'] = 'Checklist Saved';
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
        $response = SalesOrderChecklist::getDataFromId($id);

        $data['status'] = 200;
        $data['message'] = 'Checklist Found';
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
        $dataInsert = $request->all();
        $response = SalesOrderChecklist::updateData($id, $dataInsert);

        $data['status'] = 200;
        $data['message'] = 'Checklist Updated';
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
        SalesOrderChecklist::destroy($id);

        $data['status'] = 200;
        $data['message'] = 'Checklist Deleted';
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getSalesOrderChecklist($id)
    {
        $response = SalesOrderChecklist::getData(['salesOrderId' => $id]);

        $data['status'] = 200;
        $data['message'] = 'Checklist Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
