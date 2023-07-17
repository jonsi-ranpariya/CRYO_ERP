<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\CityMaster;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CityMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = CityMaster::all();

        $data['message'] = "City Found";
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
        $party_master = CityMaster::saveData($request->all());

        $data['message'] = "City Saved";
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
        $response = CityMaster::getDataFromId($id);

        $data['message'] = "City found";
        $data['status'] = 200;
        $data['data'] = $response;
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
        $updateData = CityMaster::updateData($id, $request->all());

        $data['message'] = "City Updated";
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
        CityMaster::destroyData($id);

        $data['message'] = "City Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    public function getCities()
    {
        $fetchData = CityMaster::getData(['companyId' => 1]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->city;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "City Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);


    }

    /**
     * @return JsonResponse
     */
    public function getCityOptions()
    {
        $fetchData = CityMaster::getData(['companyId' => 1]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->city;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "City Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCityByState(Request $request)
    {
        $stateId = $request->state_id;
        $fetchData = CityMaster::getData(['companyId' => 1, 'state' => $stateId]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->city;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "City Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkCityMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = CityMaster::checkExistsWithId($data['id'], ['city' => $data['city']]);

        }else{

            $exists = CityMaster::checkExists(['city' => $data['city']]);

        }

        $data['message'] = "City Name check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
