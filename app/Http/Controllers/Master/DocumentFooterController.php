<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\DocumentFooterMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DocumentFooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = DocumentFooterMaster::all();

        $data['message'] = "Document Footer List Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    public function show($id)
    {
        $fetchData = DocumentFooterMaster::getDataFromId($id);

        $data['message'] = "Document Footer Found";
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
        $res = DocumentFooterMaster::saveData($dataInsert);

        $data['message'] = "Document Header Saved";
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
        $updateData = DocumentFooterMaster::updateData($id, $request->all());

        $data['message'] = "Document Footer Updated";
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
        DocumentFooterMaster::destroy($id);

        $data['message'] = "Document Footer Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSalesFootersOptions(Request $request)
    {
        $fetchData = DocumentFooterMaster::getData(['footerType' => $request->type]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->footerName;
            $response[$key]['value'] = $value->_id;
            $response[$key]['document'] = $value->footer;
        }
        $data['message'] = "Document Footer Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSalesEnquiryFootersOptions(DocumentFooterMaster $documentFooterMaster)
    {
        $fetchData = $documentFooterMaster->query()
            ->whereIn('footerType' , [1,2])
            ->get();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->footerName;
            $response[$key]['value'] = $value->_id;
            $response[$key]['document'] = $value->footer;
        }
        $data['message'] = "Document Footer Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getSalesOrderFootersOptions(DocumentFooterMaster $documentFooterMaster)
    {
        $fetchData = $documentFooterMaster->query()
            ->whereIn('footerType' , [1,3])
            ->get();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->footerName;
            $response[$key]['value'] = $value->_id;
            $response[$key]['document'] = $value->footer;
        }
        $data['message'] = "Document Footer Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkDocumentFooterMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = DocumentFooterMaster::checkExistsWithId($data['id'], ['footerName' => $data['footerName']]);

        }else{

            $exists = DocumentFooterMaster::checkExists(['footerName' => $data['footerName']]);

        }

        $data['message'] = "Document Footer Name check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
