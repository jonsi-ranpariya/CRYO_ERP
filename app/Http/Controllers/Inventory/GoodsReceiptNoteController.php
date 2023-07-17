<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\GoodsReceiptNote;
use App\Models\Inventory\GoodsReceiptNoteItem;
use App\Models\JobWork\IssueJobWorkChallanItems;
use App\Models\QualityControl\InwardQualityControl;
use App\Models\QualityControl\InwardQualityControlItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GoodsReceiptNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = GoodsReceiptNote::all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param GoodsReceiptNote $goodsReceiptNote
     * @return JsonResponse
     */
    public function store(Request $request, GoodsReceiptNote $goodsReceiptNote): JsonResponse
    {
        $dataInsert = $request->all();
        $response = $goodsReceiptNote->saveData($dataInsert);

        $data['message'] = 'Data saved';
        $data['data'] = $response;
        return jsonData($data);

    }

    /**
     * Display the specified resource.
     *
     * @param GoodsReceiptNote $goodsReceiptNote
     * @return JsonResponse
     */
    public function show(GoodsReceiptNote $goodsReceiptNote): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $goodsReceiptNote;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param GoodsReceiptNote $goodsReceiptNote
     * @return JsonResponse
     */
    public function update(Request $request, GoodsReceiptNote $goodsReceiptNote): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $goodsReceiptNote->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        GoodsReceiptNote::destroyData($id);
        GoodsReceiptNoteItem::deleteData(['goodNoteId' => $id]);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        return jsonData($data);
    }

    public function getGoodItemOption(GoodsReceiptNote $goodsReceiptNote): JsonResponse
    {
        $itemIds = InwardQualityControl::query()->pluck('goodNoteId');
        $fetchData = $goodsReceiptNote->whereNotIn('_id', $itemIds)->get();
        foreach ($fetchData as $key => $value) {
            if (!empty($value->itemDetails->isNotEmpty())) {
                $response[$key]['label'] = $value->partyCode . ' - ' . $value->partyName;
                $response[$key]['value'] = $value->_id;
            }
        }

        $data['message'] = "Good Receipt Note Found";
        $data['status'] = 200;
        $data['data'] = array_values($response ?? []);
        return jsonData($data);
    }

    public function geGrnItemOption(GoodsReceiptNote $goodsReceiptNote)
    {
        $fetchData = $goodsReceiptNote->get();
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->partyCode . ' - ' . $value->partyName;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Good Receipt Note Found";
        $data['status'] = 200;
        $data['data'] = array_values($response ?? []);
        return jsonData($data);
    }
}
