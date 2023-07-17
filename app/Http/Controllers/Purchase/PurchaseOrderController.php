<?php

namespace App\Http\Controllers\Purchase;

use App\Actions\Purchase\PurchaseOrderAddMultipleItemAction;
use App\Http\Controllers\Controller;
use App\Models\Inventory\GateInwardReceipt;
use App\Models\Inventory\GoodsReceiptNoteItem;
use App\Models\Purchase\PurchaseOrder;
use App\Models\Purchase\PurchaseOrderBillingTerm;
use App\Models\Purchase\PurchaseOrderItem;
use App\Models\Purchase\PurchaseOrderShowAmdDetail;
use App\Models\Purchase\PurchaseOrderTermCondition;
use App\Models\Purchase\PurchaseOrderPoHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['data'] = PurchaseOrder::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $dataInsert = $request->all();
        $itemIds = $dataInsert['itemIds'];

        $dataInsert['poNumber'] = generateCodes(new PurchaseOrder, 'PO22230001', 'poNumber', 'PO');

//        $dataInsert['poAmdNo'] = generateCodes(new PurchaseOrder(), '01','poAmdNo');
        $response = PurchaseOrder::saveData($dataInsert);

        PurchaseOrderAddMultipleItemAction::run($itemIds, $response->_id);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param PurchaseOrder $purchaseOrder
     * @return JsonResponse
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseOrder;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PurchaseOrder $purchaseOrder
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $dataUpdated = $request->all();
        $response = $purchaseOrder->updateData($purchaseOrder->_id, $dataUpdated);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }


    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        PurchaseOrder::destroyData($id);
        PurchaseOrderItem::deleteData(['purchaseOrderId' => $id]);
        PurchaseOrderPoHistory::deleteData(['purchaseOrderId' => $id]);
        PurchaseOrderShowAmdDetail::deleteData(['purchaseOrderId' => $id]);
        PurchaseOrderTermCondition::deleteData(['purchaseOrderId' => $id]);
        PurchaseOrderBillingTerm::deleteData(['purchaseOrderId' => $id]);

        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }


    /**
     * @param PurchaseOrder $purchaseOrder
     * @return JsonResponse
     */
    public function getVendorDetailOptions(PurchaseOrder $purchaseOrder)
    {
        $fetchData = $purchaseOrder->where('poStage' , 'Approved')->get();

        foreach ($fetchData as $key => $order) {
            $response[$key]['label'] = '(' . $order->partyDetail->partyCode . ') - ' . $order->vendorDetails['vendorName'];
            $response[$key]['value'] = $order->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param PurchaseOrder $purchaseOrder
     * @return JsonResponse
     */
    public function getVendorDetailsOptions(PurchaseOrder $purchaseOrder)
    {
        $itemIds = GoodsReceiptNoteItem::query()->pluck('poItemId')->toArray();
        $fetchData = $purchaseOrder->withoutGRNItem($itemIds)->checkStatus(1)->get();

        foreach ($fetchData as $key => $order) {
            if (!empty($order->itemDetails->isNotEmpty())){
                $response[$key]['label'] = '(' . $order->party_details->partyCode . ') - ' . $order->vendorDetails['vendorName'];
                $response[$key]['value'] = $order->_id;
            }
        }

        $data['message'] = 'Data Found';
        $data['data'] = array_values($response ?? []);
        return jsonData($data);
    }

    /**
     * @param string $partyId
     * @return JsonResponse
     */
    public function getPurchaseOrderByParty(string $partyId): JsonResponse
    {
        $data = PurchaseOrder::query()->select(['_id','poDate','poNumber'])->where('poVendorCode', $partyId)->get();
        return jsonData(['data' => $data, 'message' => 'Data Found']);
    }

    /**
     * @param string $poId
     * @return JsonResponse
     */
    public function generateAmdNumber(string $poId): JsonResponse
    {
        $dataUpdate = PurchaseOrder::getDataFromId($poId);
        $dataUpdate->poAmdNo = generateShortCode($dataUpdate->poAmdNo, 2);
        $response = $dataUpdate->update();

        $data['message'] = 'Number generated';
        $data['data'] = $response;
        return jsonData($data);
    }
}

