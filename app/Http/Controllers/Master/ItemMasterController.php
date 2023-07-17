<?php

namespace App\Http\Controllers\Master;

use App\Actions\ItemMaster\CopyItemMasterDetailsAction;
use App\Actions\ItemMaster\ItemMasterFilterAction;
use App\Http\Controllers\Controller;
use App\Models\Bom\BillOfMaterial;
use App\Models\Master\ItemMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = ItemMaster::getRelationData([], ['uomItem']);

        $data['message'] = "Item Master Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
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
        $dataInsert = $request->all();
        $party_master = ItemMaster::saveData($dataInsert);

        $data['message'] = "Item Master Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = ItemMaster::getFindRelationData($id, [
            'uomDetails:_id,uom',
            'hsnDetails',
            'updatedBy:_id,first_name,last_name',
            'createdBy:_id,first_name,last_name'
        ]);

        $data['message'] = "Item Master found";
        $data['status'] = 200;
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
        $updateData = $request->all();
        unset($updateData['id']);

        if (isset($updateData['isItemDetailsData']) && $updateData['isItemDetailsData'] === true) {
            $fetchData = ItemMaster::getDataFromId($id, true);
            $fetchData['itemDetails'] = $updateData;
            $updateData = $fetchData;
        }

        if (isset($updateData['isPurchaseData']) && $updateData['isPurchaseData'] === true) {
            $fetchData = ItemMaster::getDataFromId($id, true);
            $fetchData['purchaseData'] = $updateData;
            $updateData = $fetchData;
        }

        if (isset($updateData['isGeneralData']) && $updateData['isGeneralData'] === true) {
            $fetchData = ItemMaster::getDataFromId($id, true);
            $fetchData['generalData'] = $updateData;
            $updateData = $fetchData;
        }

        if (isset($updateData['ishsnSacDetails']) && $updateData['ishsnSacDetails'] === true) {
            $fetchData = ItemMaster::getDataFromId($id, true);
            $fetchData['hsnSacDetails'] = $updateData;
            $updateData = $fetchData;
        }
        $response = ItemMaster::updateData($id, $updateData);

        $data['message'] = "Item Master Updated";
        $data['status'] = 200;
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
        ItemMaster::destroy($id);

        $data['message'] = "Item Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getGroupCodeCount(Request $request)
    {
        $count = ItemMaster::getCountWithLike('itemCode', $request->groupCode);
        return jsonData(['count' => $request->groupCode . (string)($count + 1)]);
    }

    /**
     * @return JsonResponse
     */
    public function getItemOptions()
    {
        $fetchData = ItemMaster::getData();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->itemCode . ' - ' . $value->itemDescription;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Item Master Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getItemFilterOptions()
    {
        $itemCodes = BillOfMaterial::query()->pluck('itemCode')->toArray();
        $fetchData = ItemMaster::query()
            ->where('materialProcessType', '!=', 2)
            ->whereNotIn('_id', $itemCodes)
            ->get();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->itemCode . ' - ' . $value->itemDescription;
            $response[$key]['value'] = $value->_id;
            $response[$key]['itemCode'] = $value->itemCode;
            $response[$key]['itemDescription'] = $value->itemDescription;
        }

        $data['message'] = "Item Master Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkItemNameExist(Request $request)
    {
        $data = $request->all();
        $exists = ItemMaster::checkExists(['itemDescription' => $data['itemDescription']]);

        $data['message'] = "Item Description Check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkItemNameExistWithId(Request $request)
    {
        $data = $request->all();
        $exists = ItemMaster::checkExistsWithId($data['id'], ['itemDescription' => $data['itemDescription']]);

        $data['message'] = "Item Description Check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param ItemMasterFilterAction $itemMasterFilterAction
     * @return JsonResponse
     */
    public function getItemMasterWithFilter(Request $request, ItemMasterFilterAction $itemMasterFilterAction)
    {
        $response = $itemMasterFilterAction->handle($request);

        $data['message'] = "Item Master List";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    public function copyItemMasterItem(Request $request, CopyItemMasterDetailsAction $copyItemMasterDetailsAction)
    {
        $response = $copyItemMasterDetailsAction->handle($request);

        $data['message'] = "Item Master Copied";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }
}
