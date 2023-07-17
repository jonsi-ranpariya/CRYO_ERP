<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\GoodsReceiptNote;
use App\Models\Inventory\GoodsReceiptNoteItem;
use App\Models\QualityControl\InwardQualityControl;
use App\Models\QualityControl\InwardQualityControlItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GoodsReceiptNoteItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = GoodsReceiptNoteItem::all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param GoodsReceiptNoteItem $goodsReceiptNoteItem
     * @return JsonResponse
     */
    public function store(Request $request, GoodsReceiptNoteItem $goodsReceiptNoteItem): JsonResponse
    {
        $dataInsert = $request->all();
        $counts = GoodsReceiptNoteItem::query()->where('goodNoteId', $dataInsert['goodNoteId'])->count();
        if ($counts == 1) {
            return jsonData([
                'message' => 'One item Already exists.'
            ], Response::HTTP_NOT_ACCEPTABLE);
        }

        $exists = GoodsReceiptNoteItem::checkExists([
            'girNo' => $dataInsert['girNo'],
            'partyCode' => $dataInsert['partyCode'],
            'poNo' => $dataInsert['poNo']
        ]);

        if ($exists) {
            $gir = GoodsReceiptNoteItem::query()
                ->where([
                    'girNo' => $dataInsert['girNo'],
                    'partyCode' => $dataInsert['partyCode'],
                    'poNo' => $dataInsert['poNo']
                ])
                ->latest()->first();
            $dataInsert['grnNo'] = $gir->grnNo;
        } else {
            $dataInsert['grnNo'] = generateCodes(new GoodsReceiptNoteItem(), 'GN22230000001', 'grnNo', 'GN');
        }

        $response = $goodsReceiptNoteItem->saveData($dataInsert);

        $data['message'] = 'Data saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     * @param string $id
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $response = GoodsReceiptNoteItem::getDataFromId($id);
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param GoodsReceiptNoteItem $goodsReceiptNoteItem
     * @return JsonResponse
     */
    public function update(Request $request, GoodsReceiptNoteItem $goodsReceiptNoteItem): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $goodsReceiptNoteItem->updateData($dataUpdate['_id'], $dataUpdate);

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
        GoodsReceiptNoteItem::destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getGoodNoteItem($id): JsonResponse
    {
        $response = GoodsReceiptNoteItem::getData(['goodNoteId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }


    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getGrnItemList(Request $request): JsonResponse
    {
        $partyId = $request->partyId;
        $grnId = $request->goodNoteId;

        $response = GoodsReceiptNoteItem::query()
            ->with('partyDetail')
            ->where('goodNoteId', $grnId)
            ->whereHas('partyDetail', function ($partyQuery) use ($partyId) {
                $partyQuery->where('partyId', $partyId);
            })
            ->get();

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }

    public function geGrnNumberOption(GoodsReceiptNoteItem $goodsReceiptNoteItem): JsonResponse
    {
        $fetchData = $goodsReceiptNoteItem->get();
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->grnNo;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "GRN Number Found";
        $data['status'] = 200;
        $data['data'] = array_values($response ?? []);
        return jsonData($data);
    }

    public function getGenNumberFromGrnItemOptions(): JsonResponse
    {
        $inwardQcGRNIds = InwardQualityControl::query()->pluck('goodNoteId');
        $items = GoodsReceiptNote::query()->whereNotIn('_id',$inwardQcGRNIds)->get();

        if ($items->isNotEmpty()) {
            $response = $items->map(function (GoodsReceiptNote $item) {
                return [
                    'label' => $item->grn_Details?->grnNo ?? 'N/A',
                    'value' => $item->_id
                ];
            });
        }

        $data['message'] = "GRN Number Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getAllGrnItemOptions(): JsonResponse
    {
        $items = GoodsReceiptNote::all();
        $response = $items->map(function (GoodsReceiptNote $item) {
            return [
                'label' => $item->grn_Details->grnNo,
                'value' => $item->_id
            ];
        });

        $data['message'] = "GRN Number Found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    public function geGrnPoNumberOption(): JsonResponse
    {
        $inwardQcGRNIds = InwardQualityControl::query()->pluck('goodNoteId');
        $items = GoodsReceiptNote::query()->whereNotIn('_id',$inwardQcGRNIds)->get();
        if ($items->isNotEmpty()) {
            $response = $items->map(function (GoodsReceiptNote $item) {
                return [
                    'label' => $item->grn_Details?->poNo ?? 'N/A',
                    'value' => $item->purchaseOrderId
                ];
            });
        }

        $data['message'] = "GRN PO Number Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getAllGrnPoNumberOption(): JsonResponse
    {
        $items = GoodsReceiptNote::all();
        $response = $items->map(function (GoodsReceiptNote $item) {
            return [
                'label' => $item->grn_Details->poNo,
                'value' => $item->purchaseOrderId
            ];
        });

        $data['message'] = "GRN PO Number Found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

}
