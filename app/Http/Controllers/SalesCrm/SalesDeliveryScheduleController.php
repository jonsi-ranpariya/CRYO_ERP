<?php

namespace App\Http\Controllers\SalesCrm;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesCrm\SalesDeliveryScheduleStoreRequest;
use App\Models\SalesCrm\SalesDeliverySchedule;
use Illuminate\Http\Request;

class SalesDeliveryScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return null|object
     */
    public function index(): ?object
    {
        return SalesDeliverySchedule::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SalesDeliveryScheduleStoreRequest $request
     * @return null|object
     */
    public function store(SalesDeliveryScheduleStoreRequest $request): ?object
    {
        return SalesDeliverySchedule::saveData($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param SalesDeliverySchedule $salesDeliverySchedule
     * @return object|null
     */
    public function show(SalesDeliverySchedule $salesDeliverySchedule): ?object
    {
        return $salesDeliverySchedule;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param SalesDeliverySchedule $salesDeliverySchedule
     * @return mixed
     */
    public function update(Request $request, SalesDeliverySchedule $salesDeliverySchedule): mixed
    {
        $dataUpdate = $request->all();
        return $salesDeliverySchedule->updateData($dataUpdate['_id'], $dataUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SalesDeliverySchedule $salesDeliverySchedule
     * @return bool
     */
    public function destroy(SalesDeliverySchedule $salesDeliverySchedule): bool
    {
        return $salesDeliverySchedule->delete();
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getSalesOrderItemDelivery(string $id): mixed
    {
        return SalesDeliverySchedule::getData(['salesOrderItemId' => $id]);
    }
}
