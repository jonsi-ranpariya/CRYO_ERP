<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\DocumentHeaderMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DocumentHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = DocumentHeaderMaster::all();

        $data['message'] = "Document Header List Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $fetchData = DocumentHeaderMaster::getDataFromId($id);

        $data['message'] = "Document Header Found";
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
        $res = DocumentHeaderMaster::saveData($dataInsert);

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
        $updateData = DocumentHeaderMaster::updateData($id, $request->all());

        $data['message'] = "Document Header Updated";
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
        DocumentHeaderMaster::destroy($id);

        $data['message'] = "Document Header Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSalesHeadersOptions(Request $request)
    {
        $fetchData = DocumentHeaderMaster::getData(['headerType' => $request->type]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->headerName;
            $response[$key]['value'] = $value->_id;
            $response[$key]['document'] = $value->header;
        }
        $data['message'] = "Document Header Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @return JsonResponse
     */
    public function getSalesEnquiryHeadersOptions(DocumentHeaderMaster $documentHeaderMaster)
    {
        $fetchData = $documentHeaderMaster->query()
            ->whereIn('headerType' , [1,2])
            ->get();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->headerName;
            $response[$key]['value'] = $value->_id;
            $response[$key]['document'] = $value->header;
        }
        $data['message'] = "Document Header Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getSalesOrderHeadersOptions(DocumentHeaderMaster $documentHeaderMaster)
    {
        $fetchData = $documentHeaderMaster->query()
            ->whereIn('headerType' , [1,3])
            ->get();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->headerName;
            $response[$key]['value'] = $value->_id;
            $response[$key]['document'] = $value->header;
        }
        $data['message'] = "Document Header Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkDocumentHeaderMasterExist(Request $request)
    {
        $data = $request->all();
        if(isset($data['id']) && !empty($data['id'])){

            $exists = DocumentHeaderMaster::checkExistsWithId($data['id'], ['headerName' => $data['headerName']]);

        }else{

            $exists = DocumentHeaderMaster::checkExists(['headerName' => $data['headerName']]);

        }

        $data['message'] = "Document Header Name check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
