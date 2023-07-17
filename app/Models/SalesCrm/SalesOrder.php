<?php

namespace App\Models\SalesCrm;

use App\Models\Administration\Company;
use App\Models\BaseModel;
use Jenssegers\Mongodb\Relations\HasMany;

/**
 * @method withBillingTerm()
 * @method withTermAndCondition()
 */
class SalesOrder extends BaseModel
{
    protected $collection = 'sales_orders';
    protected $fillable = [
        'company',
        'salesOrderNo',
        'customerPoNo',
        'salesOrderPoDate',
        'salesOrderDate',
        'salesOrderCommittedDate',
        'salesOrderCurrency',
        'salesOrderConvRate',
        'salesOrderProject',
        'kindAttnId',
        'kindAttnName',
        'kindAttnMobile',
        'kindAttnEmail',
        'qtnRefNo',
        'qtnSrNo',
        'branchQtnNo',
        'roundingType',
        'salesOrderSalesType',
        'salesOrderStatus',
        'salesOrderType',
        'salesOrderBranch',
        'salesOrderSupplyType',
        'salesOrderGstType',
        'salesOrderReviewDate',
        'sellToPartyCustomerID',
        'sellToPartyCustomerCode',
        'sellToPartyCustomerName',
        'shipToPartyCustomerID',
        'shipToPartyCustomerCode',
        'shipToPartyCustomerName',
        'itemDetails',
        'termConditionDetails',
        'noteDetails',
        'partyDetail',
        'buyerDetail',
        'consigneeDetail',
        'dispatchDetail',
        'loginDetail',
        'SalesOrderStageDetail',
        'soStageDetails',
        'orderStatus',
        'approveBy',
        'approveUser',
        'approveDate',
        'totalPayment',
        'totalPendingAmount',
        'deviation'
    ];

    protected $hidden = ['updated_at'];

    public function salesOrderItemDetails(): HasMany
    {
        return $this->hasMany(SalesOrderItems::class, 'salesOrderId', '_id');
    }

    public function billingTerm(): HasMany
    {
        return $this->hasMany(SalesOrderBillingTerms::class, 'salesOrderId', '_id')->oldest('srNo');
    }

    public function termAndCondition(): HasMany
    {
        return $this->hasMany(SalesOrderTermCondition::class, 'salesOrderId', '_id');
    }

    public function salesOrderStage(): HasMany
    {
        return $this->hasMany(SalesOrderStages::class, 'salesOrderId', '_id');
    }

    public function salesOrderHistory(): HasMany
    {
        return $this->hasMany(SalesOrderHistory::class, 'salesOrderId', '_id');
    }

    public function salesOrderChecklist(): HasMany
    {
        return $this->hasMany(SalesOrderChecklist::class, 'salesOrderId', '_id');
    }

    public function salesOrderPaymentSchedule(): HasMany
    {
        return $this->hasMany(SalesOrderPaymentSchedule::class, 'salesOrderId', '_id');
    }

    public function salesOrderAgent(): HasMany
    {
        return $this->hasMany(SalesOrderAgent::class, 'salesOrderId', '_id');
    }

    public function scopeWithBillingTerm($query)
    {
        return $query->with(['billingTerm' => function ($q) {
            $q->oldest('srNo');
        }]);
    }

    public function scopeWithTermAndCondition($query)
    {
        return $query->with('termAndCondition');
    }

    public function companyDetails()
    {
        return $this->hasOne(Company::class,'_id', 'company');
    }
}
