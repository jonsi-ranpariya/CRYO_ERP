<?php

namespace App\Http\Controllers\Bom;

use App\Actions\Bom\BillOfMaterialVersionAction;
use App\Http\Controllers\Controller;
use App\Models\Bom\BillOfMaterial;
use App\Models\Bom\BillOfMaterialVersion;
use App\Services\bom\BomVersionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillOfMaterialVersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = BillOfMaterialVersion::all();

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
        $response = BillOfMaterialVersionAction::run($request->all());

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
        $response = BillOfMaterialVersion::getDataFromId($id);

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
        $response = BillOfMaterialVersion::updateData($id, $request->all());

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
        BillOfMaterialVersionAction::make()->deleteVersionData($id);

        $data['status'] = 200;
        $data['message'] = 'Data Deleted';
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @return JsonResponse
     */
    public function getBomVersionsOptions()
    {
        $fetchData = BillOfMaterialVersion::all();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->bomNumber . ' - ' . $value->bomDescription;
            $response[$key]['value'] = $value->_id;
        }

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getBomVersionItemWiseOptions(string $itemId)
    {
        $bomIds = BillOfMaterial::query()->where('itemCode', $itemId)->pluck('_id');
        if (!empty($bomIds)) {
            $bomVersions = BillOfMaterialVersion::whereInData('bomId',$bomIds->toArray());
            foreach ($bomVersions as $key => $bomVersion) {
                $response[$key]['label'] = $bomVersion->bomNumber . ' - ' . $bomVersion->bomDescription;
                $response[$key]['value'] = $bomVersion->_id;
            }
        }

        $data['data'] = array_values($response ?? []);
        $data['message'] = 'Data found';
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param BomVersionService $bomVersionService
     * @return JsonResponse
     */
    public function getBomVersionFromItems(Request $request, BomVersionService $bomVersionService)
    {
        $response = $bomVersionService->getBomItemsFromVersion($request->itemCode);
        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param $bomId
     * @param BomVersionService $bomVersionService
     * @return JsonResponse
     */
    public function getBomVersionDetails($bomId, BomVersionService $bomVersionService)
    {
        $response = $bomVersionService->getBomVersionDetails($bomId);

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    public function getBomVersions(?string $itemCode)
    {
        $bomIds = BillOfMaterial::query()->where('itemCode', $itemCode)->pluck('_id');
        if (!empty($bomIds)) {
            $response = BillOfMaterialVersion::whereInData('bomId', $bomIds->toArray());
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? null;
        return jsonData($data);
    }
}
