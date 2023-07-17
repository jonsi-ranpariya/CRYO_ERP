<?php

namespace App\Http\Controllers\Bom;

use App\Actions\Bom\DuplicateBomVersionItems;
use App\Actions\Bom\DuplicateBomVersionItemsInItem;
use App\Http\Controllers\Controller;
use App\Models\Bom\BillOfMaterialVersion;
use App\Models\Bom\BomVersionItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BomVersionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = BomVersionItem::all();

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
        $data = $request->all();
        $assemblyCopy = $data['assemblyCopy'];
        $assemblyFromVersionId = $data['assemblyFromVersionId'];
        $res = BomVersionItem::saveData($data);
        if ($assemblyCopy == 1 and $res) {
            DuplicateBomVersionItemsInItem::make()->handle(
                ids: [$assemblyFromVersionId],
                destinationId: $res->versionId,
                bomId: $res->bomId,
                destinationItemId: $res->_id
            );
        }

        $response['status'] = 200;
        $response['message'] = 'Data Saved';
        $response['data'] = $res;
        return jsonData($response);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = BomVersionItem::getDataFromId($id);

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $res = BomVersionItem::updateData($id, $data);

        $response['status'] = 200;
        $response['message'] = 'Data Updated';
        $response['data'] = $res;
        return jsonData($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        BomVersionItem::destroyData($id);
        BomVersionItem::deleteData(['versionItemId' => $id]);

        $response['status'] = 200;
        $response['message'] = 'Data Deleted';
        $response['data'] = [];
        return jsonData($response);
    }

    /**
     * @param $bomId
     * @param $versionId
     * @return JsonResponse
     */
    public function getBomVersionItemData($bomId, $versionId): JsonResponse
    {
        $data = BomVersionItem::getData([
            'bomId' => $bomId,
            'versionId' => $versionId,
            'versionItemId' => null
        ]);

        $response['status'] = 200;
        $response['message'] = 'Data Found';
        $response['data'] = $data;
        return jsonData($response);
    }

    /**
     * @param $itemId
     * @return JsonResponse
     */
    public function getBomUsingItemId($itemId): JsonResponse
    {
        $data = BomVersionItem::query()
            ->with(['versionDetails' => function ($query) {
                $query->select(['_id', 'bomNumber', 'bomDescription', 'bomVersion']);
            }])
            ->where(['itemCode' => $itemId])
            ->get(['itemCode', 'itemDescription', 'bomId', 'versionId']);

        $response['status'] = 200;
        $response['message'] = 'Data Found';
        $response['data'] = $data;
        return jsonData($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addBomVersionItem(Request $request, DuplicateBomVersionItems $duplicateBomVersionItems): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'bomVersionId' => 'required|string'
        ]);

        $forCopyVersionId = $request->bomVersionId;
        $bom = BillOfMaterialVersion::find($forCopyVersionId, ['bomId']);

        $ids = $request->ids;
        $items = $duplicateBomVersionItems->handle(
            ids: $ids,
            destinationId: $forCopyVersionId,
            bomId: $bom->bomId
        );

        $data['message'] = 'Data Saved';
        $data['data'] = $items;
        return jsonData($data);
    }

    /**
     * @param string $bomId
     * @param string $versionId
     * @param string $assemblyId
     * @return JsonResponse
     */
    public function getBomVersionAssemblyItemData(string $bomId, string $versionId, string $assemblyId): JsonResponse
    {
        $data = BomVersionItem::getData([
            'bomId' => $bomId,
            'versionId' => $versionId,
            'versionItemId' => $assemblyId
        ]);

        $response['status'] = 200;
        $response['message'] = 'Data Found';
        $response['data'] = $data;
        return jsonData($response);
    }
}
