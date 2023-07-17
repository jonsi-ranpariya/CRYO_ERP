<?php

namespace App\Actions\Sales;

use App\Models\Despatch\NewChallanInvoice;
use App\Models\Despatch\NewChallanInvoiceBillingTerm;
use App\Models\Despatch\NewChallanInvoiceItems;
use App\Models\SalesCrm\SalesReturn;
use App\Models\SalesCrm\SalesReturnItems;
use App\Models\SalesCrm\SrBillingTerms;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class salesReturnInsertAction
{
    use AsAction;

    /**
     * @param SalesReturn $salesReturn
     * @param NewChallanInvoice $challanInvoice
     * @param SalesReturnItems $salesReturnItems
     * @param SrBillingTerms $salesReturnBillingTerm
     * @param NewChallanInvoiceItems $challanInvoiceItems
     * @param NewChallanInvoiceBillingTerm $challanInvoiceBillingTerm
     */
    public function __construct(protected SalesReturn                  $salesReturn,
                                protected NewChallanInvoice            $challanInvoice,
                                protected SalesReturnItems             $salesReturnItems,
                                protected SrBillingTerms               $salesReturnBillingTerm,
                                protected NewChallanInvoiceItems       $challanInvoiceItems,
                                protected NewChallanInvoiceBillingTerm $challanInvoiceBillingTerm)
    {}

    /**
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request): mixed
    {
        $dataInsert = $request->all();
        //$dataInsert['salesReturnNo'] = generateCodes(new SalesReturn(),'SR00001','salesReturnNo','SR');
        $invoiceData = $this->challanInvoice->getDataFromId($dataInsert['salesReturnInvoiceId']);
        $invoiceItems = $this->challanInvoiceItems->getData(['challanInvoiceId' => $dataInsert['salesReturnInvoiceId']]);
        $billingTerm = $this->challanInvoiceBillingTerm->query()
            ->where('challanInvoiceId', $dataInsert['salesReturnInvoiceId'])
            ->oldest('srNo')
            ->get();

        $dataInsert['buyerDetails'] = $this->buyerDetails($invoiceData->buyerDetails ?? null, $invoiceData->buyer_extra_data ?? null);
        $dataInsert['consigneeDetails'] = $this->consigneeDetails($invoiceData->consigneeDetails ?? null, $invoiceData->consignee_extra_data ?? null);
        $dataInsert['dispatchDetails'] = $this->dispatchDetails($invoiceData->dispatchDetails ?? null, $invoiceData->dispatch_extra_data ?? null);
        $dataInsert['transportExportData'] = $this->transportExportDetails($invoiceData->transportExportData ?? null);
        $dataInsert['salesReturnCompanyId'] = $invoiceData->company ?? $dataInsert['manualCompanyId'];

        $response = $this->salesReturn->saveData($dataInsert);

        $this->salesReturnItemData($response, $invoiceItems ?? null);
        $this->billingTermsData($response, $billingTerm ?? null);

        return $response;
    }

    /**
     * @param array|null $data
     * @param array|null $extraData
     * @return array
     */
    protected function buyerDetails(?array $data, ?array $extraData): array
    {
        $dataInsert['buyerCode'] = $data['buyerCode'] ?? null;
        $dataInsert['buyerName'] = $data['buyerName'] ?? null;
        $dataInsert['buyerAddress'] = $data['buyerAddress'] ?? null;
        $dataInsert['buyerCountry'] = $data['buyerCountry'] ?? null;
        $dataInsert['buyerCountryName'] = $extraData['country']['country'] ?? null;
        $dataInsert['buyerState'] = $data['buyerState'] ?? null;
        $dataInsert['buyerStateName'] = $extraData['state']['state'] ?? null;
        $dataInsert['buyerStateCode'] = $extraData['state']['stateCode'] ?? null;
        $dataInsert['buyerCity'] = $data['buyerCity'] ?? null;
        $dataInsert['buyerCityName'] = $extraData['city']['city'] ?? null;
        $dataInsert['buyerFaxNo'] = $data['buyerFaxNo'] ?? null;
        $dataInsert['buyerEmailId'] = $data['buyerEmailId'] ?? null;
        $dataInsert['buyerWebSite'] = $data['buyerWebSite'] ?? null;
        $dataInsert['buyerPinCode'] = $data['buyerPinCode'] ?? null;
        $dataInsert['buyerPhoneCountry'] = $data['buyerPhoneCountry'] ?? null;
        $dataInsert['buyerPhoneNo'] = $data['buyerPhoneNo'] ?? null;
        $dataInsert['buyerTinVatNo'] = $data['buyerTinVatNo'] ?? null;
        $dataInsert['buyerTinCstNo'] = $data['buyerTinCstNo'] ?? null;
        $dataInsert['buyerEccNo'] = $data['buyerEccNo'] ?? null;
        $dataInsert['buyerGstinNo'] = $data['buyerGstinNo'] ?? null;
        $dataInsert['buyerPanNo'] = $data['buyerPanNo'] ?? null;
        $dataInsert['buyerKindAttnId'] = $data['buyerKindAttnId'] ?? null;
        $dataInsert['buyerKindAttnName'] = $data['buyerKindAttnName'] ?? null;
        $dataInsert['buyerKindAttnMobile'] = $data['buyerKindAttnMobile'] ?? null;
        $dataInsert['buyerKindAttnEmail'] = $data['buyerKindAttnEmail'] ?? null;

        return $dataInsert;
    }

    /**
     * @param array|null $data
     * @param array|null $extraData
     * @return array
     */
    protected function consigneeDetails(?array $data, ?array $extraData): array
    {
        $dataInsert['consigneeCode'] = $data['consigneeCode'] ?? null;
        $dataInsert['consigneeName'] = $data['consigneeName'] ?? null;
        $dataInsert['consigneeAddress'] = $data['consigneeAddress'] ?? null;
        $dataInsert['consigneeCountry'] = $data['consigneeCountry'] ?? null;
        $dataInsert['consigneeCountryName'] = $extraData['country']['country'] ?? null;
        $dataInsert['consigneeState'] = $data['consigneeState'] ?? null;
        $dataInsert['consigneeStateName'] = $extraData['state']['state'] ?? null;
        $dataInsert['consigneeStateCode'] = $extraData['state']['stateCode'] ?? null;
        $dataInsert['consigneeCity'] = $data['consigneeCity'] ?? null;
        $dataInsert['consigneeCityName'] = $extraData['city']['city'] ?? null;
        $dataInsert['consigneeFaxNo'] = $data['consigneeFaxNo'] ?? null;
        $dataInsert['consigneeEmailId'] = $data['consigneeEmailId'] ?? null;
        $dataInsert['consigneeWebSite'] = $data['consigneeWebSite'] ?? null;
        $dataInsert['consigneePinCode'] = $data['consigneePinCode'] ?? null;
        $dataInsert['consigneePhoneCountry'] = $data['consigneePhoneCountry'] ?? null;
        $dataInsert['consigneePhoneNo'] = $data['consigneePhoneNo'] ?? null;
        $dataInsert['consigneeTinVatNo'] = $data['consigneeTinVatNo'] ?? null;
        $dataInsert['consigneeTinCstNo'] = $data['consigneeTinCstNo'] ?? null;
        $dataInsert['consigneeEccNo'] = $data['consigneeEccNo'] ?? null;
        $dataInsert['consigneeGstinNo'] = $data['consigneeGstinNo'] ?? null;
        $dataInsert['consigneePanNo'] = $data['consigneePanNo'] ?? null;
        $dataInsert['consigneeKindAttnId'] = $data['consigneeKindAttnId'] ?? null;
        $dataInsert['consigneeKindAttnName'] = $data['consigneeKindAttnName'] ?? null;
        $dataInsert['consigneeKindAttnMobile'] = $data['consigneeKindAttnMobile'] ?? null;
        $dataInsert['consigneeKindAttnEmail'] = $data['consigneeKindAttnEmail'] ?? null;

        return $dataInsert;
    }

    /**
     * @param array|null $data
     * @param array|null $extraData
     * @return array
     */
    protected function dispatchDetails(?array $data, ?array $extraData): array
    {
        $dataInsert['dispatchCode'] = $data['dispatchCode'] ?? null;
        $dataInsert['dispatchName'] = $data['dispatchName'] ?? null;
        $dataInsert['dispatchAddress'] = $data['dispatchAddress'] ?? null;
        $dataInsert['dispatchCountry'] = $data['dispatchCountry'] ?? null;
        $dataInsert['dispatchCountryName'] = $extraData['country']['country'] ?? null;
        $dataInsert['dispatchState'] = $data['dispatchState'] ?? null;
        $dataInsert['dispatchStateName'] = $extraData['state']['state'] ?? null;
        $dataInsert['dispatchStateCode'] = $extraData['state']['stateCode'] ?? null;
        $dataInsert['dispatchCity'] = $data['dispatchCity'] ?? null;
        $dataInsert['dispatchCityName'] = $extraData['city']['city'] ?? null;
        $dataInsert['dispatchFaxNo'] = $data['dispatchFaxNo'] ?? null;
        $dataInsert['dispatchEmailId'] = $data['dispatchEmailId'] ?? null;
        $dataInsert['dispatchWebSite'] = $data['dispatchWebSite'] ?? null;
        $dataInsert['dispatchPinCode'] = $data['dispatchPinCode'] ?? null;
        $dataInsert['dispatchPhoneCountry'] = $data['dispatchPhoneCountry'] ?? null;
        $dataInsert['dispatchPhoneNo'] = $data['dispatchPhoneNo'] ?? null;
        $dataInsert['dispatchTinVatNo'] = $data['dispatchTinVatNo'] ?? null;
        $dataInsert['dispatchTinCstNo'] = $data['dispatchTinCstNo'] ?? null;
        $dataInsert['dispatchEccNo'] = $data['dispatchEccNo'] ?? null;
        $dataInsert['dispatchGstinNo'] = $data['dispatchGstinNo'] ?? null;
        $dataInsert['dispatchPanNo'] = $data['dispatchPanNo'] ?? null;
        $dataInsert['dispatchKindAttnId'] = $data['dispatchKindAttnId'] ?? null;
        $dataInsert['dispatchKindAttnName'] = $data['dispatchKindAttnName'] ?? null;
        $dataInsert['dispatchKindAttnMobile'] = $data['dispatchKindAttnMobile'] ?? null;
        $dataInsert['dispatchKindAttnEmail'] = $data['dispatchKindAttnEmail'] ?? null;

        return $dataInsert;
    }

    /**
     * @param array|null $data
     * @return array
     */
    protected function transportExportDetails(?array $data): array
    {
        $dataInsert['transporter'] = $data['transporter'] ?? null;
        $dataInsert['vehicalNo'] = $data['vehicalNo'] ?? null;
        $dataInsert['distance'] = $data['distance'] ?? null;
        $dataInsert['transporterId'] = $data['transporterId'] ?? null;
        $dataInsert['transportMode'] = $data['transportMode'] ?? null;
        $dataInsert['vehicleType'] = $data['vehicleType'] ?? null;
        $dataInsert['lrNumber'] = $data['lrNumber'] ?? null;
        $dataInsert['lrDate'] = $data['lrDate'] ?? null;
        $dataInsert['dateIssueInvoice'] = $data['dateIssueInvoice'] ?? null;
        $dataInsert['timeIssueInvoice'] = $data['timeIssueInvoice'] ?? null;
        $dataInsert['dateRemovalGood'] = $data['dateRemovalGood'] ?? null;
        $dataInsert['timeRemovalGood'] = $data['timeRemovalGood'] ?? null;
        $dataInsert['exportReference'] = $data['exportReference'] ?? null;
        $dataInsert['otherReference'] = $data['otherReference'] ?? null;
        $dataInsert['preCarriageBy'] = $data['preCarriageBy'] ?? null;
        $dataInsert['vessel'] = $data['vessel'] ?? null;
        $dataInsert['portOfDischarge'] = $data['portOfDischarge'] ?? null;
        $dataInsert['placeOfReceipt'] = $data['placeOfReceipt'] ?? null;
        $dataInsert['placeOfLoading'] = $data['placeOfLoading'] ?? null;
        $dataInsert['finalDestination'] = $data['finalDestination'] ?? null;
        $dataInsert['exportCurrentDesc'] = $data['exportCurrentDesc'] ?? null;
        $dataInsert['exportTerms'] = $data['exportTerms'] ?? null;
        $dataInsert['markNoTitle'] = $data['markNoTitle'] ?? null;
        $dataInsert['noPkgTitle'] = $data['noPkgTitle'] ?? null;
        $dataInsert['itemDescTitle'] = $data['itemDescTitle'] ?? null;
        $dataInsert['narration'] = $data['narration'] ?? null;
        $dataInsert['note'] = $data['note'] ?? null;

        return $dataInsert;
    }

    /**
     * @param SalesReturn $salesReturn
     * @param object|null $invoiceItems
     */
    protected function salesReturnItemData(SalesReturn $salesReturn, ?object $invoiceItems): void
    {
        if ($invoiceItems !== null) {
            foreach ($invoiceItems as $item) {
                $dataInsert['salesReturnId'] = $salesReturn->_id;
                $dataInsert['invoiceNo'] = $salesReturn->salesReturnInvoiceNo ?? null;
                $dataInsert['invoiceDate'] = $salesReturn->salesReturnInvoiceDate ?? null;
                $dataInsert['itemId'] = null;
                $dataInsert['itemCode'] = $item->itemCode ?? null;
                $dataInsert['itemName'] = $item->itemDescription ?? null;
                $dataInsert['itemCustomDescription'] = $item->itemCustomDescription ?? null;
                $dataInsert['itemAddonDescription'] = $item->itemAddDescription ?? null;
                $dataInsert['itemDetailDescription'] = $item->itemDetailDescription ?? null;
                $dataInsert['itemDrawingNo'] = $item->itemDrawingNo ?? null;
                $dataInsert['itemDrawingRev'] = $item->itemRevision ?? null;
                $dataInsert['itemProject'] = null;
                $dataInsert['itemInternalNote'] = null;
                $dataInsert['itemUom'] = $item->itemUom ?? null;
                $dataInsert['itemCustPartNo'] = $item->itemCustPartNo ?? null;
                $dataInsert['itemHsnSacNo'] = $item->itemHsnSacNo ?? null;
                $dataInsert['itemNote'] = $item->itemRemark ?? null;
                $dataInsert['itemQuantity'] = $item->itemQuantity ?? null;
                $dataInsert['itemRate'] = (float)$item->itemRate ?? null;
                $dataInsert['itemAmount'] = (float)$item->itemAmount ?? null;
                $dataInsert['itemNetAmount'] = (float)$item->itemAmount ?? null;
                $dataInsert['rejectedItemId'] = null;
                $dataInsert['rejectedItemCode'] = null;
                $dataInsert['rejectedItemName'] = null;
                $dataInsert['itemMsnNumber'] = $item->itemMsnNumber ?? null;
                $dataInsert['reason'] = null;
                $dataInsert['cgstPercentage'] = (float)$item->cgstPercentage ?? 0;
                $dataInsert['sgstPercentage'] = (float)$item->sgstPercentage ?? 0;
                $dataInsert['igstPercentage'] = (float)$item->igstPercentage ?? 0;
                $dataInsert['cgstAmount'] = ((float)$item->itemAmount * (float)$item->cgstPercentage / 100) ?? null;
                $dataInsert['sgstAmount'] = ((float)$item->itemAmount * (float)$item->sgstPercentage / 100) ?? null;
                $dataInsert['igstAmount'] = ((float)$item->itemAmount * (float)$item->igstPercentage / 100) ?? null;

                $this->salesReturnItems->saveData($dataInsert);
            }
        }
    }

    /**
     * @param SalesReturn $salesReturn
     * @param object|null $billingTerms
     */
    protected function billingTermsData(SalesReturn $salesReturn, ?object $billingTerms): void
    {
        if ($billingTerms !== null) {
            foreach ($billingTerms as $key => $billingTerm) {
                $dataInsert['salesReturnId'] = $salesReturn->_id;
                $dataInsert['calCode'] = $billingTerm->calCode;
                $dataInsert['calCodeLabel'] = $billingTerm->calCode;
                $dataInsert['description'] = $billingTerm->description;
                $dataInsert['calDefination'] = $billingTerm->calDefination;
                $dataInsert['percentage'] = $billingTerm->percentage;
                $dataInsert['byValue'] = $billingTerm->byValue;
                $dataInsert['operation'] = $billingTerm->operation;
                $dataInsert['narration'] = null;
                $dataInsert['type'] = $billingTerm->type;
                $dataInsert['total_amount'] = 0;
                $dataInsert['srNo'] = $billingTerm->srNo ?? $key + 1;
                $this->salesReturnBillingTerm->saveData($dataInsert);
            }
        }
    }
}
