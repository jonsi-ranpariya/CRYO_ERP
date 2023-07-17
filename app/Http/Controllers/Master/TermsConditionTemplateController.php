<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\TermsConditionTemplateMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;

class TermsConditionTemplateController extends Controller
{
//    private $statusActive = 1;
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = TermsConditionTemplateMaster::all();

        $data['message'] = "TermsConditionTemplateMaster Found";
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
        $party_master = TermsConditionTemplateMaster::saveData($dataInsert);

        $data['message'] = "TermsConditionTemplateMaster Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $responce = TermsConditionTemplateMaster::getDataFromId($id);
//        dd($responce->toArray());

        $data['message'] = "TermsConditionTemplateMaster found";
        $data['status'] = 200;
        $data['data'] = $responce;
        return new JsonResponse($data, Response::HTTP_OK);
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
        $response = TermsConditionTemplateMaster::updateData($id, $dataUpdate);

        $data['status'] = 200;
        $data['message'] = 'Data Updated';
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
        TermsConditionTemplateMaster::destroy($id);

        $data['message'] = "Item Category Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return new JsonResponse($data, Response::HTTP_OK);
    }


//    public function getTermsTemplateMasterOptions()
//    {
//        $fechData = TermsConditionTemplateMaster::getData(['companyId' => 1,'status' => $this->statusActive]);
//
//        foreach ($fechData as $key => $value) {
//            $response[$key]['label'] = $value->templateName;
//            $response[$key]['value'] = $value->_id;
//        }
//
//        $data['status'] = 200;
//        $data['message'] = 'Data Found';
//        $data['data'] = $response?? [];
//        return jsonData($data);
//    }
}
