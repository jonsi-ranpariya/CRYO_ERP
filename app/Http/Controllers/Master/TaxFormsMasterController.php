<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\TaxFormsMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaxFormsMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = TaxFormsMaster::all();

        $data['message'] = "TaxFormsMaster Found";
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
        $party_master = TaxFormsMaster::saveData($dataInsert);

        $data['message'] = "TaxFormsMaster Saved";
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
        $responce = TaxFormsMaster::getDataFromId($id);

        $data['message'] = "TaxFormsMaster found";
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
        $updateData = TaxFormsMaster::updateData($id, $request->all());

        $data['message'] = "TaxFormsMaster Updated";
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
        TaxFormsMaster::destroyData($id);

        $data['message'] = "Item Category Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getAllTaxFormsMaster()
    {
        $fetchData = TaxFormsMaster::getData(['companyId' => 1])->get();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->formName;
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
    public function checkTaxFormsMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = TaxFormsMaster::checkExistsWithId($data['id'], ['formName' => $data['formName']]);

        }else{

            $exists = TaxFormsMaster::checkExists(['formName' => $data['formName']]);

        }

        $data['message'] = "Item Description Check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
