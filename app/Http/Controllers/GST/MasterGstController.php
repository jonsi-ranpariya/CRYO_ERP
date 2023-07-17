<?php

namespace App\Http\Controllers\GST;

use App\Http\Controllers\Controller;
use App\Models\Despatch\NewChallanInvoice;
use App\Models\Despatch\NewChallanInvoiceBillingTerm;
use App\Models\Despatch\NewChallanInvoiceItems;
use App\Models\GST\MasterGst;
use App\Models\Purchase\PurchaseReturn;
use App\Models\Purchase\PurchaseReturnBilling;
use App\Models\Purchase\PurchaseReturnItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterGstController extends Controller
{
    public function saveIrnDetails(Request $request): JsonResponse
    {
        $dataInsert = $request->all();
        $response = MasterGst::saveData($dataInsert);
        return jsonData($response);
    }

    public function updateIrnDetails(Request $request): JsonResponse
    {
        $dataInsert = $request->all();
        if (isset($dataInsert['salesReturnId'])) {
            $where = ['salesReturnId' => $dataInsert['salesReturnId']];
        } elseif (isset($dataInsert['purchaseReturnId'])) {
            $where = ['purchaseReturnId' => $dataInsert['purchaseReturnId']];
        } else {
            $where = ['challanInvoiceId' => $dataInsert['challanInvoiceId']];
        }
        $updateData = MasterGst::query()->latest()->where($where)->first();
        $updateData->EwbNo = $dataInsert['EwbNo'];
        $updateData->EwbDt = $dataInsert['EwbDt'];
        $updateData->EwbValidTill = $dataInsert['EwbValidTill'];
        $updateData->update();

        return jsonData($updateData);
    }

    public function cancelIrnDetails(Request $request): JsonResponse
    {
        $dataInsert = $request->all();
        if (isset($dataInsert['salesReturnId'])) {
            $where = [
                'Irn' => $dataInsert['Irn'],
                'salesReturnId' => $dataInsert['salesReturnId']
            ];
        } elseif (isset($dataInsert['purchaseReturnId'])) {
            $where = [
                'Irn' => $dataInsert['Irn'],
                'purchaseReturnId' => $dataInsert['purchaseReturnId']
            ];
        } else {
            $where = [
                'Irn' => $dataInsert['Irn'],
                'challanInvoiceId' => $dataInsert['challanInvoiceId']
            ];
        }
        $updateData = MasterGst::query()->latest()->where($where)->first();
        $updateData->CancelDate = $dataInsert['CancelDate'];
        $updateData->update();

        return jsonData($updateData);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getPurchaseReturnItemsAndAmount(string $id): JsonResponse
    {
        $challanInvoice = PurchaseReturn::getDataFromId($id);
        $challanItems = PurchaseReturnItem::getData(['purchaseReturnId' => $id]);
        $challanBilling = PurchaseReturnBilling::getData(['purchaseReturnId' => $id]);
        $billingValues = $this->eInvoiceItemBillingTerm($challanBilling);
        $roundingType = (int)$challanInvoice->prRound;

        $data['itemList'] = $this->eInvoiceItemList($challanInvoice, $challanItems, $billingValues, $roundingType);
        $data['itemValueDetail'] = $this->eInvoiceFinalValueDetails($data['itemList'], $roundingType);
        return jsonData($data);
    }

    /**
     * @param object|null $data
     * @param object|null $items
     * @param array|null $billingValues
     * @param int $roundingType
     * @param bool $isForChallan
     * @return array
     */
    protected function eInvoiceItemList(?object $data,
                                        ?object $items,
                                        ?array  $billingValues,
                                        int     $roundingType,
                                        bool $isForChallan = false): array
    {
        foreach ($items as $key => $item) {
            $index = $key + 1;
            $itemList[$key]['SlNo'] = "$index";
            $itemList[$key]['PrdDesc'] = $item->itemCustomDescription ?? $item->itemDescription;
            if (isset($data->invoice)) {
                $isService = $data->invoice == 6;
            } else {
                $isService = checkInvoiceType(id: $data->prInvoiceType, invoiceType: 'SERVICE INVOICE');
            }
            $itemList[$key]['IsServc'] = $isService ? 'Y' : 'N';
            $itemList[$key]['HsnCd'] = $item->itemHsnSacNo ?? $item->itemHsnNumber;
            $itemList[$key]['Qty'] = (float)$item->itemQuantity;
            $itemList[$key]['Unit'] = $item->uom_details['uomEinvoice'] ?? $item->uom_detail['uomEinvoice'];
            $itemList[$key]['UnitPrice'] = (float)$item->itemRate;
            $totAmount = (float)$item->itemAmount + $this->getEInvoiceOtherCharges($billingValues) / $items->count();
            $itemList[$key]['TotAmt'] = $roundingType !== 0 ? round($totAmount) : $totAmount;
            $assAmount = (float)$item->itemNetAmount + $this->getEInvoiceOtherCharges($billingValues) / $items->count();
            $itemList[$key]['AssAmt'] = $roundingType !== 0 ? round($assAmount) : $assAmount;
            $itemList[$key]['GstRt'] = $this->getEInvoiceItemGstRate($item);
            $itemList[$key]['CesRt'] = 0.0;
            $itemList[$key]['CesAmt'] = 0.0;
            $itemList[$key]['CesNonAdvlAmt'] = 0.0;
            $itemList[$key]['StateCesRt'] = 0.0;
            $itemList[$key]['StateCesAmt'] = 0.0;
            $itemList[$key]['StateCesNonAdvlAmt'] = 0.0;
            $itemList[$key]['OthChrg'] = 0;
            if ($isForChallan) {
                $igstAmount = $roundingType !== 0 ? round(($itemList[$key]['AssAmt'] * $item->igstPercentage / 100)) : $itemList[$key]['AssAmt'] * $item->igstPercentage / 100;
            } else {
                $igstAmount = $roundingType !== 0 ? round(($itemList[$key]['AssAmt'] * $item->itemIgstPercent / 100)) : $itemList[$key]['AssAmt'] * $item->itemIgstPercent / 100;
            }
            $itemList[$key]['IgstAmt'] = (float)number_format($igstAmount, 2);
            if ($isForChallan) {
                $cgstAmount = $roundingType !== 0 ? round(($itemList[$key]['AssAmt'] * $item->cgstPercentage / 100)) : $itemList[$key]['AssAmt'] * $item->cgstPercentage / 100;
            } else {
                $cgstAmount = $roundingType !== 0 ? round(($itemList[$key]['AssAmt'] * $item->itemCgstPercent / 100)) : $itemList[$key]['AssAmt'] * $item->itemCgstPercent / 100;
            }
            $itemList[$key]['CgstAmt'] = (float)number_format($cgstAmount, 2);
            if ($isForChallan) {
                $sgstAmount = $roundingType !== 0 ? round(($itemList[$key]['AssAmt'] * $item->sgstPercentage / 100)) : $itemList[$key]['AssAmt'] * $item->sgstPercentage / 100;
            } else {
                $sgstAmount = $roundingType !== 0 ? round(($itemList[$key]['AssAmt'] * $item->itemSgstPercent / 100)) : $itemList[$key]['AssAmt'] * $item->itemSgstPercent / 100;
            }
            $itemList[$key]['SgstAmt'] = (float)number_format($sgstAmount, 2);
            $itemList[$key]['Discount'] = (float)number_format($item->itemDiscountValue, 2);
            $totalItemValue = $roundingType !== 0 ? round($itemList[$key]['AssAmt'] + $itemList[$key]['IgstAmt'] + $itemList[$key]['CgstAmt'] + $itemList[$key]['SgstAmt'] + $itemList[$key]['OthChrg']) : ($itemList[$key]['AssAmt'] + $itemList[$key]['IgstAmt'] + $itemList[$key]['CgstAmt'] + $itemList[$key]['SgstAmt'] + $itemList[$key]['OthChrg']);
            $itemList[$key]['TotItemVal'] = (float)number_format($totalItemValue, 2);
        }

        return $itemList ?? [];
    }

    /**
     * @param object|null $item
     * @return float
     */
    protected function getEInvoiceItemGstRate(?object $item): float
    {
        if (isset($item->igstPercentage)) {
            if ((float)$item->igstPercentage != 0) {
                $gstValue = (float)$item->igstPercentage;
            } else {
                $gstValue = (float)$item->cgstPercentage + (float)$item->sgstPercentage;
            }
        }

        if (isset($item->itemIgstPercent)) {
            if ((float)$item->itemIgstPercent != 0) {
                $gstValue = (float)$item->itemIgstPercent;
            } else {
                $gstValue = (float)$item->itemCgstPercent + (float)$item->itemSgstPercent;
            }
        }

        return $gstValue ?? 0;
    }

    /**
     * @param object|null $challanBilling
     * @return array
     */
    protected function eInvoiceItemBillingTerm(?object $challanBilling): array
    {
        foreach ($challanBilling as $item) {
            if ((float)$item->calculateAmount > 0) {
                $billing[$item->calCode] = (float)$item->calculateAmount;
            }
        }

        return $billing ?? [];
    }

    /**
     * @param array|null $items
     * @param int $roundingType
     * @return array
     */
    protected function eInvoiceFinalValueDetails(?array $items, int $roundingType): array
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

        $finalValue['AssVal'] = (float)number_format($finalValue['AssVal'], 2);
        $finalValue['TotInvVal'] = (float)number_format($finalValue['TotInvVal'], 2);
        $finalValue['IgstVal'] = (float)number_format($finalValue['IgstVal'], 2);
        $finalValue['SgstVal'] = (float)number_format($finalValue['SgstVal'], 2);
        $finalValue['CgstVal'] = (float)number_format($finalValue['CgstVal'], 2);
        $finalValue['OthChrg'] = (float)number_format($finalValue['OthChrg'], 2);

        return $finalValue;
    }

    /**
     * @param array|null $billingTerm
     * @return float
     */
    protected function getEInvoiceOtherCharges(?array $billingTerm): float
    {
        $otherCharge = 0;
        foreach ($billingTerm as $key => $value) {
            if ($key !== 'BAS' && $key !== 'SUB' && $key !== 'SGT' && $key !== 'CGT' && $key !== 'IGT' && $key !== 'GRD') {
                $otherCharge += $value;
            }
        }

        return $otherCharge;
    }
}
