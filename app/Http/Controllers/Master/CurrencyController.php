<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\CurrencyMaster;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = CurrencyMaster::all();

        $data['message'] = "Currency Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return new JsonResponse($data, Response::HTTP_OK);
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
        $dataInsert = $request->all();
        $party_master = CurrencyMaster::saveData($dataInsert);

        $data['message'] = "Currency Saved";
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
        $responce = CurrencyMaster::getDataFromId($id);

        $data['message'] = "Currency found";
        $data['status'] = 200;
        $data['data'] = $responce;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $updateData = CurrencyMaster::updateData($id, $request->all());

        $data['message'] = "Currency Updated";
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
        CurrencyMaster::destroy($id);

        $data['message'] = "Currency Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getCurrencies()
    {
        $fetchData = CurrencyMaster::getData(['companyId' => 1]);
        foreach ($fetchData as $key => $value){
            $response[$key]['label'] = $value->currencyCode;
            $response[$key]['value'] = $value->_id;
            $response[$key]['rate'] = $value->currencyRate;
        }

        $data['message'] = "Currency Deleted";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkCurrencyMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = CurrencyMaster::checkExistsWithId($data['id'], ['currencyCode' => $data['currencyCode']]);

        }else{

            $exists = CurrencyMaster::checkExists(['currencyCode' => $data['currencyCode']]);

        }

        $data['message'] = "Currency check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }

}
