<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;

class ProformaInvoice extends BaseModel
{
    protected $collection = 'proforma_invoices';
    protected $fillable = [
        'pInvoiceNo',
        'pInvoiceDate',
        'pInvoiceCurrency',
        'pInvoiceConvRate',
        'kindAttnId',
        'kindAttnName',
        'kindAttnMobile',
        'kindAttnEmail',
        'pInvoiceSalesType',
        'pInvoiceStatus',
        'pInvoiceBranch',
        'pInvoiceSupplyType',
        'pInvoiceGstType',
        'pInvoiceReviewDate',
        'pIRounding',
        'pInvoiceCustomerID',
        'pInvoiceCustomerCode',
        'pInvoiceCustomerName',
        'partyDetail',
        'buyerDetail',
        'consigneeDetail',
        'otherDetail',
        'loginDetail',
        'pINetAmount',
        'pIGrossAmount',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $hidden = ['updated_at'];

    protected $appends = ['net_amount','gross_amount'];

    public function itemData()
    {
        return $this->hasMany(ProformaInvoiceItems::class,'pInvoiceId','_id');
    }

    public function getNetAmountAttribute()
    {
        return $this->itemData()->sum('itemNetAmount');
    }

    public function billingData()
    {
        return $this->hasMany(PiBillingTerms::class,'pInvoiceId','_id');
    }

    public function getGrossAmountAttribute()
    {
        $value = $this->billingData()->latest()->first(['calculatedAmount']);
        return is_null($value) ? 0 : $value->calculatedAmount;
    }
}
