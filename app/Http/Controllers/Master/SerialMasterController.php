<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\SerialMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SerialMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = SerialMaster::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $dataInsert = $request->all();
        $response = SerialMaster::saveData($dataInsert);

        $data['message'] = 'Data saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  SerialMaster  $serialMaster
     * @return JsonResponse
     */
    public function show(SerialMaster $serialMaster): JsonResponse
    {
        $data['message'] = 'Data found';
        $data['data'] = $serialMaster;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  SerialMaster  $serialMaster
     * @return JsonResponse
     */
    public function update(Request $request, SerialMaster $serialMaster): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $serialMaster->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SerialMaster  $serialMaster
     * @return JsonResponse
     */
    public function destroy(SerialMaster $serialMaster): JsonResponse
    {
        $data['message'] = 'Data deleted';
        $data['data'] = $serialMaster->delete();
        return jsonData($data);
    }
}
