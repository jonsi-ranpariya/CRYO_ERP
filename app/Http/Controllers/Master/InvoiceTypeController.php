<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\InvoiceTypeMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = InvoiceTypeMaster::all();

        $data['message'] = "Invoice Type Found";
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

        $party_master = InvoiceTypeMaster::saveData($dataInsert);

        $data['message'] = "Invoice Type Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $responce = InvoiceTypeMaster::getDataFromId($id);

        $data['message'] = "Invoice Type found";
        $data['status'] = 200;
        $data['data'] = $responce;
        return jsonData($data, Response::HTTP_OK);
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
        $updateData = $request->all();

        $updateData = InvoiceTypeMaster::updateData($id, $updateData);

        $data['message'] = "Invoice Type Updated";
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
        InvoiceTypeMaster::destroyData($id);

        $data['message'] = "Invoice Type Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getAllInvoiceTypeMaster()
    {

        $fetchData = InvoiceTypeMaster::getData(['companyId' => 1]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->description;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Branch Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param $name
     * @return JsonResponse
     */
    public function checkPrefixExist($name)
    {
        $exists = InvoiceTypeMaster::checkExists(['prefix' => $name]);

        $data['status'] = 200;
        $data['message'] = 'Prefix Name check';
        $data['data'] = $exists;
        return jsonData($data, Response::HTTP_OK);
    }
}
