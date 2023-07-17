<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\QuotationTypeMaster;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuotationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = QuotationTypeMaster::all();

        $data['message'] = "Quotation Type Found";
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $res = QuotationTypeMaster::saveData($dataInsert);

        $data['message'] = "Quotation Type Saved";
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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $updateData = QuotationTypeMaster::updateData($id, $request->all());

        $data['message'] = "Quotation Type Updated";
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
        QuotationTypeMaster::destroyData($id);

        $data['message'] = "Quotation Type Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getQuotationOption()
    {
        $fetchData = QuotationTypeMaster::getData(['companyId' => 1]);
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->description;
            $response[$key]['value'] = $value->_id;
        }
        $data['message'] = "Quotation Type Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkQuotationMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = QuotationTypeMaster::checkExistsWithId($data['id'], ['description' => $data['description']]);

        }else{

            $exists = QuotationTypeMaster::checkExists(['description' => $data['description']]);

        }

        $data['message'] = "Quotation check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
