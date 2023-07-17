<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Master\DefaultTermsConditionDetailsMaster;
use App\Models\Master\DefaultTermsConditionItem;
use App\Models\Master\TermsConditionTemplateItemMaster;
use App\Models\Partymaster\TermAndCondition;
use App\Models\Purchase\PurchaseOrderTermCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

class PurchaseOrderTermConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = PurchaseOrderTermCondition::all();

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
        $response = PurchaseOrderTermCondition::saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  PurchaseOrderTermCondition  $purchaseOrderTermCondition
     * @return JsonResponse
     */
    public function show(PurchaseOrderTermCondition $purchaseOrderTermCondition)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $purchaseOrderTermCondition;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  PurchaseOrderTermCondition  $purchaseOrderTermCondition
     * @return JsonResponse
     */
    public function update(Request $request, PurchaseOrderTermCondition $purchaseOrderTermCondition)
    {
        $dataUpdate = $request->all();
        $response = $purchaseOrderTermCondition->updateData($purchaseOrderTermCondition->_id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PurchaseOrderTermCondition  $purchaseOrderTermCondition
     * @return JsonResponse
     */
    public function destroy(PurchaseOrderTermCondition $purchaseOrderTermCondition)
    {
        $data['message'] = 'Data Delete';
        $data['data'] = $purchaseOrderTermCondition->delete();
        return jsonData($data);
    }

    /**
     * @param $referenceId
     * @param PurchaseOrderTermCondition $purchaseOrderTermCondition
     * @return JsonResponse
     */
    public function getPurchaseOrderTermCondition($referenceId, PurchaseOrderTermCondition $purchaseOrderTermCondition)
    {
        $response = $purchaseOrderTermCondition->getData(['purchaseOrderId' => $referenceId]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addPoTermConditionFromTemplateData(Request $request): JsonResponse
    {
        $templateId = $request->templateId;
        $purchaseOrderId = $request->purchaseOrderId;
        $items = TermsConditionTemplateItemMaster::getData(['templateId' => $templateId]);
        $items->each(function (TermsConditionTemplateItemMaster $item) use ($purchaseOrderId) {
            PurchaseOrderTermCondition::saveData([
                'purchaseOrderId' => $purchaseOrderId,
                'groupId' => $item->tcGroup ?? null,
                'groupName' => $item->groupName ?? null,
                'termsCondition' => $item->tcDescription ?? null,
            ]);
        });

        $data['message'] = 'Template Inserted';
        $data['data'] = true;
        return jsonData($data);
    }

    public function copyPoDefaultTermAndCondition(Request $request): JsonResponse
    {
        $purchaseOrderId = $request->purchaseOrderId;
        $template = DefaultTermsConditionDetailsMaster::query()
            ->with('billingItems')
            ->where(['tcFor' => 3])
            ->latest()
            ->first();

        if (!empty($template)){
            $template->billingItems()->each(function (DefaultTermsConditionItem $item) use ($purchaseOrderId) {
                PurchaseOrderTermCondition::saveData([
                    'purchaseOrderId' => $purchaseOrderId,
                    'groupId' => $item->tcGroup ?? null,
                    'groupName' => $item->tcGroupName ?? null,
                    'termsCondition' => $item->tcDescription ?? null
                ]);
            });
        }

        $data['message'] = 'Template Inserted';
        $data['data'] = null;
        return jsonData($data);
    }

    public function getPoTermConditionFromPartyMaster(Request $request): JsonResponse
    {
        $partyId = $request->partyId;
        $purchaseOrderId = $request->purchaseOrderId;
        $items = TermAndCondition::getData(['partyId' => $partyId]);

        $items->each(function (TermAndCondition $item) use ($purchaseOrderId) {
            PurchaseOrderTermCondition::saveData([
                'purchaseOrderId' => $purchaseOrderId,
                'groupId' => $item->group ?? null,
                'groupName' => $item->groupName ?? null,
                'termsCondition' => $item->termDetails ?? null
            ]);
        });

        $data['shortMessage'] = 'Copied';
        $data['message'] = 'Term And Condition Copied Successfully';
        $data['variant'] = 'success';
        $data['icon'] = 'CheckSquareIcon';
        return jsonData($data);
    }

    /**
     * @param $purchaseOrderId
     * @return JsonResponse
     */
    public function getTermsAndConditionListQc($purchaseOrderId): JsonResponse
    {
        $response = PurchaseOrderTermCondition::query()
            ->where('purchaseOrderId', $purchaseOrderId)
            ->get();

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }

}
