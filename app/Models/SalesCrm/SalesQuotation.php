<?php

namespace App\Models\SalesCrm;

use App\Models\Administration\Company;
use App\Models\BaseModel;

use App\Models\User;

class SalesQuotation extends BaseModel
{
    protected $collection = 'sales_quotation';
    protected $fillable = [
        'companyId',
        'addedFrom',
        'updatedFrom',
        'quotationNo',
        'partyId',
        'enquiryNo',
        'enquiryDate',
        'quotationDate',
        'quotationRevNo',
        'customerCode',
        'customerName',
        'currency',
        'convRate',
        'sales',
        'status',
        'branch',
        'branchQtyNo',
        'date',
        'qtnType',
        'salesType',
        'reason',
        'reasonRemark',
        'reviewDate',
        'dueDate',
        'expClosureDate',
        'action',
        'qtnStage',
        'roundingType',
        'quotationStatus',
        'customerDetailsData',
        'termAndConditionData',
        'headerOrFooterData',
        'noteData',
        'qtnSpecData',
        'loginData',
        'salesPersonData',
        'followUpHistoryData',
    ];

    protected $appends = ['item_details','billing_terms','quotation_total_amount'];

    public function createdBy()
    {
        return $this->hasOne(User::class, '_id', 'addedFrom');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, '_id', 'addedFrom');
    }

    public function itemDetails()
    {
        return $this->hasMany(SalesQuotationItems::class, 'salesQuotationId', '_id');
    }

    protected function getItemDetailsAttribute()
    {
        return $this->itemDetails()->get();
    }

    protected function getQuotationTotalAmountAttribute()
    {
        return $this->itemDetails()->sum('netAmount');
    }

    public function billingTerms()
    {
        return $this->hasMany(SalesQuotationBillingTerms::class,'salesQuotationId','_id');
    }

    protected function getBillingTermsAttribute()
    {
        return $this->billingTerms()->get();
    }
}
