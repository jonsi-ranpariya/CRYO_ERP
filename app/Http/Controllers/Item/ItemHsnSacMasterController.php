<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Item\ItemHsnSacMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ItemHsnSacMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = ItemHsnSacMaster::all();

        $data['message'] = "ItemHsnSacMaster Found";
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
        $party_master = ItemHsnSacMaster::saveData($dataInsert);

        $data['message'] = "ItemHsnSacMaster Saved";
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
        $response = ItemHsnSacMaster::getDataFromId($id);

        $data['message'] = "ItemHsnSacMaster found";
        $data['status'] = 200;
        $data['data'] = $response;
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
        $updateData = ItemHsnSacMaster::updateData($id, $request->all());

        $data['message'] = "ItemHsnSacMaster Updated";
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
        ItemHsnSacMaster::destroy($id);

        $data['message'] = "Item Category Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    public function getAllItemHsnSacMaster(){
        $fetchData = ItemHsnSacMaster::getData(['companyId' => 1]);
        foreach ($fetchData as $key=>$value){
            $response[$key]['label'] =  $value->codeDescription .' ('.$value->codeNo.')';
            $response[$key]['value'] = $value->_id;
            $response[$key]['codeNo'] = $value->codeNo;
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
    public function checkItemHSNCodeExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = ItemHsnSacMaster::checkExistsWithId($data['id'], ['codeNo' => $data['codeNo']]);

        }else{

            $exists = ItemHsnSacMaster::checkExists(['codeNo' => $data['codeNo']]);

        }


        $data['message'] = "Item Code Check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
