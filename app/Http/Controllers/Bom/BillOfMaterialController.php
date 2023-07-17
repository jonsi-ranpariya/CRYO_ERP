<?php

namespace App\Http\Controllers\Bom;

use App\Actions\Bom\BillOfMaterialVersionAction;
use App\Http\Controllers\Controller;
use App\Models\Bom\BillOfMaterial;
use App\Models\Bom\BillOfMaterialModel;
use App\Models\Bom\BillOfMaterialVersion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillOfMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = BillOfMaterial::all();

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
        $response = BillOfMaterial::saveData($request->all());
        BillOfMaterialVersionAction::run($response->_id);

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
        $response = BillOfMaterial::getDataFromId($id);

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
        $response = BillOfMaterial::updateData($id, $request->all());

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
        BillOfMaterial::destroyData($id);
        BillOfMaterialVersionAction::make()->delete($id);

        $data['status'] = 200;
        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }

    public function getBillOfMaterialOptions()
    {
        $fetchData = BillOfMaterial::getData([]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->item_name->itemCode . " - " . $value->itemDescription;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function isBomExist($id)
    {
        $response = BillOfMaterial::checkExists(['itemCode' => $id]);
        $response1 = BillOfMaterial::getFirstData(['itemCode' => $id]);

        $data['data'] = $response;
        $data['item'] = $response1;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param BillOfMaterialVersion $billOfMaterial
     * @return JsonResponse
     */

    public function getBomItemFilters(Request $request, BillOfMaterialVersion $billOfMaterial)
    {
        $itemCode = $request->itemCode;
        $itemDescription = $request->itemDescription;
        $drawingNumber = $request->drawingNumber;

        $itemDetails = $billOfMaterial->query()
            ->with([
                'bomDetail' => fn($q) => [
                    !empty($itemDescription) ? $q->where('itemDescription', 'LIKE', "%{$itemDescription}%") : null,
                    $q->with([
                        'itemDetails' => fn($itemQuery) => [
                            $itemQuery->select(['_id', 'itemCode']),
                            !empty($itemCode) ? $itemQuery->where('itemCode', 'LIKE', "%{$itemCode}%") : null
                        ]
                    ])->select(['_id', 'itemCode', 'itemDescription'])
                    ->has('itemDetails')
                ]
            ])->select(['bomDescription', 'bomDrawingNumber', 'bomDrawingRevision', 'bomId', 'bomNumber'])
            ->has('bomDetail')
            ->activeOnly();

        if (!empty($drawingNumber)) {
            $itemDetails->where('bomDrawingNumber', 'LIKE', "%{$drawingNumber}%");
        }

        if (empty($itemCode) and empty($itemDescription) and empty($drawingNumber)) {
            $itemData = [];
        } else {
            $response = $itemDetails->get();
            foreach ($response as $key => $item) {
                if ($item->bomDetail != null and !empty($item->bomDetail))
                    if ($item->bomDetail->itemDetails != null and !empty($item->bomDetail->itemDetails))
                        $itemData[$key] = $item;
            }
        }

        $data['Message'] = 'Bom Item List';
        $data['status'] = 200;
        $data['data'] = array_values($itemData ?? []);
        return jsonData($data);
    }

}
