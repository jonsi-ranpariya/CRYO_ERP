<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\DefaultTermsConditionItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DefaultTermsConditionItemController extends Controller
{
//query()->with('tcDetails')->get()
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
{
    $fetchData = DefaultTermsConditionItem::all();

    $data['message'] = "TermsConditionTemplateMaster Found";
    $data['status'] = 200;
    $data['data'] = $fetchData;
    return new JsonResponse($data, Response::HTTP_OK);
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
    $party_master = DefaultTermsConditionItem::saveData($dataInsert);

    $data['message'] = "TermsConditionTemplateMaster Saved";
    $data['status'] = 200;
    $data['data'] = $party_master;
    return new JsonResponse($data, Response::HTTP_OK);
}
//with('tcDetails')->find($id)
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
{
    $response = DefaultTermsConditionItem::query()->with('tcDetails')->find($id);

    $data['message'] = "TermsConditionTemplateItemMaster found";
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
    $dataUpdate = $request->all();
    $response = DefaultTermsConditionItem::updateData($id, $dataUpdate);

    $data['status'] = 200;
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
    DefaultTermsConditionItem::destroy($id);

    $data['message'] = "Item Category Master Deleted";
    $data['status'] = 200;
    $data['data'] = [];
    return new JsonResponse($data, Response::HTTP_OK);
}

}
