<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\BusinessTypeMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BusinessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = BusinessTypeMaster::all();

        $data['message'] = "Business Type Found";
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
        $party_master = BusinessTypeMaster::saveData($dataInsert);

        $data['message'] = "Business Type Saved";
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
        $responce = BusinessTypeMaster::getDataFromId($id);

        $data['message'] = "Business Type found";
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
        $updateData = BusinessTypeMaster::updateData($id, $request->all());

        $data['message'] = "Business Type Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return jsonResponse
     */
    public function destroy($id)
    {
        BusinessTypeMaster::destroyData($id);

        $data['message'] = "Business Type Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getPartyBusinessTypeOptions()
    {
        $fetchData = BusinessTypeMaster::getData();

        foreach ($fetchData as $key => $value){
            $response[$key]['label'] = $value->businessType;
            $response[$key]['value'] = $value->_id;
        }

        $data['status'] = 200;
        $data['message'] = "Party Business Types Found";
        $data['data'] = $response ?? [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkBusinessTypeExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = BusinessTypeMaster::checkExistsWithId($data['id'], ['businessType' => $data['businessType']]);

        }else{

            $exists = BusinessTypeMaster::checkExists(['businessType' => $data['businessType']]);

        }

        $data['message'] = "Item business Type Check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
