<?php

namespace App\Http\Controllers\SalesCrm;

use App\Http\Controllers\Controller;
use App\Models\Master\DefaultTermsConditionDetailsMaster;
use App\Models\Master\TermsConditionTemplateItemMaster;
use App\Models\Partymaster\TermAndCondition;
use App\Models\SalesCrm\SalesOrderTermCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalesOrderTermConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $fetchData = SalesOrderTermCondition::all();

        $data['message'] = "Sales Order Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $dataInsert = $request->all();

        $party_master = SalesOrderTermCondition::saveData($dataInsert);

        $data['message'] = "Sales Quotation Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $response = SalesOrderTermCondition::getDataFromId($id);

        $data['message'] = "Sales Quotation found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $updateData = $request->all();

        $response = SalesOrderTermCondition::updateData($id, $updateData);

        $data['message'] = "Sales Quotation Updated";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param String $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        SalesOrderTermCondition::destroy($id);

        $data['message'] = "Sales Quotation Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getSalesOrderTermConditionDetails($id): JsonResponse
    {
        $partyData = SalesOrderTermCondition::getData(['salesOrderId' => $id]);
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $partyData;
        return jsonData($data);
    }

    public function getTermConditionFromPartyMaster(Request $request): JsonResponse
    {
        $partyId = $request->partyId;
        $salesOrderId = $request->salesOrderId;
        $response = TermAndCondition::getData(['partyId' => $partyId]);

        foreach ($response as $value) {
            $dataInsert['salesOrderId'] = $salesOrderId;
            $dataInsert['termConditionId'] = $value->group['value'] ?? null;
            $dataInsert['termGroupName'] = $value->groupName;
            $dataInsert['termDetail'] = $value->termDetails;
            $dataInsert['termConditionFor'] = null;
            SalesOrderTermCondition::saveData($dataInsert);
        }

        if ($response->isNotEmpty()) {
            $data['shortMessage'] = 'Copied';
            $data['message'] = 'Term And Condition Copied Successfully';
            $data['variant'] = 'success';
            $data['icon'] = 'CheckSquareIcon';
        } else {
            $data['shortMessage'] = 'Empty';
            $data['message'] = 'No data found.';
            $data['variant'] = 'warning';
            $data['icon'] = 'AlertCircleIcon';
        }

        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addTermConditionFromTemplate(Request $request): JsonResponse
    {
        $templateId = $request->templateId;
        $salesOrderId = $request->salesOrderId;
        $items = TermsConditionTemplateItemMaster::getData(['templateId' => $templateId]);
        foreach ($items as $item) {
            $dataInsert = [
                'salesOrderId' => $salesOrderId,
                'termConditionId' => $item->tcGroup ?? null,
                'termGroupName' => $item->groupName,
                'termDetail' => $item->tcDescription,
                'termConditionFor' => null
            ];
            SalesOrderTermCondition::saveData($dataInsert);
        }

        $data['message'] = 'Template Inserted';
        $data['data'] = true;
        return jsonData($data);
    }

    public function copyDefaultTermAndCondition(Request $request)
    {
        $salesOrderId = $request->salesOrderId;
        $template = DefaultTermsConditionDetailsMaster::query()->where(['tcFor' => 2])->latest()->first();
        foreach ($template->billing_items as $billingItem) {
            $dataInsert = [
                'salesOrderId' => $salesOrderId,
                'termConditionId' => $billingItem->tcGroup ?? null,
                'termGroupName' => $billingItem->tcGroupName,
                'termDetail' => $billingItem->tcDescription,
                'termConditionFor' => null
            ];
            SalesOrderTermCondition::saveData($dataInsert);
        }

        $data['message'] = 'Template Inserted';
        $data['data'] = true;
        return jsonData($data);
    }
}
