<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\BillingMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillingMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = BillingMaster::all();

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
        $response = BillingMaster::saveData($data);

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
        $fetchData = BillingMaster::getDataFromId($id);

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
        $response = BillingMaster::updateData($id, $data);

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
        BillingMaster::destroy($id);

        $res['status'] = 200;
        $res['message'] = 'Data Deleted';
        $res['data'] = [];
        return jsonData($res);
    }

    /**
     * @return JsonResponse
     */
    public function getBillingMasterOptions()
    {
        $fetchData = BillingMaster::getData(['companyId' => 1]);
        foreach ($fetchData as $key => $value){
            $response[$key]['label'] = $value->name;
            $response[$key]['value'] = $value->_id;
            $response[$key]['type'] = $value->valueType;
            $response[$key]['defaultValue'] = $value->defaultValue;
        }

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $response ?? [];
        return jsonData($res);
    }

    public function getBillingOptions()
    {
        $fetchData = BillingMaster::getData(['companyId' => 1]);

        foreach ($fetchData as $key => $item) {
            $response[$key]['label'] = $item->calCode;
            $response[$key]['value'] = $item->_id;
        }

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $response ?? [];
        return jsonData($res);
    }
}
