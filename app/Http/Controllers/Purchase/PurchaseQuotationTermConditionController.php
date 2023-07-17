<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseOrderBillingTerm;
use App\Models\Purchase\PurchaseOrderTermCondition;
use App\Models\Purchase\PurchaseQuotationTermCondition;
use App\Models\Master\TermsConditionTemplateItemMaster;
use App\Models\Master\DefaultTermsConditionDetailsMaster;
use App\Models\Partymaster\TermAndCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseQuotationTermConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = PurchaseQuotationTermCondition::all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
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
        $response = PurchaseQuotationTermCondition::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  PurchaseQuotationTermCondition  $PurchaseQuotationTermCondition
     * @return JsonResponse
     */
    public function show(PurchaseQuotationTermCondition $PurchaseQuotationTermCondition)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $PurchaseQuotationTermCondition;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  PurchaseQuotationTermCondition  $PurchaseQuotationTermCondition
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseQuotationTermCondition $PurchaseQuotationTermCondition)
    {
        $dataUpdate = $request->all();
        $response = $PurchaseQuotationTermCondition->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
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
        PurchaseQuotationTermCondition::destroy($id);

        $data['message'] = "Purchase Quotation Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param $referenceId
     * @param PurchaseQuotationTermCondition $PurchaseQuotationTermCondition
     * @return JsonResponse
     */
    public function getPurchaseQuotationTermCondition($referenceId, PurchaseQuotationTermCondition $PurchaseQuotationTermCondition)
    {
        $response = $PurchaseQuotationTermCondition->getData(['purchaseQuotationId' => $referenceId]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addPqTermConditionFromTemplateData(Request $request): JsonResponse
    {
        $templateId = $request->templateId;
        $purchaseQuotationId = $request->purchaseQuotationId;
        $items = TermsConditionTemplateItemMaster::getData(['templateId' => $templateId]);
        foreach ($items as $item) {
            $dataInsert = [
                'purchaseQuotationId' => $purchaseQuotationId,
                'groupId' => $item->tcGroup ?? null,
                'groupDescription' => $item->groupName,
                'termsCondition' => $item->tcDescription,
            ];
            PurchaseQuotationTermCondition::saveData($dataInsert);
        }

        $data['message'] = 'Template Inserted';
        $data['data'] = true;
        return jsonData($data);
    }

    public function copyPqDefaultTermAndCondition(Request $request)
    {
        $purchaseQuotationId = $request->purchaseQuotationId;
        $template = DefaultTermsConditionDetailsMaster::query()->where(['tcFor' => 1])->latest()->first();
        if (!empty($template)){
            foreach ($template->billing_items as $billingItem) {
                $dataInsert = [
                    'purchaseQuotationId' => $purchaseQuotationId,
                    'groupId' => $billingItem->tcGroup ?? null,
                    'groupDescription' => $billingItem->tcGroupName ?? null,
                    'termsCondition' => $billingItem->tcDescription,
                ];
                PurchaseQuotationTermCondition::saveData($dataInsert);
            }
        }

        $data['message'] = 'Template Inserted';
        $data['data'] = true;
        return jsonData($data);
    }

    public function getPqTermConditionFromPartyMaster(Request $request): JsonResponse
    {
        $partyId = $request->partyId;
        $purchaseQuotationId = $request->purchaseQuotationId;
        $response = TermAndCondition::getData(['partyId' => $partyId]);

        foreach ($response as $value) {
            $dataInsert['purchaseQuotationId'] = $purchaseQuotationId;
            $dataInsert['groupId'] = $value->group ?? null;
            $dataInsert['groupDescription'] = $value->groupName ?? null;
            $dataInsert['termsCondition'] = $value->termDetails ?? null;
            PurchaseQuotationTermCondition::saveData($dataInsert);
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

}
