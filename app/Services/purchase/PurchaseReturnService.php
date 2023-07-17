<?php

namespace App\Services\purchase;

use App\Models\Purchase\PurchaseReturnBilling;

class PurchaseReturnService
{
    protected null|float $grandTotal = 0;
    protected null|float $igstAmount = 0;
    protected null|float $cgstAmount = 0;
    protected null|float $sgstAmount = 0;

    public function __construct(protected string $purchaseReturnId)
    {}

    public function getCgstAmount(): null|float
    {
        return $this->cgstAmount;
    }

    public function setCgstAmount(?float $cgstAmount): PurchaseReturnService
    {
        $this->cgstAmount = $cgstAmount;
        return $this;
    }

    public function getSgstAmount(): null|float
    {
        return $this->sgstAmount;
    }

    public function setSgstAmount(?float $sgstAmount): PurchaseReturnService
    {
        $this->sgstAmount = $sgstAmount;
        return $this;
    }

    public function getIgstAmount(): null|float
    {
        return $this->igstAmount;
    }

    public function setIgstAmount(?float $igstAmount): PurchaseReturnService
    {
        $this->igstAmount = $igstAmount;
        return $this;
    }

    public function getGrandTotal(): null|float
    {
        return $this->grandTotal;
    }

    public function setGrandTotal(?float $grandTotal): PurchaseReturnService
    {
        $this->grandTotal = $grandTotal;
        return $this;
    }

    public function salesReturnBillingTerm(): array
    {
        $billingTerms = PurchaseReturnBilling::query()
            ->where('purchaseReturnId', $this->purchaseReturnId)
            ->oldest('srNo')
            ->get();

        foreach ($billingTerms as $billingTerm) {
            $billingTermArray[$billingTerm->description] = $billingTerm->total_amount;

            if ($billingTerm->description == 'CGST') {
                $this->setCgstAmount($billingTerm->total_amount);
            }
            if ($billingTerm->description == 'SGST') {
                $this->setSgstAmount($billingTerm->total_amount);
            }
            if ($billingTerm->description == 'IGST') {
                $this->setIgstAmount($billingTerm->total_amount);
            }
            if ($billingTerm->description == 'Grand Total') {
                $this->setGrandTotal($billingTerm->total_amount);
            }
        }

        return $billingTermArray ?? [];
    }
}
