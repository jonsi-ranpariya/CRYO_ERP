<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\CurrencyMaster;
use App\Models\Master\DepartmentMaster;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return jsonResponse
     */
    public function index()
    {
        $fetchData = DepartmentMaster::all();

        $data['message'] = "Department Found";
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
        $party_master = DepartmentMaster::saveData($dataInsert);

        $data['message'] = "Department Saved";
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
        $responce = DepartmentMaster::getDataFromId($id);

        $data['message'] = "Department found";
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
        $updateData = DepartmentMaster::updateData($id, $request->all());

        $data['message'] = "Department Updated";
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
        DepartmentMaster::destroyData($id);

        $data['message'] = "Department Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getDepartment()
    {
        $fetchData = DepartmentMaster::all();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->department;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Department Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkDepartmentMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = DepartmentMaster::checkExistsWithId($data['id'], ['department' => $data['department']]);

        }else{

            $exists = DepartmentMaster::checkExists(['department' => $data['department']]);

        }

        $data['message'] = "Department check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
