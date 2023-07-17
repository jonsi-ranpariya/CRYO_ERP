<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\IndustryTypeMaster;
use App\Models\Master\PackingMaster;
use App\Models\Master\PaymentDeductionMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PaymentDeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = PaymentDeductionMaster::all();

        $data['message'] = "Deduction Found";
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
        $party_master = PaymentDeductionMaster::saveData($dataInsert);

        $data['message'] = "Deduction Saved";
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
        $responce = PaymentDeductionMaster::getDataFromId($id);

        $data['message'] = "Deduction found";
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
        $updateData = PaymentDeductionMaster::updateData($id, $request->all());

        $data['message'] = "Deduction Updated";
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
        PaymentDeductionMaster::destroyData($id);

        $data['message'] = "Deduction Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkPaymentDeductionMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = PaymentDeductionMaster::checkExistsWithId($data['id'], ['deductionDesc' => $data['deductionDesc']]);

        }else{

            $exists = PaymentDeductionMaster::checkExists(['deductionDesc' => $data['deductionDesc']]);

        }

        $data['message'] = "Deduction Description check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
