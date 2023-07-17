<?php

namespace App\Http\Controllers\QualityControl;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseOrder;
use App\Models\Purchase\PurchaseOrderBillingTerm;
use App\Models\Purchase\PurchaseOrderItem;
use App\Models\Purchase\PurchaseOrderPoHistory;
use App\Models\Purchase\PurchaseOrderShowAmdDetail;
use App\Models\Purchase\PurchaseOrderTermCondition;
use App\Models\QualityControl\InwardQualityControl;
use App\Models\QualityControl\InwardQualityControlItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InwardQualityControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $response = InwardQualityControl::all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param InwardQualityControl $inwardQualityControl
     * @param Request  $request
     * @return JsonResponse
     */
    public function store(Request $request, InwardQualityControl $inwardQualityControl): JsonResponse
    {
        $dataInsert = $request->all();
        $response = $inwardQualityControl->saveData($dataInsert);

        $data['message'] = 'Data saved';
        $data['data'] = $response;
        return jsonData($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  InwardQualityControl  $inwardQualityControl
     * @return JsonResponse
     */
    public function show(InwardQualityControl $inwardQualityControl): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $inwardQualityControl;
        return jsonData($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param  InwardQualityControl  $inwardQualityControl
     * @return JsonResponse
     */
    public function update(Request $request, InwardQualityControl $inwardQualityControl): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $inwardQualityControl->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        InwardQualityControl::destroyData($id);
        InwardQualityControlItem::deleteData(['inwardQcId' => $id]);

        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }

}
