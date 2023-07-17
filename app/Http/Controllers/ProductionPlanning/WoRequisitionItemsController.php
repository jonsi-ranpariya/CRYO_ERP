<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductionPlanning\IssueMaterialForRequisitionRequest;
use App\Models\ProductionPlanning\WoRequisitionItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WoRequisitionItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param WoRequisitionItems $woRequisitionItems
     * @return JsonResponse
     */
    public function index(WoRequisitionItems $woRequisitionItems): JsonResponse
    {
        $response = $woRequisitionItems->all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param WoRequisitionItems $woRequisitionItems
     * @return JsonResponse
     */
    public function store(Request $request, WoRequisitionItems $woRequisitionItems): JsonResponse
    {
        $dataInsert = $request->all();
        $response = $woRequisitionItems->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param WoRequisitionItems $woRequisitionItems
     * @return JsonResponse
     */
    public function show(WoRequisitionItems $woRequisitionItems): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = $woRequisitionItems;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @param WoRequisitionItems $woRequisitionItems
     * @return JsonResponse
     */
    public function update($id, Request $request, WoRequisitionItems $woRequisitionItems): JsonResponse
    {
        $dataInsert = $request->all();
        $response = $woRequisitionItems->updateData($id, $dataInsert);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param WoRequisitionItems $woRequisitionItems
     * @return JsonResponse
     */
    public function destroy($id, WoRequisitionItems $woRequisitionItems): JsonResponse
    {
        $woRequisitionItems->destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['data'] = $woRequisitionItems;
        return jsonData($data);
    }

    /**
     * @param $id
     * @param WoRequisitionItems $woRequisitionItems
     * @return JsonResponse
     */
    public function getItemList($id, WoRequisitionItems $woRequisitionItems): JsonResponse
    {
        $response = $woRequisitionItems->getData(['woRequitionId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    public function issueMaterialOnItem(IssueMaterialForRequisitionRequest $request)
    {
        dd($request->all());
    }
}
