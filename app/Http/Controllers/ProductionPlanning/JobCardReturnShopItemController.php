<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\ProductionPlanning\JobCardReturnShopItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobCardReturnShopItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param JobCardReturnShopItem $jobCardReturnShopItem
     * @return JsonResponse
     */
    public function index(JobCardReturnShopItem $jobCardReturnShopItem)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $jobCardReturnShopItem->getData();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobCardReturnShopItem $jobCardReturnShopItem
     * @return JsonResponse
     */
    public function store(Request $request, JobCardReturnShopItem $jobCardReturnShopItem)
    {
        $dataInsert = $request->all();
        $response = $jobCardReturnShopItem->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param JobCardReturnShopItem $jobCardReturnShopItem
     * @return JsonResponse
     */
    public function show(JobCardReturnShopItem $jobCardReturnShopItem)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $jobCardReturnShopItem;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param JobCardReturnShopItem $jobCardReturnShopItem
     * @return JsonResponse
     */
    public function update(Request $request, JobCardReturnShopItem $jobCardReturnShopItem)
    {
        $dataUpdate = $request->all();
        $response = $jobCardReturnShopItem->updateData($jobCardReturnShopItem->_id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param JobCardReturnShopItem $jobCardReturnShopItem
     * @return JsonResponse
     */
    public function destroy(JobCardReturnShopItem $jobCardReturnShopItem)
    {
        $jobCardReturnShopItem->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param $id
     * @param JobCardReturnShopItem $jobCardReturnShopItem
     * @return JsonResponse
     */
    public function returnShopItems($id, JobCardReturnShopItem $jobCardReturnShopItem)
    {
        $response = $jobCardReturnShopItem->getData(['returnId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
