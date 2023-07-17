<?php

namespace App\Http\Controllers\JobWork;

use App\Http\Controllers\Controller;
use App\Models\JobWork\RawMaterial;
use App\Models\JobWork\RawMaterialSubContractorItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = RawMaterial::all();
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param RawMaterial $rawMaterial
     * @return JsonResponse
     */
    public function store(Request $request, RawMaterial $rawMaterial)
    {
        $dataInsert = $request->all();
        $latest = $rawMaterial->query()->latest()->first();

        if (!$latest) {
            $newNumber = 'R00001';
        } else {
            $string = preg_replace("/[^0-9\.]/", '', $latest->returnNo);
            $newNumber =  'R' .sprintf('%05d', $string + 1);
        }
        $dataInsert['returnNo'] = $newNumber;
        $response = $rawMaterial->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  RawMaterial  $rawMaterial
     * @return JsonResponse
     */
    public function show(RawMaterial $rawMaterial)
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $rawMaterial;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param RawMaterial $rawMaterial
     * @return JsonResponse
     */
    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $dataUpdated = $request->all();
        $response = $rawMaterial->updateData($rawMaterial->_id, $dataUpdated);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        RawMaterial::destroyData($id);
        RawMaterialSubContractorItems::deleteData(['rawId' => $id]);

        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }
}
