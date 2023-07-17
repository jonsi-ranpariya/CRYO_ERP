<?php

namespace App\Http\Controllers\Partymaster;

use App\Http\Controllers\Controller;
use App\Models\Partymaster\DeliveryAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = DeliveryAddress::all();

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $fetchData;
        return jsonData($res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $response = DeliveryAddress::saveData($data);

        $res['status'] = 200;
        $res['message'] = 'Data saved';
        $res['data'] = $response;
        return jsonData($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $fetchData = DeliveryAddress::getDataFromId($id);

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $fetchData;
        return jsonData($res);
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
        $data = $request->all();
        $response = DeliveryAddress::updateData($id, $data);

        $res['status'] = 200;
        $res['message'] = 'Data updated';
        $res['data'] = $response;
        return jsonData($res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        DeliveryAddress::destroy($id);

        $res['status'] = 200;
        $res['message'] = 'Data updated';
        $res['data'] = [];
        return jsonData($res);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getPartyWiseDeliveryAddress($id)
    {
        $fetchData = DeliveryAddress::getData(['partyId' => $id, 'companyId' => 1]);

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $fetchData;
        return jsonData($res);
    }
}
