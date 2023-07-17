<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\ItemMake;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ItemMakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = ItemMake::all();

        $data['message'] = "Item Make Master Found";
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
        $party_master = ItemMake::saveData($dataInsert);

        $data['message'] = "Item Make Master Saved";
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
        $response = ItemMake::getDataFromId($id);

        $data['message'] = "Item Make Master found";
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
        $updateData = ItemMake::updateData($id, $request->all());

        $data['message'] = "Item Make Master Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
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
        ItemMake::destroy($id);

        $data['message'] = "Item Make Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    public function getItemMakeOptions()
    {
        $fetchData = ItemMake::all();
        foreach ($fetchData as $key => $value){
            $response[$key]['label'] = $value->makeName;
            $response[$key]['value'] = $value->_id;
        }
        return new JsonResponse(['data' => $response ?? []], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkItemMakeExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = ItemMake::checkExistsWithId($data['id'], ['makeName' => $data['makeName']]);

        }else{

            $exists = ItemMake::checkExists(['makeName' => $data['makeName']]);

        }


        $data['message'] = "Item make Check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
