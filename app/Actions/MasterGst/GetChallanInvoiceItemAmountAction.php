<?php

namespace App\Actions\MasterGst;

use App\Models\Despatch\NewChallanInvoice;
use App\Models\Despatch\NewChallanInvoiceBillingTerm;
use App\Models\Despatch\NewChallanInvoiceItems;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class GetChallanInvoiceItemAmountAction
{
    use AsAction;

    public function handle(string $id): JsonResponse
    {
        $challanInvoice = NewChallanInvoice::getDataFromId($id);
        $challanItems = NewChallanInvoiceItems::getData(['challanInvoiceId' => $id]);
        $challanBilling = NewChallanInvoiceBillingTerm::getData(['challanInvoiceId' => $id]);
        $billingValues = $this->eInvoiceItemBillingTerm($challanBilling);
        $roundingType = (int)$challanInvoice->roundingType;

        $data['itemList'] = $this->eInvoiceItemList($challanInvoice, $challanItems, $billingValues, $roundingType);
        $data['itemValueDetail'] = $this->eInvoiceFinalValueDetails($data['itemList'], $roundingType, $billingValues, $id);
        return jsonData($data);
    }

    /**
     * @param object|null $data
     * @param object|null $items
     * @param array|null $billingValues
     * @param int $roundingType
     * @return array
     */
    protected function eInvoiceItemList(
        ?object $data,
        ?object $items,
        ?array  $billingValues,
        int     $roundingType
    ): array
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
            $itemList[$key]['IsServc'] = $item->isService;
            $itemList[$key]['HsnCd'] = $item->itemHsnSacNo ?? $item->itemHsnNumber;
            $itemList[$key]['Qty'] = (float)$item->itemQuantity;
            $itemList[$key]['Unit'] = $item->uom_details['uomEinvoice'] ?? $item->uom_detail['uomEinvoice'];
            $itemList[$key]['UnitPrice'] = (float)$item->itemRate;

            if ($data->gstCalculationType == 1) {
                $totAmount = (float)$item->itemAmount + $this->getEInvoiceOtherCharges($billingValues) / $items->count();
                $itemList[$key]['TotAmt'] = $roundingType !== 0 ? round($totAmount) : $totAmount;
                $assAmount = (float)$item->itemNetAmount + $this->getEInvoiceOtherCharges($billingValues) / $items->count();
                $itemList[$key]['AssAmt'] = $roundingType !== 0 ? round($assAmount) : $assAmount;
                $itemList[$key]['OthChrg'] = 0;
            } else {
                $itemList[$key]['TotAmt'] = $roundingType !== 0 ? round($item->itemAmount) : $item->itemAmount;
                $itemList[$key]['AssAmt'] = $roundingType !== 0 ? round($item->itemNetAmount) : $item->itemNetAmount;
                $itemList[$key]['OthChrg'] = $this->getEInvoiceOtherCharges($billingValues) / $items->count();
            }

            $itemList[$key]['GstRt'] = $this->getEInvoiceItemGstRate($item);
            $itemList[$key]['CesRt'] = 0.0;
            $itemList[$key]['CesAmt'] = 0.0;
            $itemList[$key]['CesNonAdvlAmt'] = 0.0;
            $itemList[$key]['StateCesRt'] = 0.0;
            $itemList[$key]['StateCesAmt'] = 0.0;
            $itemList[$key]['StateCesNonAdvlAmt'] = 0.0;
            if ($roundingType !== 0) {
                $igstAmount = round(($itemList[$key]['AssAmt'] * $item->igstPercentage / 100));
            } else {
                $igstAmount = $itemList[$key]['AssAmt'] * $item->igstPercentage / 100;
            }
            $itemList[$key]['IgstAmt'] = round($igstAmount, 2);
            if ($roundingType !== 0) {
                $cgstAmount = round(($itemList[$key]['AssAmt'] * $item->cgstPercentage / 100));
            } else {
                $cgstAmount = $itemList[$key]['AssAmt'] * $item->cgstPercentage / 100;
            }
            $itemList[$key]['CgstAmt'] = round($cgstAmount, 2);
            if ($roundingType !== 0) {
                $sgstAmount = round(($itemList[$key]['AssAmt'] * $item->sgstPercentage / 100));
            } else {
                $sgstAmount = $itemList[$key]['AssAmt'] * $item->sgstPercentage / 100;
            }
            $itemList[$key]['SgstAmt'] = round($sgstAmount, 2);
            $itemList[$key]['Discount'] = round($item->itemDiscountValue, 2);
            if ($roundingType !== 0) {
                $totalItemValue = round($itemList[$key]['AssAmt'] + $itemList[$key]['IgstAmt'] + $itemList[$key]['CgstAmt'] + $itemList[$key]['SgstAmt'] + $itemList[$key]['OthChrg']);
            } else {
                $totalItemValue = ($itemList[$key]['AssAmt'] + $itemList[$key]['IgstAmt'] + $itemList[$key]['CgstAmt'] + $itemList[$key]['SgstAmt'] + $itemList[$key]['OthChrg']);
            }
            $itemList[$key]['TotItemVal'] = round($totalItemValue, 2);
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
     * @param $billingValue
     * @param string $newChallanInvoiceId
     * @return array
     */
    protected function eInvoiceFinalValueDetails(
        ?array $items,
        int    $roundingType,
               $billingValue,
        string $newChallanInvoiceId
    ): array
    {
        $billingTermOtherCharge = NewChallanInvoiceBillingTerm::query()
            ->where('challanInvoiceId', $newChallanInvoiceId)
            ->where('calCode', 'NTX')
            ->first();

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
                $finalValue['OthChrg'] += (float)$item['OthChrg'];
                $finalValue['TotInvVal'] += (float)$item['AssAmt'] + (float)$item['IgstAmt'] + (float)$item['CgstAmt'] + (float)$item['SgstAmt'] + (float)$item['OthChrg'];
            }
        }

        if ($roundingType !== 0) {
            $finalValue['AssVal'] = round($finalValue['AssVal']);
            $finalValue['TotInvVal'] = round($finalValue['TotInvVal'] + $billingTermOtherCharge?->calculateAmount ?? 0);
            $finalValue['IgstVal'] = round($finalValue['IgstVal']);
            $finalValue['SgstVal'] = round($finalValue['SgstVal']);
            $finalValue['CgstVal'] = round($finalValue['CgstVal']);
            $finalValue['OthChrg'] = round($finalValue['OthChrg'] + $billingTermOtherCharge?->calculateAmount ?? 0);
        }

        $finalValue['AssVal'] = round($finalValue['AssVal'], 2);
        $finalValue['TotInvVal'] = round($finalValue['TotInvVal'] + $billingTermOtherCharge?->calculateAmount ?? 0, 2);
        $finalValue['IgstVal'] = round($finalValue['IgstVal'], 2);
        $finalValue['SgstVal'] = round($finalValue['SgstVal'], 2);
        $finalValue['CgstVal'] = round($finalValue['CgstVal'], 2);
        $finalValue['OthChrg'] = round($finalValue['OthChrg'] + $billingTermOtherCharge?->calculateAmount ?? 0, 2);

        $this->updateBillingTermData(
            finalValue: $finalValue,
            newChallanInvoiceId: $newChallanInvoiceId
        );

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
            if ($key !== 'BAS' && $key !== 'SUB' && $key !== 'SGT' && $key !== 'CGT' && $key !== 'IGT' && $key !== 'GRD' && $key !== 'NTX') {
                $otherCharge += $value;
            }
        }

        return $otherCharge;
    }


    /**
     * @param array $finalValue
     * @param string $newChallanInvoiceId
     * @return void
     */
    protected function updateBillingTermData(
        array  $finalValue,
        string $newChallanInvoiceId
    ): void
    {
        $newChallan = NewChallanInvoice::find($newChallanInvoiceId);

        if (!empty($newChallan)) {
            $billingTerm = NewChallanInvoiceBillingTerm::query()
                ->where('challanInvoiceId', $newChallanInvoiceId)
                ->oldest('srNo')
                ->get();

            $billingTerm->each(function (NewChallanInvoiceBillingTerm $item) use ($finalValue) {
                if ($item->calCode == 'CGT') {
                    $item->percentage = 0;
                    $item->calculateAmount = $finalValue['CgstVal'];
                    $item->total_amount = $finalValue['CgstVal'];
                }
                if ($item->calCode == 'SGT') {
                    $item->percentage = 0;
                    $item->calculateAmount = $finalValue['SgstVal'];
                    $item->total_amount = $finalValue['SgstVal'];
                }
                if ($item->calCode == 'IGT') {
                    $item->percentage = 0;
                    $item->calculateAmount = $finalValue['IgstVal'];
                    $item->total_amount = $finalValue['IgstVal'];
                }
                if ($item->calCode == 'GRD') {
                    $item->percentage = 0;
                    $item->calculateAmount = $finalValue['TotInvVal'];
                    $item->total_amount = $finalValue['TotInvVal'];
                }
                $item->update();
            });
        }
    }
}
