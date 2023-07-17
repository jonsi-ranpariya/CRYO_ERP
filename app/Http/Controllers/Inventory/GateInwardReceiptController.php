<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\GateInwardReceipt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GateInwardReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = GateInwardReceipt::query()->with('purchaseOrderDetail')->get();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param GateInwardReceipt $gateInwardReceipt
     * @return JsonResponse
     */
    public function store(Request $request, GateInwardReceipt $gateInwardReceipt)
    {
        $dataInsert = $request->all();
//        $number = date('yy');
        $dataInsert['girNo'] = generateCodes(new GateInwardReceipt(), 'GI22230000001','girNo','GI');
        $response = GateInwardReceipt::saveData($dataInsert);

        $data['message'] = 'Data saved';
        $data['data'] = $response;
        return jsonData($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  GateInwardReceipt  $gateInwardReceipt
     * @return JsonResponse
     */
    public function show(GateInwardReceipt $gateInwardReceipt)
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $gateInwardReceipt;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param GateInwardReceipt $gateInwardReceipt
     * @return JsonResponse
     */
    public function update(Request $request, GateInwardReceipt $gateInwardReceipt)
    {
        $dataUpdate = $request->all();
        $response = $gateInwardReceipt->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        GateInwardReceipt::destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        return jsonData($data);
    }

    public function getGirPartyWise(string $paryId)
    {
        $response = GateInwardReceipt::query()->where('partyId', $paryId)->get();

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
