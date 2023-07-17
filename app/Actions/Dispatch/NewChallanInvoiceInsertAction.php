<?php

namespace App\Actions\Dispatch;

use App\Models\Despatch\NewChallanInvoice;
use App\Models\Despatch\NewChallanInvoiceBillingTerm;
use App\Models\Despatch\NewChallanInvoiceTermCondition;
use App\Models\Partymaster\PartyMaster;
use App\Models\SalesCrm\SalesOrder;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class NewChallanInvoiceInsertAction
{
    use AsAction;

    public function __construct(
        protected PartyMaster                    $partyMaster,
        protected NewChallanInvoice              $newChallanInvoice,
        protected SalesOrder                     $salesOrder,
        protected NewChallanInvoiceBillingTerm   $newChallanInvoiceBillingTerm,
        protected NewChallanInvoiceTermCondition $newChallanInvoiceTermCondition
    )
    {}

    public function handle(Request $request)
    {
        $dataInsert = $request->all();
        $salesOrderNumber = $dataInsert['salesOrderNumber'][0];
        /*1: Invoice Wise, 2: Item Wise, 3: Other charge wise*/
        $salesOrderDetails = $this->salesOrder
            ->withBillingTerm()
            ->withTermAndCondition()
            ->find($salesOrderNumber);

        $dataInsert['partyDetails'] = $this->sellToPartyData($salesOrderDetails->partyDetail);
        $dataInsert['buyerDetails'] = $this->shipToPartyData($salesOrderDetails->buyerDetail);
        $dataInsert['consigneeDetails'] = $this->consigneeDetails($salesOrderDetails->consigneeDetail);
        $dataInsert['dispatchDetails'] = $this->dispatchDetails($salesOrderDetails->dispatchDetail);
        $response = $this->newChallanInvoice->saveData($dataInsert);

        $this->challanInvoiceBillingTerm($response->_id, $salesOrderDetails->billingTerm);
        $this->challanInvoiceTermCondition($response->_id, $salesOrderDetails->termAndCondition);
        return $response;
    }

    /**
     * @param array|null $sellToPartyDetails
     * @return array
     */
    private function sellToPartyData(?array $sellToPartyDetails): array
    {
        $dataInsert['PartyCode'] = $sellToPartyDetails['partyDetailId'] ?? null;
        $dataInsert['PartyName'] = $sellToPartyDetails['partyDetailName'] ?? null;
        $dataInsert['partyAddress'] = $sellToPartyDetails['partyDetailAddress'] ?? null;
        $dataInsert['partyCountry'] = $sellToPartyDetails['partyDetailCountryID'] ?? null;
        $dataInsert['partyState'] = $sellToPartyDetails['partyDetailStateId'] ?? null;
        $dataInsert['partyCity'] = $sellToPartyDetails['partyDetailCityId'] ?? null;
        $dataInsert['partyFaxNo'] = $sellToPartyDetails['partyDetailFaxNo'] ?? null;
        $dataInsert['partyEmailId'] = $sellToPartyDetails['partyDetailEmailId'] ?? null;
        $dataInsert['partyWebSite'] = $sellToPartyDetails['partyDetailWebsite'] ?? null;
        $dataInsert['partyPinCode'] = $sellToPartyDetails['partyDetailPinCode'] ?? null;
        $dataInsert['partyPhoneCountry'] = $sellToPartyDetails['partyDetailStdCode'] ?? null;
        $dataInsert['partyPhoneNo'] = $sellToPartyDetails['partyDetailPhoneNo'] ?? null;
        $dataInsert['partyTinVatNo'] = $sellToPartyDetails['partyDetailTinVatNO'] ?? null;
        $dataInsert['partyTinCstNo'] = $sellToPartyDetails['partyDetailTinCstNO'] ?? null;
        $dataInsert['partyEccNo'] = $sellToPartyDetails['partyDetailTinEccNO'] ?? null;
        $dataInsert['partyGstinNo'] = $sellToPartyDetails['partyDetailGstNo'] ?? null;
        $dataInsert['partyPanNo'] = $sellToPartyDetails['partyDetailPanNo'] ?? null;
        $dataInsert['partyKindAttnId'] = null;
        $dataInsert['partyKindAttnName'] = null;
        $dataInsert['partyKindAttnMobile'] = null;
        $dataInsert['partyKindAttnEmail'] = null;
        return $dataInsert;
    }

    /**
     * @param array|null $shipToPartyDetails
     * @return array
     */
    private function shipToPartyData(?array $shipToPartyDetails): array
    {
        $dataInsert['buyerCode'] = $shipToPartyDetails['buyerDetailId'] ?? null;
        $dataInsert['buyerName'] = $shipToPartyDetails['buyerDetailName'] ?? null;
        $dataInsert['buyerAddress'] = $shipToPartyDetails['buyerDetailAddress'] ?? null;
        $dataInsert['buyerCountry'] = $shipToPartyDetails['buyerDetailCountryID'] ?? null;
        $dataInsert['buyerState'] = $shipToPartyDetails['buyerDetailStateId'] ?? null;
        $dataInsert['buyerCity'] = $shipToPartyDetails['buyerDetailCityId'] ?? null;
        $dataInsert['buyerFaxNo'] = $shipToPartyDetails['buyerDetailFaxNo'] ?? null;
        $dataInsert['buyerEmailId'] = $shipToPartyDetails['buyerDetailEmailId'] ?? null;
        $dataInsert['buyerWebSite'] = $shipToPartyDetails['buyerDetailWebsite'] ?? null;
        $dataInsert['buyerPinCode'] = $shipToPartyDetails['buyerDetailPinCode'] ?? null;
        $dataInsert['buyerPhoneCountry'] = $shipToPartyDetails['buyerDetailPhoneStdCode'] ?? null;
        $dataInsert['buyerPhoneNo'] = $shipToPartyDetails['buyerDetailPhoneNo'] ?? null;
        $dataInsert['buyerTinVatNo'] = $shipToPartyDetails['buyerDetailTinVatNO'] ?? null;
        $dataInsert['buyerTinCstNo'] = $shipToPartyDetails['buyerDetailTinCstNO'] ?? null;
        $dataInsert['buyerEccNo'] = $shipToPartyDetails['buyerDetailTinEccNO'] ?? null;
        $dataInsert['buyerGstinNo'] = $shipToPartyDetails['buyerDetailGstNo'] ?? null;
        $dataInsert['buyerPanNo'] = $shipToPartyDetails['buyerDetailPanNo'] ?? null;
        $dataInsert['buyerKindAttnId'] = null;
        $dataInsert['buyerKindAttnName'] = null;
        $dataInsert['buyerKindAttnMobile'] = null;
        $dataInsert['buyerKindAttnEmail'] = null;

        return $dataInsert;
    }

    /**
     * @param array|null $consigneeDetails
     * @return array
     */
    private function consigneeDetails(?array $consigneeDetails): array
    {
        $data['consigneeCode'] = $consigneeDetails['consigneeDetailId'] ?? null;
        $data['consigneeName'] = $consigneeDetails['consigneeDetailName'] ?? null;
        $data['consigneeAddress'] = $consigneeDetails['consigneeDetailAddress'] ?? null;
        $data['consigneeCountry'] = $consigneeDetails['consigneeDetailCountryID'] ?? null;
        $data['consigneeState'] = $consigneeDetails['consigneeDetailStateId'] ?? null;
        $data['consigneeCity'] = $consigneeDetails['consigneeDetailCityId'] ?? null;
        $data['consigneeFaxNo'] = $consigneeDetails['consigneeDetailFaxNo'] ?? null;
        $data['consigneeEmailId'] = $consigneeDetails['consigneeDetailEmailId'] ?? null;
        $data['consigneeWebSite'] = $consigneeDetails['consigneeDetailWebsite'] ?? null;
        $data['consigneePinCode'] = $consigneeDetails['consigneeDetailPinCode'] ?? null;
        $data['consigneePhoneCountry'] = $consigneeDetails['consigneeDetailPhoneStdCode'] ?? null;
        $data['consigneePhoneNo'] = $consigneeDetails['consigneePhoneNo'] ?? null;
        $data['consigneeTinVatNo'] = $consigneeDetails['consigneeDetailTinVatNO'] ?? null;
        $data['consigneeTinCstNo'] = $consigneeDetails['consigneeDetailTinCstNO'] ?? null;
        $data['consigneeEccNo'] = $consigneeDetails['consigneeDetailTinEccNO'] ?? null;
        $data['consigneeGstinNo'] = $consigneeDetails['consigneeDetailGstNo'] ?? null;
        $data['consigneePanNo'] = $consigneeDetails['consigneeDetailPanNo'] ?? null;
        $data['consigneeKindAttnId'] = null;
        $data['consigneeKindAttnName'] = null;
        $data['consigneeKindAttnMobile'] = null;
        $data['consigneeKindAttnEmail'] = null;

        return $data;
    }

    /**
     * @param array|null $dispatchDetails
     * @return array
     */
    private function dispatchDetails(?array $dispatchDetails): array
    {
        $data['dispatchCode'] = $dispatchDetails['dispatchDetailId'] ?? null;
        $data['dispatchName'] = $dispatchDetails['dispatchDetailName'] ?? null;
        $data['dispatchAddress'] = $dispatchDetails['dispatchDetailAddress'] ?? null;
        $data['dispatchCountry'] = $dispatchDetails['dispatchDetailCountryID'] ?? null;
        $data['dispatchState'] = $dispatchDetails['dispatchDetailStateId'] ?? null;
        $data['dispatchCity'] = $dispatchDetails['dispatchDetailCityId'] ?? null;
        $data['dispatchFaxNo'] = $dispatchDetails['dispatchDetailFaxNo'] ?? null;
        $data['dispatchEmailId'] = $dispatchDetails['dispatchDetailEmailId'] ?? null;
        $data['dispatchWebSite'] = $dispatchDetails['dispatchDetailWebsite'] ?? null;
        $data['dispatchPinCode'] = $dispatchDetails['dispatchDetailPinCode'] ?? null;
        $data['dispatchPhoneCountry'] = $dispatchDetails['dispatchDetailPhoneStdCode'] ?? null;
        $data['dispatchPhoneNo'] = $dispatchDetails['dispatchDetailPhoneNo'] ?? null;
        $data['dispatchTinVatNo'] = $dispatchDetails['dispatchDetailTinVatNO'] ?? null;
        $data['dispatchTinCstNo'] = $dispatchDetails['dispatchDetailTinCstNO'] ?? null;
        $data['dispatchEccNo'] = $dispatchDetails['dispatchDetailTinEccNO'] ?? null;
        $data['dispatchGstinNo'] = $dispatchDetails['dispatchDetailGstNo'] ?? null;
        $data['dispatchPanNo'] = $dispatchDetails['dispatchDetailPanNo'] ?? null;
        $data['dispatchKindAttnId'] = null;
        $data['dispatchKindAttnName'] = null;
        $data['dispatchKindAttnMobile'] = null;
        $data['dispatchKindAttnEmail'] = null;

        return $data;
    }

    /**
     * @param string $challanInvoiceId
     * @param $billingTerms
     */
    private function challanInvoiceBillingTerm(string $challanInvoiceId, $billingTerms = []): void
    {
        foreach ($billingTerms as $key => $billingTerm) {
            $billingData['challanInvoiceId'] = $challanInvoiceId;
            $billingData['calCode'] = $billingTerm->calCodeLabel;
            $billingData['calDefination'] = $billingTerm->calDefination;
            $billingData['description'] = $billingTerm->billingName;
            $billingData['type'] = $billingTerm->billingType;
            $billingData['byValue'] = $billingTerm->billingValue;
            $billingData['percentage'] = $billingTerm->billingPercentage;
            $billingData['total_amount'] = 0;
            $billingData['operation'] = '+';
            $billingData['calculateAmount'] = 0;
            $billingData['srNo'] = $key;
            $this->newChallanInvoiceBillingTerm->saveData($billingData);
        }
    }

    /**
     * @param string $challanInvoiceId
     * @param array|null $termAndConditions
     */
    private function challanInvoiceTermCondition(string $challanInvoiceId, $termAndConditions = []): void
    {
        foreach ($termAndConditions as $termAndCondition) {
            $termData['challanInvoiceId'] = $challanInvoiceId;
            $termData['groupId'] = $termAndCondition->termConditionId;
            $termData['groupName'] = $termAndCondition->termGroupName;
            $termData['termsCondition'] = $termAndCondition->termDetail;
            $termData['byPercentage'] = null;
            $termData['byValue'] = null;
            $this->newChallanInvoiceTermCondition->saveData($termData);
        }
    }
}
