<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\TermsConditionDetailsMaster;
use App\Models\Master\TermsConditionGroupMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TermsConditionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = TermsConditionDetailsMaster::query()->with('tcGroupDetails')->get();

        $data['message'] = "TermsConditionDetailsMaster Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param TermsConditionDetailsMaster $termsConditionDetailsMaster
     * @return JsonResponse
     */
    public function store(Request $request, TermsConditionDetailsMaster $termsConditionDetailsMaster)
    {
        $dataInsert = $request->all();
        $groupCode = TermsConditionGroupMaster::getDataFromId($dataInsert['tcGroup'])->groupCode;

        $latest = TermsConditionDetailsMaster::query()->latest()->first();
        if (!$latest) {
            $newNumber = $groupCode . '001';
        } else {
            $string = preg_replace("/[^a-zA-Z0-9]/", '', $latest->tcGroupCode);
            $newString = (int)str_replace($groupCode,'',$string);
            $newNumber = $groupCode.sprintf('%03d', $newString + 1);
        }
        $dataInsert['tcGroupCode'] = $newNumber;
        $response = $termsConditionDetailsMaster->saveData($dataInsert);

        $data['message'] = "TermsConditionDetailsMaster Saved";
        $data['status'] = 200;
        $data['data'] = $response;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = TermsConditionDetailsMaster::with('tcGroupDetails')->find($id);

        $data['message'] = "TermsConditionDetailsMaster found";
        $data['status'] = 200;
        $data['data'] = $response;
        return new JsonResponse($data, Response::HTTP_OK);
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
        $updateData = TermsConditionDetailsMaster::updateData($id, $request->all());

        $data['message'] = "TermsConditionDetailsMaster Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        TermsConditionDetailsMaster::destroy($id);

        $data['message'] = "Item Category Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getAllTermsConditionDetails()
    {
        $fetchData = TermsConditionDetailsMaster::getData(['companyId' => 1]);
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->tcGroup;
            $response[$key]['value'] = $value->_id;
        }
        $data['message'] = "Category Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    //dropdown relation
    public function getTermAndConditionWithGroup()
    {
        $fetchData = TermsConditionDetailsMaster::getRelationData(['companyId' => 1], ['tcGroupDetails:_id,groupCode,groupDescription']);
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->tcGroupDetails->groupDescription . ' - ' . $value->tcGroupCode;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        $data['status'] = 200;
        return jsonData($data);
    }

    public function getTermAndConditionWithGroupDetails($id)
    {
        $fetchData = TermsConditionDetailsMaster::getFindRelationData($id, ['tcGroupDetails']);

        $data['message'] = 'Data Found';
        $data['data'] = $fetchData ?? [];
        $data['status'] = 200;
        return jsonData($data);
    }
}
