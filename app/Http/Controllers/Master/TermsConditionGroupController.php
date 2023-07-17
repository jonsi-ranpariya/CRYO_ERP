<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\InvoiceTypeMaster;
use App\Models\Master\TermsConditionGroupMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TermsConditionGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = TermsConditionGroupMaster::all();

        $data['message'] = "TermsConditionGroupMaster Found";
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
        $party_master = TermsConditionGroupMaster::saveData($dataInsert);

        $data['message'] = "TermsConditionGroupMaster Saved";
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
        $responce = TermsConditionGroupMaster::getDataFromId($id);

        $data['message'] = "TermsConditionGroupMaster found";
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
        $updateData = TermsConditionGroupMaster::updateData($id, $request->all());

        $data['message'] = "TermsConditionGroupMaster Updated";
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
        $group = TermsConditionGroupMaster::with('termDetailsData')->find($id);
        if ($group->termDetailsData->isNotEmpty()) {
            return jsonData(['message' => 'Group Already in used'], Response::HTTP_BAD_REQUEST);
        }

        TermsConditionGroupMaster::destroyData($id);

        $data['message'] = "Item Category Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getAllTermsConditionGroup()
    {
        $fetchData = TermsConditionGroupMaster::getData(['companyId' => 1]);
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->groupCode . ' - ' . $value->groupDescription;
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
    public function checkTermConditionCodeExist(Request $request)
    {
        $data = $request->all();

        if (isset($data['id']) && !empty($data['id'])) {

            $exists = TermsConditionGroupMaster::checkExistsWithId($data['id'], ['groupCode' => $data['groupCode']]);

        } else {

            $exists = TermsConditionGroupMaster::checkExists(['groupCode' => $data['groupCode']]);

        }

        $data['message'] = "Group Code check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
