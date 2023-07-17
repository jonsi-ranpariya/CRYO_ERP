<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use App\Models\MRP\MrpIndent;
use App\Models\ProductionPlanning\WorkOrderItemAssembly;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WoWiseAssemblyComponentController extends Controller
{
    /**
     * @param $mrpIndent
     * @return string
     */
    public function generateIndentNumber($mrpIndent)
    {
        $latest = $mrpIndent->query()->latest()->first();

        if (!$latest) {
            $newNumber = 'I00001';
        } else {
            $string = preg_replace("/[^0-9\.]/", '', $latest->indentNo);
            $newNumber = 'I' . sprintf('%05d', $string + 1);
        }

        return $newNumber;
    }

    /**
     * Display a listing of the resource.
     *
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function index(MrpIndent $mrpIndent)
    {
        $response = $mrpIndent->getData(['indentCreatedMenuId' => 2]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param MrpIndent $mrpIndent
     * @param WorkOrderItemAssembly $workOrderItemAssembly
     * @return JsonResponse
     */
    public function store(Request $request, MrpIndent $mrpIndent, WorkOrderItemAssembly $workOrderItemAssembly)
    {
        $dataInsert = $request->all();

        foreach ($dataInsert['woIds'] as $key => $woId) {
            unset($dataInsert['woIds']);

            $workOrderAssemblyItem = $workOrderItemAssembly->getFindRelationData($woId,
                ['workOrderDetails' => function ($query) {
                    $query->select(['woNumber', 'assembly', 'assemblyCode']);
                }]
            );

            $dataInsert['indentNo'] = $this->generateIndentNumber($mrpIndent);
            $dataInsert['itemId'] = $workOrderAssemblyItem->item_name->_id;
            $dataInsert['itemCode'] = $workOrderAssemblyItem->itemCode;
            $dataInsert['itemDescription'] = $workOrderAssemblyItem->itemDescription;
            $dataInsert['addDescription'] = $workOrderAssemblyItem->itemAddDescription;
            $dataInsert['detailDescription'] = $workOrderAssemblyItem->itemDetailDescription;
            $dataInsert['drawingNumber'] = $workOrderAssemblyItem->itemDrawingNumber;
            $dataInsert['rev'] = $workOrderAssemblyItem->itemDrawingRevision;
            $dataInsert['uom'] = $workOrderAssemblyItem->itemConvUom;
            $dataInsert['cFactor'] = $workOrderAssemblyItem->itemConvFactor;
            $dataInsert['conveQty'] = $workOrderAssemblyItem->itemConvQty;
            $dataInsert['itemMake'] = $workOrderAssemblyItem->itemMake;
            $dataInsert['store'] = $workOrderAssemblyItem->itemStore;
            $dataInsert['indentDate'] = date('Y-m-d');
            $dataInsert['woId'] = $workOrderAssemblyItem->woId;
            $dataInsert['soId'] = null;
            $dataInsert['remark'] = $workOrderAssemblyItem->itemNote;
            $dataInsert['loginDetails']['createdBy'] = auth()->user()->first_name . ' ' . auth()->user()->last_name;
            $dataInsert['loginDetails']['dateTime'] = date('d-m-Y H:i');
            $dataInsert['loginDetails']['lastModifiedBy'] = null;
            $dataInsert['loginDetails']['modifiedDateTime'] = null;
            $dataInsert['loginDetails']['approvedBy'] = null;
            $dataInsert['loginDetails']['approveDate'] = null;
            $dataInsert['loginDetails']['stage'] = 1;
            $response = $mrpIndent->saveData($dataInsert);
        }

        $data['message'] = 'Data Saved';
        $data['data'] = $response ?? null;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function show($id, MrpIndent $mrpIndent)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $mrpIndent->getDataFromId($id);
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function update($id, Request $request, MrpIndent $mrpIndent)
    {
        $dataUpdate = $request->all();
        $response = $mrpIndent->updateData($id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function destroy($id, MrpIndent $mrpIndent)
    {
        try {
            $response = $mrpIndent->destroyData($id);

            $data['message'] = 'Data Deleted';
            $data['data'] = $response;
            return jsonData($data);

        } catch (\Exception $exception) {

            $data['message'] = $exception->getMessage();
            $data['data'] = null;
            return jsonData($data);
        }
    }
}
