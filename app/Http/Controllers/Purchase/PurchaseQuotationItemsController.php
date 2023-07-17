<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseQuotationItems;
use App\Models\SalesCrm\SalesOrderItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseQuotationItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = PurchaseQuotationItems::all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $response = PurchaseQuotationItems::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  PurchaseQuotationItems  $purchaseQuotationItems
     * @return JsonResponse
     */
    public function show(PurchaseQuotationItems $purchaseQuotationItems)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseQuotationItems;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @param PurchaseQuotationItems $purchaseQuotationItems
     * @return JsonResponse
     */
    public function update($id, Request $request, PurchaseQuotationItems $purchaseQuotationItems)
    {
        $dataUpdate = $request->all();
        $response = $purchaseQuotationItems->updateData($id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param PurchaseQuotationItems $purchaseQuotationItems
     * @return JsonResponse
     */
    public function destroy($id, PurchaseQuotationItems $purchaseQuotationItems)
    {
        $data['message'] = 'Data Deleted';
        $data['data'] = $purchaseQuotationItems->destroyData($id);
        return jsonData($data);
    }

    /**
     * @param $id
     * @param PurchaseQuotationItems $purchaseQuotationItems
     * @return JsonResponse
     */
    public function getPurchaseQuotationItems($id, PurchaseQuotationItems $purchaseQuotationItems)
    {
        $response = $purchaseQuotationItems->getData(['purchaseQuotationId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param PurchaseQuotationItems $purchaseQuotationItems
     * @return JsonResponse
     */
    public function getPurchaseQuotationFilters(Request $request, PurchaseQuotationItems $purchaseQuotationItems)
    {
        $itemCode = $request->itemCode;
        $itemDescription = $request->itemDescription;
        $itemDrawingNumber = $request->itemDrawingNumber;

        $itemDetails = $purchaseQuotationItems->with(['itemDetails' => function ($query) use($itemCode) {
            if ($itemCode) {
                $query->where('itemCode', 'LIKE', "%{$itemCode}%");
            }
        }]);

        if (!empty($itemDescription)) {
            $itemDetails->where('itemDescription', 'LIKE', "%{$itemDescription}%");
        }

        if (!empty($itemDrawingNumber)) {
            $itemDetails->where('itemDrawingNumber', 'LIKE', "%{$itemDrawingNumber}%");
        }

        if (empty($itemCode) && empty($itemDescription) && empty($itemDrawingNumber) && empty($itemUom)) {
            $itemList = [];
        } else {
            $items = $itemDetails->get();
            foreach ($items as $key => $item) {
                if ($item->itemDetails != null)
                    $itemList[$key] = $item;
            }
        }

        $data['message'] = "Purchase Quotation Item List";
        $data['status'] = 200;
        $data['data'] = array_values($itemList ?? []);
        return jsonData($data);
    }

    public function getRefWiseItems(string $refId): JsonResponse
    {
        $items = PurchaseQuotationItems::query()->where('purchaseQuotationId', $refId)->get();
        $data['message'] = 'Data Found';
        $data['data'] = $items;
        return jsonData($data);
    }
}
