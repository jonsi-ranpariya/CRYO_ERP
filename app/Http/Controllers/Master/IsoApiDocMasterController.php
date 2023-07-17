<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\IsoApiDocMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IsoApiDocMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = IsoApiDocMaster::all();

        $data['message'] = "IsoApiDocMaster Found";
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
        $party_master = IsoApiDocMaster::saveData($dataInsert);

        $data['message'] = "IsoApiDocMaster Saved";
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
        $responce = IsoApiDocMaster::getDataFromId($id);

        $data['message'] = "IsoApiDocMaster found";
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
        $updateData = IsoApiDocMaster::updateData($id, $request->all());

        $data['message'] = "IsoApiDocMaster Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return jsonResponse
     */
    public function destroy($id)
    {
        IsoApiDocMaster::destroyData($id);

        $data['message'] = "Item Category Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getAllIsoApiDocMaster()
    {
        $fetchData = IsoApiDocMaster::getData(['companyId' => 1]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->docName;
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
    public function checkIsoApiDocMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

           //DB::enableQueryLog();

            $exists = IsoApiDocMaster::query()
                ->where('_id', '!=', $data['id'])
                ->where(['docName' => $data['docName']])->exists();

            if(!$exists){

                $exists = IsoApiDocMaster::query()
                    ->where('_id', '!=', $data['id'])
                    ->where(['docFormNo' => $data['docFormNo']])->exists();
            }


        }else{

            $exists = IsoApiDocMaster::query()
                ->where(['docName' => $data['docName']])
                ->orWhere(['docFormNo' => $data['docFormNo']])
                ->exists();

        }


        $data['message'] = "Item Description Check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
