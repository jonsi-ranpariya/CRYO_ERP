<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\IssueJobWorkChallanItems;
use App\Models\JobWork\RawMaterialSubContractorItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RawMaterialSubContractorItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = RawMaterialSubContractorItems::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param RawMaterialSubContractorItems $rawMaterialSubContractorItems
     * @return JsonResponse
     */
    public function store(Request $request, RawMaterialSubContractorItems $rawMaterialSubContractorItems)
    {
        $dataInsert = $request->all();
        $response = $rawMaterialSubContractorItems->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
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
        $response = RawMaterialSubContractorItems::getDataFromId($id);
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  RawMaterialSubContractorItems  $rawMaterialSubContractorItems
     * @return JsonResponse
     */
    public function update(Request $request, RawMaterialSubContractorItems $rawMaterialSubContractorItems)
    {
        $dataUpdate = $request->all();
        $response = $rawMaterialSubContractorItems->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param RawMaterialSubContractorItems $rawMaterialSubContractorItems
     * @return JsonResponse
     */
    public function destroy($id, RawMaterialSubContractorItems $rawMaterialSubContractorItems)
    {
        $response = $rawMaterialSubContractorItems->destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param RawMaterialSubContractorItems $rawMaterialSubContractorItems
     * @return JsonResponse
     */
    public function addRawMaterialItem(Request $request, RawMaterialSubContractorItems $rawMaterialSubContractorItems)
    {
        $itemDetails = IssueJobWorkChallanItems::whereInData('_id', $request->ids);
//        dd($itemDetails);
        foreach ($itemDetails as $itemDetail) {
            $dataInsert['rawId'] = $request->rawId;
            $dataInsert['itemId'] = $itemDetail->itemId ?? null;
            $dataInsert['showIssueItemId'] = $itemDetail->showIssueItemId ?? null;
            $dataInsert['jobCardId'] = $itemDetail->jobCardId ?? null;
            $dataInsert['itemCode'] = $itemDetail->itemCode ?? null;
            $dataInsert['itemDescription'] = $itemDetail->itemDescription ?? null;
            $dataInsert['itemAddDescription'] = $itemDetail->itemAddDescription ?? null;
            $dataInsert['itemDetailDescription'] = $itemDetail->itemDetailDescription ?? null;
            $dataInsert['itemDrawingNumber'] = $itemDetail->itemDrawingNumber ?? null;
            $dataInsert['itemDrawingRevision'] = $itemDetail->itemDrawingRevision ?? null;
            $dataInsert['itemUom'] = $itemDetail->itemUom ?? null;
            $dataInsert['itemQuntity'] = $itemDetail->itemQuntity ?? null;
            $dataInsert['itemRate'] = null;
            $dataInsert['itemAcceptQty'] = null;
            $dataInsert['itemRejectQty'] = null;
            $dataInsert['itemJobCardNo'] = $itemDetail->jobCardNumber;
            $dataInsert['itemNote'] = null;
            $dataInsert['rejectionItemCode'] = null;
            $dataInsert['rejectItemDescription'] = null;
            RawMaterialSubContractorItems::saveData($dataInsert);
        }

        $data['message'] = 'Data Saved';
        $data['data'] = (object)[];
        return jsonData($data);
    }

    public function getRawMaterialItems($id)
    {
        $response = RawMaterialSubContractorItems::getData(['rawId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }


}
