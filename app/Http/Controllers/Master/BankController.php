<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\BankMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = BankMaster::all();

        $data['message'] = "BankMaster Found";
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
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $party_master = BankMaster::saveData($request->all());

        $data['message'] = "BankMaster Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $responce = BankMaster::getDataFromId($id);

        $data['message'] = "BankMaster found";
        $data['status'] = 200;
        $data['data'] = $responce;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $updateData = BankMaster::updateData($id, $request->all());

        $data['message'] = "BankMaster Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        BankMaster::destroyData($id);

        $data['message'] = "BankMaster Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkBankMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = BankMaster::checkExistsWithId($data['id'], ['bankName' => $data['bankName']]);

        }else{

            $exists = BankMaster::checkExists(['bankName' => $data['bankName']]);

        }

        $data['message'] = "Bank Name check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
