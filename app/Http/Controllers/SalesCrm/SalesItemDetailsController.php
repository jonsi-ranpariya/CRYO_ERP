<?php

namespace App\Http\Controllers\SalesCrm;

use App\Http\Controllers\Controller;
use App\Models\SalesCrm\SalesItemDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SalesItemDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = SalesItemDetails::getData(['companyId' => 1]);

        $res['status'] = 200;
        $res['message'] = "Data Found";
        $res['data'] = $fetchData;
        return jsonData($res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $response = SalesItemDetails::saveData($data);

        $res['status'] = 200;
        $res['message'] = "Data Inserted";
        $res['data'] = $response;
        return jsonData($res);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $fetchData = SalesItemDetails::getDataFromId($id);

        $res['status'] = 200;
        $res['message'] = "Data Found";
        $res['data'] = $fetchData;
        return jsonData($res);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $response = SalesItemDetails::updateData($id, $data);

        $res['status'] = 200;
        $res['message'] = "Data Updated";
        $res['data'] = $response;
        return jsonData($res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        SalesItemDetails::destroy($id);

        $res['status'] = 200;
        $res['message'] = "Data Deleted";
        $res['data'] = [];
        return jsonData($res);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getSalesItemsDetails($id)
    {
        $fetchData = SalesItemDetails::getRelationData(['companyId' => 1, 'salesIqID' => $id], ['uomDetails:_id,uom']);

        $res['status'] = 200;
        $res['message'] = "Data Found";
        $res['data'] = $fetchData;
        return jsonData($res);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSalesItemList(Request $request)
    {
        $data = $request->all();
        $itemList = collect(SalesItemDetails::withWhereInData('_id', $data['ids'], ['uomDetails:_id,uom']));

        $itemList->each(function ($item){
            Arr::add($item, 'amount', 0);
            Arr::add($item, 'rate', 0);
            Arr::add($item, 'qty', 0);
            Arr::add($item, 'netAmount', 0);
            Arr::add($item, 'discValue', 0);
            Arr::add($item, 'discPercent', 0);
            Arr::add($item, 'totalAmount', 0);
            Arr::forget($item, 'status');
            Arr::add($item, 'status', 0);
        });

        $data['message'] = "Item List";
        $data['status'] = 200;
        $data['data'] = $itemList;
        return jsonData($data);
    }
}
