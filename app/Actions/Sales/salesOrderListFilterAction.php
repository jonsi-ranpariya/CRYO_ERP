<?php

namespace App\Actions\Sales;

use App\Models\Despatch\NewChallanInvoice;
use App\Models\SalesCrm\SalesOrderItems;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class salesOrderListFilterAction
{
    use AsAction;

    public function __construct(protected SalesOrderItems $salesOrderItems, protected NewChallanInvoice $newChallanInvoice)
    {
    }

    public function handle(Request $request): array
    {
        $soNumber = $request->soNumber;
        $itemCode = $request->itemCode;
        $description = $request->description;
        $drawingNumber = $request->drawingNumber;
        $challanInvoiceId = $request->challanInvoiceId;

        if ($challanInvoiceId) {
            $challanData = $this->newChallanInvoice->getDataFromId($challanInvoiceId, false, ['_id', 'SellToParty']);

            $salesOrderItem = $this->salesOrderItems->with(['salesOrder' =>
                fn($q) => $q->where(['sellToPartyCustomerID' => $challanData->SellToParty])
            ])->where('itemStatus', 'Pending');
        } else {
            $salesOrderItem = $this->salesOrderItems->with(['salesOrder' =>
                fn($q) => $q->where(['SalesOrderStageDetail.stage' => 'Approved'])
            ]);
        }

        if (!empty($soNumber)) {
            $salesOrderItem->where('salesOrderNo', 'LIKE', "%{$soNumber}%");
        }

        if (!empty($itemCode)) {
            $salesOrderItem->where('itemCode', 'LIKE', "%{$itemCode}%");
        }

        if (!empty($description)) {
            $salesOrderItem->where('description', 'LIKE', "%{$description}%");
        }

        if (!empty($drawingNumber)) {
            $salesOrderItem->where('itemDrawingNo', 'LIKE', "%{$drawingNumber}%");
        }

        $salesOrderItems = $salesOrderItem->get();

        foreach ($salesOrderItems as $key => $item) {
            if (!empty($item->salesOrder)) {
                $response[$key] = $item;
            }
        }

        return array_values($response ?? []);
    }
}
