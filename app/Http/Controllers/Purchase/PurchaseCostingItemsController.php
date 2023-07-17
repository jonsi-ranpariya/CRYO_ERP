<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseCostingItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseCostingItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = PurchaseCostingItems::all();

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
        $response = PurchaseCostingItems::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  PurchaseCostingItems  $purchaseCostingItems
     * @return JsonResponse
     */
    public function show(PurchaseCostingItems $purchaseCostingItems)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseCostingItems;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @param PurchaseCostingItems $purchaseCostingItems
     * @return JsonResponse
     */
    public function update($id, Request $request, PurchaseCostingItems $purchaseCostingItems)
    {
        $dataUpdate = $request->all();
        $response = $purchaseCostingItems->updateData($id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param PurchaseCostingItems $purchaseCostingItems
     * @return JsonResponse
     */
    public function destroy($id, PurchaseCostingItems $purchaseCostingItems)
    {
        $data['message'] = 'Data Deleted';
        $data['data'] = $purchaseCostingItems->destroyData($id);
        return jsonData($data);
    }

    /**
     * @param $id
     * @param PurchaseCostingItems $purchaseCostingItems
     * @return JsonResponse
     */
    public function getPurchaseCostingItems($id, PurchaseCostingItems $purchaseCostingItems)
    {
        $response = $purchaseCostingItems->getData(['purchaseCostingId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
