<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\ProductionPlanning\JobCardReturnShop;
use App\Models\ProductionPlanning\JobCardReturnShopItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobCardReturnShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param JobCardReturnShop $jobCardReturnShop
     * @return JsonResponse
     */
    public function index(JobCardReturnShop $jobCardReturnShop)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $jobCardReturnShop->getData();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param JobCardReturnShop $jobCardReturnShop
     * @return JsonResponse
     */
    public function store(Request $request, JobCardReturnShop $jobCardReturnShop)
    {
        $dataInsert = $request->all();
        $latest = $jobCardReturnShop->query()->latest()->first();

        if (!$latest) {
            $newNumber = '00001';
        } else {
            $string = preg_replace("/[^0-9\.]/", '', $latest->returnNumber);
            $newNumber = sprintf('%05d', $string + 1);
        }

        $dataInsert['returnNumber'] = $newNumber;

        $response = $jobCardReturnShop->saveData($dataInsert);
        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param JobCardReturnShop $jobCardReturnShop
     * @return JsonResponse
     */
    public function show(JobCardReturnShop $jobCardReturnShop)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $jobCardReturnShop;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param JobCardReturnShop $jobCardReturnShop
     * @return JsonResponse
     */
    public function update(Request $request, JobCardReturnShop $jobCardReturnShop)
    {
        $dataUpdate = $request->all();

        $response = $jobCardReturnShop->updateData($jobCardReturnShop->_id, $dataUpdate);
        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param JobCardReturnShop $jobCardReturnShop
     * @param JobCardReturnShopItem $jobCardReturnShopItem
     * @return JsonResponse
     */
    public function destroy(JobCardReturnShop $jobCardReturnShop, JobCardReturnShopItem $jobCardReturnShopItem)
    {
        $jobCardReturnShopItem->deleteData(['returnId' => $jobCardReturnShop->_id]);
        $jobCardReturnShop->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = [];
        return jsonData($data);
    }
}
