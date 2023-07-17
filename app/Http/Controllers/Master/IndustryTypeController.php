<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\IndustryTypeMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndustryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = IndustryTypeMaster::all();

        $data['message'] = "Industries Type Master Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $res = IndustryTypeMaster::saveData($dataInsert);

        $data['message'] = "Industries Type Master Saved";
        $data['status'] = 200;
        $data['data'] = $res;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $updatedData = $request->all();
        $updateData = IndustryTypeMaster::updateData($id, $updatedData);
        $data['message'] = "Lead Title Master Updated";
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
        IndustryTypeMaster::destroy($id);
        $data['message'] = "Quotation Type Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    public function getAllIndustryType(){
        $fetchData = IndustryTypeMaster::getData(['companyId' => 1]);
        foreach ($fetchData as $key=>$value){
            $response[$key]['label'] = $value->industryType;
            $response[$key]['value'] = $value->_id;
        }
        $data['message'] = "Category Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkIndustrialTypeMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = IndustryTypeMaster::checkExistsWithId($data['id'], ['industryType' => $data['industryType']]);

        }else{

            $exists = IndustryTypeMaster::checkExists(['industryType' => $data['industryType']]);

        }

        $data['message'] = "Industries Type check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
