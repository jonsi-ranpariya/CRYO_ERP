<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Actions\ProductionPlanning\WoRequisitionStoreAction;
use App\Http\Controllers\Controller;
use App\Models\ProductionPlanning\WoRequisition;
use App\Models\ProductionPlanning\WoRequisitionItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WoRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param WoRequisition $woRequisition
     * @return JsonResponse
     */
    public function index(WoRequisition $woRequisition): JsonResponse
    {
        $response = $woRequisition->all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param WoRequisitionStoreAction $woRequisitionAction
     * @return JsonResponse
     */
    public function store(Request $request, WoRequisitionStoreAction $woRequisitionAction): JsonResponse
    {
        $response = $woRequisitionAction->run($request);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param WoRequisition $woRequisition
     * @return JsonResponse
     */
    public function show(WoRequisition $woRequisition): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = $woRequisition;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param WoRequisition $woRequisition
     * @return JsonResponse
     */
    public function update(Request $request, WoRequisition $woRequisition): JsonResponse
    {
        $response = $woRequisition->updateData($woRequisition->_id, $request->all());

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WoRequisition $woRequisition
     * @param WoRequisitionItems $woRequisitionItems
     * @return JsonResponse
     */
    public function destroy(WoRequisition $woRequisition, WoRequisitionItems $woRequisitionItems): JsonResponse
    {
        $woRequisition->delete();
        $woRequisitionItems->deleteData(['woRequitionId' => $woRequisition->_id]);

        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }

    /**
     * @return object
     */
    public function getItemRequisitionOption(): object
    {
        $items = WoRequisition::all();
        return $items->map(callback: fn ($item): array => [
            'label' => $item->reqNumber,
            'value' => $item->_id
        ]);
    }

    /**
     * @param string $id
     * @return array
     */
    public function getRequisitionDetailsWithJobCardWorkOrder(string $id): array
    {
        return [
            'data' => WoRequisition::with(['workOrderDetails','jobCardDetails'])->find($id)
        ];
    }
}
