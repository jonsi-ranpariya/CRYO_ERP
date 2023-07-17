<?php

namespace App\Models\SalesCrm;

use App\Models\Administration\Company;
use App\Models\BaseModel;
use App\Models\GST\MasterGst;
use Jenssegers\Mongodb\Relations\HasMany;
use Jenssegers\Mongodb\Relations\HasOne;

class SalesReturn extends BaseModel
{
    protected $collection = 'sales_return';
    protected $fillable = [
        'salesReturnNo',
        'salesReturnDate',
        'salesReturnCurrency',
        'salesReturnConvRate',
        'salesReturnRounding',
        'salesReturnRoundingAll',
        'salesReturnCustomerID',
        'salesReturnCustomerCode',
        'salesReturnCustomerName',
        'salesReturnInvoiceId',
        'salesReturnInvoiceNo',
        'salesReturnInvoiceDate',
        'manualInvoiceNumber',
        'salesReturnStage',
        'salesReturnReason',
        'customerDetail',
        'buyerDetails',
        'consigneeDetails',
        'dispatchDetails',
        'transportExportData',
        'loginDetail',
        'salesReturnAmount',
        'salesReturnGrossAmount',
        'salesReturnCompanyId',
        'manualCompanyId',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $hidden = ['updated_at'];

    protected $appends = ['net_amount', 'gross_amount','company_detail','master_gst'];

    public function itemDetails(): hasMany
    {
        return $this->hasMany(SalesReturnItems::class, 'salesReturnId', '_id');
    }

    public function getNetAmountAttribute()
    {
        return $this->itemDetails()->sum('itemNetAmount');
    }

    public function billingTerms(): hasMany
    {
        return $this->hasMany(SrBillingTerms::class, 'salesReturnId', '_id');
    }

    public function getGrossAmountAttribute()
    {
        $billingTerm = $this->billingTerms()->latest()->first();
        return $billingTerm ? round((float) $billingTerm->total_amount, 2) : 0;
    }

    public function companyData(): hasOne
    {
        return $this->hasOne(Company::class,'_id','salesReturnCompanyId');
    }

    public function getCompanyDetailAttribute()
    {
        return $this->companyData()->first();
    }

    public function masterGstData()
    {
        return $this->hasOne(MasterGst::class,'salesReturnId','_id');
    }

    public function getMasterGstAttribute()
    {
        return $this->masterGstData()->latest()->first();
    }
}
