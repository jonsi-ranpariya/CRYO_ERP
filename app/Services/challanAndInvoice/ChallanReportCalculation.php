<?php

namespace App\Services\challanAndInvoice;

use App\Models\Despatch\NewChallanInvoiceBillingTerm;

class ChallanReportCalculation
{
    private $basicAmount;
    private $grandTotal;
    private string $challanInvoiceId;
    private array $billingTemplate;
    private $sgstAmount;
    private $cgstAmount;
    private $igstAmount;

    public function __construct($challanInvoiceId)
    {
        $this->challanInvoiceId = $challanInvoiceId;
        $this->billingTermData();
    }

    /**
     * @return mixed
     */
    public function getBasicAmount()
    {
        return $this->basicAmount = is_array($this->basicAmount) ? number_format(array_sum($this->basicAmount), 2) : $this->basicAmount;
    }

    /**
     * @param mixed $basicAmount
     * @return ChallanReportCalculation
     */
    public function setBasicAmount($basicAmount): ChallanReportCalculation
    {
        $this->basicAmount[] = ceil($basicAmount);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIgstAmount()
    {
        return $this->igstAmount;
    }

    /**
     * @param mixed $igstAmount
     */
    public function setIgstAmount($igstAmount): void
    {
        $this->igstAmount = $igstAmount;
    }

    /**
     * @return mixed
     */
    public function getCgstAmount()
    {
        return $this->cgstAmount;
    }

    /**
     * @param mixed $cgstAmount
     */
    public function setCgstAmount($cgstAmount): void
    {
        $this->cgstAmount = $cgstAmount;
    }

    /**
     * @return mixed
     */
    public function getSgstAmount()
    {
        return $this->sgstAmount;
    }

    /**
     * @param mixed $sgstAmount
     */
    public function setSgstAmount($sgstAmount): void
    {
        $this->sgstAmount = $sgstAmount;
    }

    /**
     * @return mixed
     */
    public function getGrandTotal()
    {
        return $this->grandTotal;
    }

    /**
     * @param mixed $grandTotal
     * @return ChallanReportCalculation
     */
    public function setGrandTotal($grandTotal): ChallanReportCalculation
    {
        $this->grandTotal = $grandTotal;
        return $this;
    }

    /**
     * @return array
     */
    public function getBillingTemplate(): array
    {
        return $this->billingTemplate;
    }

    /**
     * @param array $billingTemplate
     * @return ChallanReportCalculation
     */
    public function setBillingTemplate(array $billingTemplate): ChallanReportCalculation
    {
        $this->billingTemplate = $billingTemplate;
        return $this;
    }


    private function billingTermData(): void
    {
        $billingTerms = NewChallanInvoiceBillingTerm::query()
            ->where(['challanInvoiceId' => $this->challanInvoiceId])
            ->oldest('srNo')
            ->get();
        foreach ($billingTerms as $index => $billingTerm) {
            $billingData[$billingTerm->description] = $billingTerm->calculateAmount;
            if ($billingTerm->description == 'CGST'){
                $this->setCgstAmount($billingTerm->calculateAmount);
            }
            if ($billingTerm->description == 'SGST'){
                $this->setSgstAmount($billingTerm->calculateAmount);
            }
            if ($billingTerm->description == 'IGST'){
                $this->setIgstAmount($billingTerm->calculateAmount);
            }
            if ($billingTerm->description == 'Grand Total'){
                $this->setGrandTotal($billingTerm->calculateAmount);
            }
        }
        $this->setBillingTemplate($billingData ?? []);
    }
}
