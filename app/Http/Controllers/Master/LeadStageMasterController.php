<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\LeadStageMaster;
use App\Models\Master\QuotationTypeMaster;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LeadStageMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = LeadStageMaster::all();

        $data['message'] = "Lead Stage Master Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data, Response::HTTP_OK);
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
        $res = LeadStageMaster::saveData($dataInsert);

        $data['message'] = "Lead Stage Master Saved";
        $data['status'] = 200;
        $data['data'] = $res;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $updateData = LeadStageMaster::updateData($id, $request->all());

        $data['message'] = "Lead Stage Master Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        LeadStageMaster::destroyData($id);

        $data['message'] = "Lead Stage Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getAllLeadStage()
    {
        $fetchData = LeadStageMaster::getData(['companyId' => 1]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->leadStage;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Category Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function LeadStageByStageTypeMaster(Request $request)
    {
        $fetchData = LeadStageMaster::getData(['companyId' => 1, 'stageType' => $request->stage_type]);
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->leadStage;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "State Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }


}
