<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Item\ItemMainSubGroupMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ItemMainSubGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = ItemMainSubGroupMaster::all();

        $data['message'] = "ItemMainSubGroupMaster Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return new JsonResponse($data, Response::HTTP_OK);
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
        $party_master = ItemMainSubGroupMaster::saveData($dataInsert);

        $data['message'] = "ItemMainSubGroupMaster Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = ItemMainSubGroupMaster::getDataFromId($id);

        $data['message'] = "ItemMainSubGroupMaster found";
        $data['status'] = 200;
        $data['data'] = $response;
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
        $updateData = $request->all();
        $response = ItemMainSubGroupMaster::updateData($id, $updateData);

        $data['message'] = "ItemMainSubGroupMaster Updated";
        $data['status'] = 200;
        $data['data'] = $response;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        ItemMainSubGroupMaster::destroy($id);

        $data['message'] = "Item Category Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    public function getAllItemMainSubGroup()
    {
        $fetchData = ItemMainSubGroupMaster::getData(['companyId' => 1]);
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->groupDescription;
            $response[$key]['value'] = $value->_id;
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
    public function checkItemMainSubGroupExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = ItemMainSubGroupMaster::checkExistsWithId($data['id'], ['groupDescription' => $data['groupDescription']]);

        }else{

            $exists = ItemMainSubGroupMaster::checkExists(['groupDescription' => $data['groupDescription']]);

        }

        $data['message'] = "Item Description Check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
