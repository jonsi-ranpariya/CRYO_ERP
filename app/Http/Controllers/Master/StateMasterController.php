<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\StateMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StateMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = StateMaster::all();

        $data['message'] = "State Found";
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
        $party_master = StateMaster::saveData($dataInsert);

        $data['message'] = "State Saved";
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
        $response = StateMaster::getDataFromId($id);

        $data['message'] = "State found";
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
        $updateData = StateMaster::updateData($id, $request->all());

        $data['message'] = "State Updated";
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
        StateMaster::destroy($id);

        $data['message'] = "State Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    public function getStates()
    {
        $fetchData = StateMaster::getData(['companyId' => 1]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->state;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "State Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    public function getStatesByCountry(Request $request)
    {
        $fetchData = StateMaster::getData(['companyId' => 1, 'country' => $request->country_id]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->state;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "State Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkStateMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = StateMaster::checkExistsWithId($data['id'], ['state' => $data['state']]);

        }else{

            $exists = StateMaster::checkExists(['state' => $data['state']]);

        }

        $data['message'] = "State check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
