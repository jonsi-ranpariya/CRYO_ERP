<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\DefaultTermsConditionDetailsMaster;
use App\Models\ProductionPlanning\ShowIssueItems;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DefaultTermsConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
//        query()->with('tcDetails')->get()
        $fetchData = DefaultTermsConditionDetailsMaster::all();

        $data['message'] = "DefaultTermsConditionDetailsMaster Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
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
        $party_master = DefaultTermsConditionDetailsMaster::saveData($dataInsert);

        $data['message'] = "DefaultTermsConditionDetailsMaster Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = DefaultTermsConditionDetailsMaster::getDataFromId($id);

        $data['message'] = "DefaultTermsConditionDetailsMaster found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  DefaultTermsConditionDetailsMaster  $defaultTermsConditionDetailsMaster
     * @return JsonResponse
     */
    public function update(Request $request, DefaultTermsConditionDetailsMaster $defaultTermsConditionDetailsMaster)
    {
        $dataUpdate = $request->all();
        $response = $defaultTermsConditionDetailsMaster->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        DefaultTermsConditionDetailsMaster::destroy($id);

        $data['message'] = "Item Category Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    public function getTermAndConditionOptions(Request $request)
    {
        $fetchData = DefaultTermsConditionDetailsMaster::getRelationData(
            ['tcFor' => $request->type],
            ['groupData:_id,groupDescription']
        );

        foreach ($fetchData as $key => $value){
            $response[$key]['label'] = $value->groupData->groupDescription;
            $response[$key]['value'] = $value->_id;
        }

        $data['status'] = 200;
        $data['message'] = "Data Found";
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getDefaultTerm($type)
    {
        $response = DefaultTermsConditionDetailsMaster::getFirstData(['tcFor' => (int)$type]);
        $data['status'] = 200;
        $data['message'] = "Data Found";
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkDefaultTemsConditionMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = DefaultTermsConditionDetailsMaster::checkExistsWithId($data['id'], ['tcFor' => $data['tcFor']]);

        }else{

            $exists = DefaultTermsConditionDetailsMaster::checkExists(['tcFor' => $data['tcFor']]);

        }

        $data['message'] = "Default Terms Condition For Check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
