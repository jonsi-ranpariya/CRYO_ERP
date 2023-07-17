<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\TaxMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaxMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = TaxMaster::all();

        $data['message'] = "TaxMaster Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data, Response::HTTP_OK);
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
        $party_master = TaxMaster::saveData($dataInsert);

        $data['message'] = "TaxMaster Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $responce = TaxMaster::getDataFromId($id);

        $data['message'] = "TaxMaster found";
        $data['status'] = 200;
        $data['data'] = $responce;
        return jsonData($data, Response::HTTP_OK);
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
        $updateData = TaxMaster::updateData($id, $request->all());

        $data['message'] = "TaxMaster Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        TaxMaster::destroyData($id);

        $data['message'] = "Item Category Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getAllTaxMaster()
    {
        $fetchData = TaxMaster::getData(['companyId' => 1]);
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->taxDescription;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Category Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkTaxMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = TaxMaster::checkExistsWithId($data['id'], ['taxDescription' => $data['taxDescription']]);

        }else{

            $exists = TaxMaster::checkExists(['taxDescription' => $data['taxDescription']]);

        }


        $data['message'] = "Item Description Check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
