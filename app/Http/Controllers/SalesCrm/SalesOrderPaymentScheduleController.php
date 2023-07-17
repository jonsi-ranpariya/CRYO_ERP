<?php

namespace App\Http\Controllers\SalesCrm;

use App\Actions\Sales\SalesOrderPaymentCalculationAction;
use App\Http\Controllers\Controller;
use App\Models\SalesCrm\SalesOrderPaymentSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalesOrderPaymentScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = SalesOrderPaymentSchedule::all();

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $insertData = $request->all();
        $response = SalesOrderPaymentSchedule::saveData($insertData);

        $data['status'] = 200;
        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = SalesOrderPaymentSchedule::getDataFromId($id);

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
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
        $updateData = $request->all();
        $response = SalesOrderPaymentSchedule::updateData($id, $updateData);

        $data['status'] = 200;
        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        SalesOrderPaymentSchedule::destroy($id);

        $data['status'] = 200;
        $data['message'] = 'Data Deleted';
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getSalesOrderPaymentSchedule($id)
    {
        $response = SalesOrderPaymentSchedule::getData(['salesOrderId' => $id]);

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getSalesOrderItemsTotalAmount($id)
    {
        $response = SalesOrderPaymentCalculationAction::run($id);

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
