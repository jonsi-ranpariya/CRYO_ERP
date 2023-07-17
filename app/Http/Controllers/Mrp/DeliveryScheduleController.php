<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use App\Models\Mrp\DeliverySchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = DeliverySchedule::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $dataInsert = $request->all();
        $response = DeliverySchedule::saveData($dataInsert);

        $data['message'] = 'Data saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param DeliverySchedule $deliverySchedule
     * @return JsonResponse
     */
    public function show(DeliverySchedule $deliverySchedule): JsonResponse
    {
        $data['message'] = 'Data found';
        $data['data'] = $deliverySchedule;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param DeliverySchedule $deliverySchedule
     * @return JsonResponse
     */
    public function update(Request $request, DeliverySchedule $deliverySchedule): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $deliverySchedule->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data update';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @param DeliverySchedule $deliverySchedule
     * @return JsonResponse
     */
    public function destroy(string $id, DeliverySchedule $deliverySchedule): JsonResponse
    {
        $data['message'] = 'Data deleted';
        $data['data'] = $deliverySchedule->destroyData($id);
        return jsonData($data);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getDeliveryScheduleList(string $id): JsonResponse
    {
        $data['message'] = 'data found';
        $data['data'] = DeliverySchedule::getData(['manualPlanningId' => $id]);
        return jsonData($data);
    }
}
