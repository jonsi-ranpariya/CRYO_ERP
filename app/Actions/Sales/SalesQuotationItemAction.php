<?php

namespace App\Actions\Sales;

use App\Models\SalesCrm\SalesQuotation;
use App\Models\SalesCrm\SalesQuotationBillingTerms;
use App\Models\SalesCrm\SalesQuotationItems;
use Lorisleiva\Actions\Concerns\AsAction;

class SalesQuotationItemAction
{
    use AsAction;

    /**
     * Create multiple items of sales quotation
     *
     * @param array $itemDetails
     * @param $id
     */
    public function createQuotationItems($id, array $itemDetails): void
    {
        foreach ($itemDetails as $key => $value) {
            $itemDetails[$key]['salesQuotationId'] = $id;
            SalesQuotationItems::saveData($itemDetails[$key]);
        }
    }

    /**
     * Update multiple items of sales quotation
     *
     * @param array $itemDetails
     * @param $id
     */
    public function updateQuotationItems($id, array $itemDetails): void
    {
        foreach ($itemDetails as $key => $itemDetail) {
            if (isset($itemDetail['_id'])) {
                SalesQuotationItems::updateData($itemDetail['_id'], $itemDetail);
            } else {
                $itemDetail['salesQuotationId'] = $id;
                SalesQuotationItems::saveData($itemDetail);
            }
        }
    }

    /**
     * Delete Multiple SalesQuotation Items
     *
     * @param SalesQuotationItems $quotationItems
     * @param $id
     */
    public function deleteSalesQuotationItems(SalesQuotationItems $quotationItems, $id): void
    {
        $quotationItems->deleteData(['salesQuotationId' => $id]);
    }

    /**
     * Add Multiple Billing Terms
     *
     * @param $id
     * @param array $termsDetails
     * @param SalesQuotationBillingTerms $billingTerms
     */
    public function createBillingTermsData($id, array $termsDetails, SalesQuotationBillingTerms $billingTerms): void
    {
        foreach ($termsDetails as $key => $termsDetail) {
            $termsDetails[$key]['salesQuotationId'] = $id;
            $billingTerms::saveData($termsDetails[$key]);
        }
    }

    /**
     * Update Quotation Billing Terms
     *
     * @param $id
     * @param array $termsDetails
     */
    public function updateQuotationBillingTerms($id, array $termsDetails): void
    {
        SalesQuotationBillingTerms::deleteData(['salesQuotationId' => $id]);
        foreach ($termsDetails as $termsDetail) {
            $exist = SalesQuotationBillingTerms::getDataFromId($termsDetail['_id']);
            if (isset($termsDetail['_id']) and $exist) {
                SalesQuotationBillingTerms::updateData($termsDetail['_id'], $termsDetail);
            } else {
                $termsDetail['salesQuotationId'] = $id;
                SalesQuotationBillingTerms::saveData($termsDetail);
            }
        }
    }

    /**
     * Delete Multiple SalesQuotation Billing Terms
     *
     * @param SalesQuotationBillingTerms $billingTerms
     * @param $id
     */
    public function deleteSalesQuotationBillingTerms(SalesQuotationBillingTerms $billingTerms, $id): void
    {
        $billingTerms->deleteData(['salesQuotationId' => $id]);
    }
}
