<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use App\Models\Mrp\WoAllocation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WoAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data['data'] = WoAllocation::all();
        $data['message'] = 'Data found';
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
        $response = WoAllocation::saveData($dataInsert);

        $data['message'] = 'Data saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param WoAllocation $woAllocation
     * @return JsonResponse
     */
    public function show(WoAllocation $woAllocation): JsonResponse
    {
        $data['message'] = 'data found';
        $data['data'] = $woAllocation;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param WoAllocation $woAllocation
     * @return JsonResponse
     */
    public function update(Request $request, WoAllocation $woAllocation): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $woAllocation->updateData($dataUpdate['_id'],$dataUpdate);

        $data['message'] = 'data updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @param WoAllocation $woAllocation
     * @return JsonResponse
     */
    public function destroy(string $id, WoAllocation $woAllocation): JsonResponse
    {
        $data['message'] = 'Data deleted';
        $data['data'] = $woAllocation->destroyData($id);
        return jsonData($data);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getWoAllocationList(string $id): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = WoAllocation::getData(['manualPlanningId' => $id]);
        return jsonData($data);
    }
}
