<?php

namespace App\Actions\Sales;

use App\Models\SalesCrm\SalesOrder;
use App\Models\SalesCrm\SalesOrderBillingTerms;
use App\Models\SalesCrm\SalesOrderItems;
use App\Models\SalesCrm\SalesOrderPaymentSchedule;
use Lorisleiva\Actions\Concerns\AsAction;

class SalesOrderPaymentCalculationAction
{
    use AsAction;

    public function handle($id)
    {
        $SalesOrderItems = SalesOrderItems::query()->where('salesOrderId', $id);
        $response = [
            'itemNetAmount' => $SalesOrderItems->sum('itemNetAmount'),
            'itemAmount' => $SalesOrderItems->sum('itemAmount')
        ];

        $SalesOrderBillingTerms = SalesOrderBillingTerms::query()
            ->where('salesOrderId', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($SalesOrderBillingTerms as $salesOrderBillingTerm) {
            if ($salesOrderBillingTerm->billingType === 0) {
                $response['itemNetAmount'] = $response['itemNetAmount'] + ($response['itemNetAmount'] / 100 * $salesOrderBillingTerm->billingPercentage);
            }

            if ($salesOrderBillingTerm->billingType === 1) {
                $response['itemNetAmount'] = $response['itemNetAmount'] + $salesOrderBillingTerm->billingValue;
            }
        }

        $SalesOrderPaymentSchedule = SalesOrderPaymentSchedule::query()
            ->where('salesOrderId', $id);
        $response['totalPendingAmount'] = ($response['itemNetAmount'] - $SalesOrderPaymentSchedule->sum('amount'));

        $SalesOrderPaymentSchedule->update([
            'pendingAmount' => $response['totalPendingAmount']
        ]);

        $salesOrder = SalesOrder::getDataFromId($id);
        $salesOrder->update([
            'totalPayment' => $response['itemNetAmount'],
            'totalPendingAmount' => $response['totalPendingAmount']
        ]);

        return $response;
    }
}
