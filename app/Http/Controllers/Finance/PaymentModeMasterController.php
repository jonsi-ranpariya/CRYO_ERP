<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\PaymentModeMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PaymentModeMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = PaymentModeMaster::all();

        $data['message'] = "PaymentModeMaster Found";
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
        $party_master = PaymentModeMaster::saveData($dataInsert);

        $data['message'] = "PaymentModeMaster Saved";
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
        $responce = PaymentModeMaster::getDataFromId($id);

        $data['message'] = "PaymentModeMaster found";
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
        $updateData = PaymentModeMaster::updateData($id, $request->all());

        $data['message'] = "PaymentModeMaster Updated";
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
        PaymentModeMaster::destroyData($id);

        $data['message'] = "Payment Mode Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    public function getAllPaymentMode()
    {
        $fetchData = PaymentModeMaster::getData(['companyId' => 1]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->paymentMode;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Payment Mode Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }
}
