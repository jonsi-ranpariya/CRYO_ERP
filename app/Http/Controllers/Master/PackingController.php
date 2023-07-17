<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\PackingMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = PackingMaster::all();

        $data['message'] = "Packing Found";
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
        $party_master = PackingMaster::saveData($dataInsert);

        $data['message'] = "Packing Saved";
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
        $responce = PackingMaster::getDataFromId($id);

        $data['message'] = "Packing found";
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
        $updateData = PackingMaster::updateData($id, $request->all());

        $data['message'] = "Packing Updated";
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
        PackingMaster::destroyData($id);

        $data['message'] = "Packing Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkPackingMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = PackingMaster::checkExistsWithId($data['id'], ['packingDesc' => $data['packingDesc']]);

        }else{

            $exists = PackingMaster::checkExists(['packingDesc' => $data['packingDesc']]);

        }

        $data['message'] = "Packaing Description check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
