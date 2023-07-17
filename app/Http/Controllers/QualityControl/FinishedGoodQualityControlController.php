<?php

namespace App\Http\Controllers\QualityControl;

use App\Http\Controllers\Controller;
use App\Models\QualityControl\FinishedGoodQualityControl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FinishedGoodQualityControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $response = FinishedGoodQualityControl::all();

        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);

    }

    /**
     * Store a newly created resource in storage.
     * @param FinishedGoodQualityControl $finishedGoodQualityControl
     * @param Request  $request
     * @return JsonResponse
     */
    public function store(Request $request, FinishedGoodQualityControl $finishedGoodQualityControl) : JsonResponse
    {
        $dataInsert = $request->all();
        $response = $finishedGoodQualityControl->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  FinishedGoodQualityControl  $finishedGoodQualityControl
     * @return JsonResponse
     */
    public function show(FinishedGoodQualityControl $finishedGoodQualityControl): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $finishedGoodQualityControl;
        return jsonData($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param  FinishedGoodQualityControl  $finishedGoodQualityControl
     * @return JsonResponse
     */
    public function update(Request $request, FinishedGoodQualityControl $finishedGoodQualityControl): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $finishedGoodQualityControl->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param FinishedGoodQualityControl  $finishedGoodQualityControl
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        FinishedGoodQualityControl::destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        return jsonData($data);
    }
}
