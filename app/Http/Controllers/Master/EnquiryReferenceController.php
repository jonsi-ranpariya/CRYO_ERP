<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\EnquiryReferenceMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnquiryReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = EnquiryReferenceMaster::all();

        $data['message'] = "Enquiry Reference Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data, Response::HTTP_OK);
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
        $res = EnquiryReferenceMaster::saveData($dataInsert);

        $data['message'] = "Enquiry Reference Saved";
        $data['status'] = 200;
        $data['data'] = $res;
        return jsonData($data, Response::HTTP_OK);
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
        $updateData = EnquiryReferenceMaster::updateData($id, $request->all());

        $data['message'] = "Enquiry Reference Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        EnquiryReferenceMaster::destroy($id);

        $data['message'] = "Enquiry Reference Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getAllEnqRefMaster(){
        $fetchData = EnquiryReferenceMaster::getData(['companyId' => 1]);
        foreach ($fetchData as $key=>$value){
            $responce[$key]['label'] = $value->enquiryReferenceName;
            $responce[$key]['value'] = $value->_id;
        }
        $data['message'] = "Category Found";
        $data['status'] = 200;
        $data['data'] = $responce ?? [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkEnquiryReferenceMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = EnquiryReferenceMaster::checkExistsWithId($data['id'], ['enquiryReferenceName' => $data['enquiryReferenceName']]);

        }else{

            $exists = EnquiryReferenceMaster::checkExists(['enquiryReferenceName' => $data['enquiryReferenceName']]);

        }

        $data['message'] = "Enquiry Reference check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
