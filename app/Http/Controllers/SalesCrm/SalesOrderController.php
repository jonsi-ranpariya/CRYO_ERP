<?php

namespace App\Http\Controllers\SalesCrm;

use App\Actions\Sales\CreateSalesOrderWithItemsAction;
use App\Actions\Sales\salesOrderAddRemoveAction;
use App\Http\Controllers\Controller;
use App\Models\Partymaster\ContactPerson;
use App\Models\SalesCrm\SalesOrder;
use App\Models\SalesCrm\SalesOrderItems;
use App\Notifications\SalesCrm\SalesOrderApprovedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $fetchData = SalesOrder::all();

        $data['message'] = "Sales Order Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CreateSalesOrderWithItemsAction $createSalesOrderWithItemsAction
     * @return JsonResponse
     */
    public function store(Request $request, CreateSalesOrderWithItemsAction $createSalesOrderWithItemsAction): JsonResponse
    {
        $response = $createSalesOrderWithItemsAction->handle($request);
        $data['message'] = "Sales Order Saved";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $response = SalesOrder::getDataFromId($id);

        $data['message'] = "Sales Quotation found";
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
    public function update(Request $request, $id): JsonResponse
    {
        $updateData = $request->all();
        $response = SalesOrder::updateData($id, $updateData);
        /*if ($updateData['SalesOrderStageDetail']['stage'] == 'Approved') {
            $data = [
                'id' => $id,
                'title' => "Sales Order Approved",
                'subtitle' => "Sales Order Approved: " . $updateData['salesOrderNo'],
                'type' => 'light-success',
                'icon' => 'CheckIcon',
            ];
            auth()->user()->notifyNow(new SalesOrderApprovedNotification($data));
        }*/

        $data['message'] = "Sales Quotation Updated";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        salesOrderAddRemoveAction::make()->removeAllSalesOrderRelatedData($id);

        $data['message'] = "Sales Quotation Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    public function getPartyItemsFromOrders($id): JsonResponse
    {
        $orderIds = SalesOrder::pluckData(['sellToPartyCustomerID' => $id], '_id', true);
        $items = SalesOrderItems::whereInData('salesOrderId', $orderIds);

        $data['message'] = "Sales Order Items Found";
        $data['status'] = 200;
        $data['data'] = $items;
        return jsonData($data);
    }

    public function getSalesOrderListOptions(): JsonResponse
    {
        $responseData = [];
        $fetchData = SalesOrder::all();

        foreach ($fetchData as $key => $value) {
            $responseData[$key]['label'] = $value->salesOrderNo . " (" . $value->sellToPartyCustomerCode . " - " . $value->sellToPartyCustomerName . ")";
            $responseData[$key]['value'] = $value->_id;
        }

        $data['message'] = "Sales Found";
        $data['status'] = 200;
        $data['data'] = $responseData;
        return jsonData($data);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getSalesOrderListByItemIdOptions(string $id): JsonResponse
    {
        $fetchData = SalesOrderItems::with(['salesOrder' => function ($query) {
            $query->select(['_id', 'salesOrderNo', 'sellToPartyCustomerCode', 'sellToPartyCustomerName']);
        }])->select(['salesOrderNo', 'salesOrderId'])->where('itemId', $id)->whereHas('salesOrder')->get();

        foreach ($fetchData as $key => $value) {
            $responseData[$key]['label'] = $value->salesOrderNo . " (" . $value->salesOrder->sellToPartyCustomerCode . " - " . $value->salesOrder->sellToPartyCustomerName . ")";
            $responseData[$key]['value'] = $value->salesOrder->_id;
        }

        $data['message'] = "Sales Found";
        $data['status'] = 200;
        $data['data'] = $responseData ?? [];
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSalesOrderWithFilter(Request $request): JsonResponse
    {
        $postData = $request->all();
        $myFilter = [];
        if (!empty($postData)) {
            if (!empty($postData['sellToPartyCustomerID'])) {
                $myFilter['sellToPartyCustomerID'] = $postData['sellToPartyCustomerID'];
            }
            if (!empty($postData['customerCity'])) {
                $myFilter['partyDetail.partyDetailCityId'] = $postData['customerCity'];
            }
            if (!empty($postData['customerState'])) {
                $myFilter['partyDetail.partyDetailStateId'] = $postData['customerState'];
            }
            if (!empty($postData['customerCountry'])) {
                $myFilter['partyDetail.partyDetailCountryID'] = $postData['customerCountry'];
            }
            if (!empty($postData['salesOrderBranch'])) {
                $myFilter['salesOrderBranch'] = $postData['salesOrderBranch'];
            }
            if (!empty($postData['salesOrderSalesType'])) {
                $myFilter['salesOrderSalesType'] = $postData['salesOrderSalesType'];
            }
            if (!empty($postData['salesType'])) {
                $myFilter['salesType'] = $postData['salesType'];
            }
            if (!empty($postData['salesOrderStatus'])) {
                $myFilter['salesOrderStatus'] = $postData['salesOrderStatus'];
            }
            if (!empty($postData['salesOrderType'])) {
                $myFilter['salesOrderType'] = $postData['salesOrderType'];
            }
            if (!empty($postData['addedFrom'])) {
                $myFilter['loginDetail.createdBy'] = $postData['addedFrom'];
            }
        }

        $fetchData = SalesOrder::getData($myFilter);

        $data['message'] = "Sales Order Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSalesOrderKindAttn(Request $request): JsonResponse
    {
        $ids = $request->ids;
        $partyIds = SalesOrder::query()->whereIn('_id', $ids)->pluck('sellToPartyCustomerID');
        $contacts = ContactPerson::query()->whereIn('partyId', $partyIds)->get();

        foreach ($contacts as $key => $contact) {
            $response[$key]['label'] = ucfirst($contact->personName);
            $response[$key]['value'] = $contact->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function updateSalesOrderDeviation(Request $request)
    {
        $salesOrderId = $request->salesOrderId;
        $deviation = $request->deviation;

        $salesOrder = SalesOrder::find($salesOrderId);
        $salesOrder->deviation = $deviation;
        return $salesOrder->update();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSalesOrderFilterWise(Request $request): JsonResponse
    {
        $response = SalesOrder::query()
            ->when(value: $request->filled('partyCode'), callback: fn ($q) => $q->where('shipToPartyCustomerCode', 'LIKE', "%$request->partyCode%"))
            ->when(value: $request->filled('partyName'), callback: fn ($q) => $q->where('shipToPartyCustomerName', 'LIKE', "%$request->partyName%"))
            ->when(value: $request->filled('status'), callback: fn ($q) => $q->where('salesOrderStatus', 'LIKE', "%$request->status%"))
            ->get();

        return jsonData([
            'message' => 'Data Found',
            'data' => $response
        ]);
    }
}
