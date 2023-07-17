<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Item\ItemGroupMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ItemGroupMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = ItemGroupMaster::all();

        $data['message'] = "ItemGroupMaster Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data, Response::HTTP_OK);
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
        $party_master = ItemGroupMaster::saveData($dataInsert);

        $data['message'] = "ItemGroupMaster Saved";
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
        $responce = ItemGroupMaster::getDataFromId($id);

        $data['message'] = "ItemGroupMaster found";
        $data['status'] = 200;
        $data['data'] = $responce;
        return jsonData($data, Response::HTTP_OK);
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
        $updateData = ItemGroupMaster::updateData($id, $request->all());

        $data['message'] = "ItemGroupMaster Updated";
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
        ItemGroupMaster::destroyData($id);

        $data['message'] = "Item Category Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    public function getAllItemGroupMaster()
    {
        $fetchData = ItemGroupMaster::getData(['companyId' => 1]);
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->groupDescription . "(" . $value->groupCode . ")";
            $response[$key]['value'] = $value->_id;
            $response[$key]['groupCode'] = $value->groupCode;
        }
        $data['message'] = "Category Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkItemGroupMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = ItemGroupMaster::checkExistsWithId($data['id'], ['groupCode' => $data['groupCode']]);

        }else{

            $exists = ItemGroupMaster::checkExists(['groupCode' => $data['groupCode']]);

        }


        $data['message'] = "Item Description Check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
