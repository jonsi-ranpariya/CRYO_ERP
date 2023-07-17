<?php

namespace App\Http\Controllers\Partymaster;

use App\Http\Controllers\Controller;
use App\Models\Master\TermsConditionTemplateItemMaster;
use App\Models\Partymaster\TermAndCondition;
use App\Models\SalesCrm\SalesOrderTermCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TermAndConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = TermAndCondition::all();

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $data;
        return jsonData($res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $response = TermAndCondition::saveData($data);

        $res['status'] = 200;
        $res['message'] = 'Data Submit';
        $res['data'] = $response;
        return jsonData($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = TermAndCondition::getDataFromId($id);

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $data;
        return jsonData($res);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $response = TermAndCondition::updateData($id, $data);

        $res['status'] = 200;
        $res['message'] = 'Data Updated';
        $res['data'] = $response;
        return jsonData($res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        TermAndCondition::destroy($id);

        $res['status'] = 200;
        $res['message'] = 'Data Deleted';
        $res['data'] = [];
        return jsonData($res);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getDataPartyWise($id)
    {
        $response = TermAndCondition::getData(['partyId' => $id]);

        $res['status'] = 200;
        $res['message'] = 'Data Found';
        $res['data'] = $response;
        return jsonData($res);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addTermConditionFromTemplateData(Request $request): JsonResponse
    {
        $templateId = $request->templateId;
        $partyId = $request->partyId;
        $items = TermsConditionTemplateItemMaster::getData(['templateId' => $templateId]);
        foreach ($items as $item) {
            $dataInsert = [
                'partyId' => $partyId,
                'group' => $item->tcGroup ?? null,
                'groupName' => $item->groupName,
                'termDetails' => $item->tcDescription,
            ];
            TermAndCondition::saveData($dataInsert);
        }

        $data['message'] = 'Template Inserted';
        $data['data'] = true;
        return jsonData($data);
    }

}
