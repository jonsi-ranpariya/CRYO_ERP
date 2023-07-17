<?php

namespace App\Http\Controllers\SalesCrm;

use App\Actions\Sales\salesReturnInsertAction;
use App\Http\Controllers\Controller;
use App\Models\SalesCrm\SalesReturn;
use App\Models\SalesCrm\SalesReturnItems;
use App\Models\SalesCrm\SrBillingTerms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalesReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data['message'] = "Sales Return Found";
        $data['status'] = 200;
        $data['data'] = SalesReturn::all();
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
        $data['message'] = "Sales Return Saved";
        $data['status'] = 200;
        $data['data'] = salesReturnInsertAction::run($request);
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
        $data['message'] = "Sales Return found";
        $data['status'] = 200;
        $data['data'] = SalesReturn::getDataFromId($id);
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
        $response = SalesReturn::updateData($id, $updateData);

        $data['message'] = "Sales Return Updated";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        SalesReturn::destroy($id);
        SalesReturnItems::deleteData(['salesReturnId' => $id]);
        SrBillingTerms::deleteData(['salesReturnId' => $id]);

        $data['message'] = "Sales Return Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getFinalAmountAndItems(string $id): JsonResponse
    {
        $salesReturn = SalesReturn::getDataFromId($id);
        $roundingType = (int)$salesReturn->salesReturnRounding;
        $data['itemList'] = $this->getMasterGstItemList(SalesReturnItems::getData(['salesReturnId' => $id]), $roundingType);
        $data['itemValueDetail'] = $this->getMasterGstFinalTotalValue($data['itemList'], $roundingType);
        return jsonData($data);
    }

    /**
     * @param object|null $salesReturnItems
     * @param int $roundingType
     * @return array
     */
    protected function getMasterGstItemList(?object $salesReturnItems, int $roundingType): array
    {
        foreach ($salesReturnItems as $key => $item) {
            $index = $key + 1;
            $itemList[$key]['SlNo'] = "$index";
            $itemList[$key]['PrdDesc'] = $item->itemCustomDescription ?? $item->itemName;
            $itemList[$key]['IsServc'] = 'Y';
            $itemList[$key]['HsnCd'] = $item->itemHsnSacNo;
            $itemList[$key]['Qty'] = (float)$item->itemQuantity;
            $itemList[$key]['Unit'] = $item->uom_details->uomEinvoice ?? $item->uom_details->uomEwayBill;
            $itemList[$key]['UnitPrice'] = $roundingType !== 0 ? round($item->itemRate) : $item->itemRate;
            $itemList[$key]['TotAmt'] = $roundingType !== 0 ? round($item->itemAmount) : (float)number_format($item->itemAmount, 2);
            $itemList[$key]['AssAmt'] = $roundingType !== 0 ? round($item->itemAmount) : (float)number_format($item->itemAmount, 2);
            $gstRate = $item->igstPercentage !== 0 ? $item->igstPercentage : $item->cgstPercentage + $item->sgstPercentage;
            $itemList[$key]['GstRt'] = (int)$gstRate;
            $itemList[$key]['CesRt'] = 0.0;
            $itemList[$key]['CesAmt'] = 0.0;
            $itemList[$key]['CesNonAdvlAmt'] = 0.0;
            $itemList[$key]['StateCesRt'] = 0.0;
            $itemList[$key]['StateCesAmt'] = 0.0;
            $itemList[$key]['StateCesNonAdvlAmt'] = 0.0;
            $itemList[$key]['OthChrg'] = 0.0;
            $itemList[$key]['IgstAmt'] = $roundingType !== 0 ? round($item->igstAmount) : $item->igstAmount;
            $itemList[$key]['CgstAmt'] = $roundingType !== 0 ? round($item->cgstAmount) : $item->cgstAmount;
            $itemList[$key]['SgstAmt'] = $roundingType !== 0 ? round($item->sgstAmount) : $item->sgstAmount;
            $itemList[$key]['Discount'] = 0.0;
            $totalAmount = $itemList[$key]['AssAmt'] + $itemList[$key]['IgstAmt'] + $itemList[$key]['CgstAmt'] + $itemList[$key]['SgstAmt'];
            $itemList[$key]['TotItemVal'] = $roundingType !== 0 ? round($totalAmount) : (float)number_format($totalAmount, 2);
        }

        return $itemList ?? [];
    }

    /**
     * @param array|null $items
     * @param int $roundingType
     * @return array
     */
    protected function getMasterGstFinalTotalValue(?array $items, int $roundingType): array
    {
        $finalValue['AssVal'] = 0.0;
        $finalValue['TotInvVal'] = 0.0;
        $finalValue['IgstVal'] = 0.0;
        $finalValue['SgstVal'] = 0.0;
        $finalValue['CgstVal'] = 0.0;
        $finalValue['OthChrg'] = 0.0;

        if (count($items) > 0) {
            foreach ($items as $item) {
                $finalValue['AssVal'] += (float)$item['AssAmt'] + (float)$item['OthChrg'];
                $finalValue['IgstVal'] += (float)$item['IgstAmt'];
                $finalValue['SgstVal'] += (float)$item['SgstAmt'];
                $finalValue['CgstVal'] += (float)$item['CgstAmt'];
                $finalValue['OthChrg'] += 0;
                $finalValue['TotInvVal'] += (float)$item['AssAmt'] + (float)$item['IgstAmt'] + (float)$item['CgstAmt'] + (float)$item['SgstAmt'] + (float)$item['OthChrg'];
            }
        }

        if ($roundingType !== 0) {
            $finalValue['AssVal'] = round($finalValue['AssVal']);
            $finalValue['TotInvVal'] = round($finalValue['TotInvVal']);
            $finalValue['IgstVal'] = round($finalValue['IgstVal']);
            $finalValue['SgstVal'] = round($finalValue['SgstVal']);
            $finalValue['CgstVal'] = round($finalValue['CgstVal']);
            $finalValue['OthChrg'] = round($finalValue['OthChrg']);
        }

        return $finalValue;
    }
}
