<?php

namespace App\Actions\Sales;

use App\Models\SalesCrm\SalesOrder;
use App\Models\SalesCrm\SalesOrderAgent;
use App\Models\SalesCrm\SalesOrderBillingTerms;
use App\Models\SalesCrm\SalesOrderChecklist;
use App\Models\SalesCrm\SalesOrderHistory;
use App\Models\SalesCrm\SalesOrderItems;
use App\Models\SalesCrm\SalesOrderPaymentSchedule;
use App\Models\SalesCrm\SalesOrderStages;
use App\Models\SalesCrm\SalesOrderTermCondition;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class salesOrderAddRemoveAction
{
    use AsAction;

    public function handle(array $data): ?object
    {
        if (count($data) == count($data, COUNT_RECURSIVE)) {
            $party_master = SalesOrderItems::saveData($data);
        } else {
            SalesOrderItems::deleteData(['salesOrderId' => $data[0]['salesOrderId']]);

            foreach ($data as $value) {
                $party_master = SalesOrderItems::saveData($value);
            }
        }

        return $party_master ?? null;
    }

    public function removeAllSalesOrderRelatedData($id): void
    {
        SalesOrder::with([
            'salesOrderItemDetails' => fn ($items) => $items->delete(),
            'billingTerm' => fn ($billingTerms) => $billingTerms->delete(),
            'salesOrderAgent' => fn ($agents) => $agents->delete(),
            'termAndCondition' => fn ($terms) => $terms->delete(),
            'salesOrderStage' => fn ($stages) => $stages->delete(),
            'salesOrderHistory' => fn ($history) => $history->delete(),
            'salesOrderChecklist' => fn ($checkList) => $checkList->delete(),
            'salesOrderPaymentSchedule' => fn ($payments) => $payments->delete(),
        ])->find($id)->delete();
    }
}
