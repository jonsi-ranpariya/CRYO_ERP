<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\IndustryTypeMaster;
use App\Models\Master\ReasonMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = ReasonMaster::all();

        $data['message'] = "Reason Type List Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return new JsonResponse($data, Response::HTTP_OK);
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
        $res = ReasonMaster::saveData($dataInsert);

        $data['message'] = "Reason Type Saved";
        $data['status'] = 200;
        $data['data'] = $res;
        return new JsonResponse($data, Response::HTTP_OK);
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
        $updateData = ReasonMaster::updateData($id, $request->all());

        $data['message'] = "Quotation Type Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        ReasonMaster::destroy($id);

        $data['message'] = "Reason Type Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getQuotationReasonMaster()
    {
        $fetchData = ReasonMaster::getData(['reasonType' => 1]);

        foreach ($fetchData as $key => $value){
            $response[$key]['label'] = $value->reason;
            $response[$key]['value'] = $value->_id;
        }

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $response ?? [];
        return jsonData($res);
    }

//    /**
//     * @param $name
//     * @return JsonResponse
//     */
//    public function checkReasonMasterExist($name)
//    {
//        $exists = ReasonMaster::checkExists(['reason' => $name]);
//
//        $data['status'] = 200;
//        $data['message'] = 'Reason check';
//        $data['data'] = $exists;
//        return jsonData($data, Response::HTTP_OK);
//    }
}
