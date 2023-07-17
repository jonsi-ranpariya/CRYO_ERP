<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use App\Models\MRP\MrpIndent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndentApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  MrpIndent  $mrpIndent
     * @return JsonResponse
     */
    public function index(MrpIndent $mrpIndent)
    {
        $response = $mrpIndent->query()
            ->whereNull('loginDetails.approvedBy')
            ->whereNull('loginDetails.approveDate')
            ->get();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @param  MrpIndent  $mrpIndent
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
     * @param  $id
     * @param  Request  $request
     * @param  MrpIndent  $mrpIndent
     * @return JsonResponse
     */
    public function update($id, Request $request, MrpIndent $mrpIndent)
    {
        $dataUpdate = $request->all();
        $response = $mrpIndent->updateData($id, $dataUpdate);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param MrpIndent $mrpIndent
     * @return JsonResponse
     */
    public function getIndentApprovalItemFilter(Request $request, MrpIndent $mrpIndent)
    {
        $indentNo = $request->indentNo;
        $itemCode = $request->itemCode;
        $itemDescription = $request->itemDescription;
        $drawingNumber = $request->drawingNumber;

        $itemDetails = $mrpIndent->query();

        if (!empty($indentNo)) {
            $itemDetails->where('indentNo', 'LIKE', "%{$indentNo}%");
        }

        if (!empty($itemCode)) {
            $itemDetails->where('itemCode', 'LIKE', "%{$itemCode}%");
        }

        if (!empty($itemDescription)) {
            $itemDetails->where('itemDescription', 'LIKE', "%{$itemDescription}%");
        }

        if (!empty($drawingNumber)) {
            $itemDetails->where('drawingNumber', 'LIKE', "%{$drawingNumber}%");
        }

        if (empty($indentNo) && empty($itemCode) && empty($itemDescription) && empty($drawingNumber)) {
            $response = [];
        } else {
            $response = $itemDetails->get();
        }

        $data['message'] = "Indent Item List";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }
}
