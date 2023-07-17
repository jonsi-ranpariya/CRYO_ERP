<?php

namespace App\Http\Controllers\Despatch;

use App\Actions\Dispatch\AddMultipleSalesOrderItemAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Despatch\NewChallanInvoiceItemUpdateRequest;
use App\Models\Despatch\NewChallanInvoiceItems;
use App\Models\SalesCrm\SalesOrderItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewChallanInvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = NewChallanInvoiceItems::all();

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
        $dataInsert = $request->all();
        $response = NewChallanInvoiceItems::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @param NewChallanInvoiceItems $newChallanInvoiceItems
     * @return JsonResponse
     */
    public function show($id, NewChallanInvoiceItems $newChallanInvoiceItems)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $newChallanInvoiceItems->getDataFromId($id);
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NewChallanInvoiceItemUpdateRequest $request
     * @param NewChallanInvoiceItems $newChallanInvoiceItems
     * @return JsonResponse
     */
    public function update(NewChallanInvoiceItemUpdateRequest $request, NewChallanInvoiceItems $newChallanInvoiceItems)
    {
        $dataUpdate = $request->all();
        $response = $newChallanInvoiceItems->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param NewChallanInvoiceItems $newChallanInvoiceItems
     * @return JsonResponse
     */
    public function destroy($id, NewChallanInvoiceItems $newChallanInvoiceItems)
    {
        $response = $newChallanInvoiceItems->destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['data'] = $response ?? null;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param AddMultipleSalesOrderItemAction $salesOrderItemAction
     * @return array
     */
    public function saveItemsFromSalesOrder(Request $request, AddMultipleSalesOrderItemAction $salesOrderItemAction)
    {
        $salesOrderItemAction->handle($request);

        $data['message'] = 'Data Saved';
        $data['data'] = (object)[];
        return $data;
    }

    /**
     * @param $id
     * @param NewChallanInvoiceItems $newChallanInvoiceItems
     * @return mixed
     */
    public function getChallanInvoiceItem($id, NewChallanInvoiceItems $newChallanInvoiceItems)
    {
        $response = $newChallanInvoiceItems->getData(['challanInvoiceId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return $data;
    }

    /**
     * @param $id
     * @param NewChallanInvoiceItems $newChallanInvoiceItems
     * @return mixed
     */
    public function getChallaInvoiceItemOptions($id, NewChallanInvoiceItems $newChallanInvoiceItems)
    {
        $items = $newChallanInvoiceItems->getData(['challanInvoiceId' => $id]);
        foreach ($items as $key => $item) {
            $response[$key]['label'] = $item->itemCode;
            $response[$key]['value'] = $item->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }
}
