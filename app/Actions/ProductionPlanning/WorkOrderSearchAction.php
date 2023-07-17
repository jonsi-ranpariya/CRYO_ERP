<?php

namespace App\Actions\ProductionPlanning;

use App\Contracts\RequestServiceInterface;
use App\Models\ProductionPlanning\WorkOrder;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class WorkOrderSearchAction implements RequestServiceInterface
{
    use AsAction;

    public function handle(Request $request)
    {
        $woNumber = $request->woNumber;
        $itemDescription = $request->itemDescription;
        $itemCode = $request->itemCode;
        $drawingNumber = $request->drawingNumber;
        $soNo = $request->soNo;
        $partyName = $request->soNo;

        $workOrder = WorkOrder::with(['partyDetails' => function ($query) use ($partyName) {
            $query->select(['_id', 'partyCode', 'partyName']);

            if ($partyName) {
                $query->where('partyName', 'LIKE', $partyName . '%');
            }
        }]);

        if ($woNumber) {
            $workOrder->where('woNumber', 'LIKE', '%' . $woNumber . '%');
        }

        if ($itemDescription) {
            $workOrder->where('assembly', 'LIKE', '%' . $itemDescription . '%');
        }

        if ($itemCode) {
            $workOrder->where('assemblyCode', 'LIKE', '%' . $itemCode . '%');
        }

        if ($drawingNumber) {
            $workOrder->where('drawingNo', 'LIKE', '%' . $drawingNumber . '%');
        }

        if ($soNo) {
            $workOrder->where('soNumber', 'LIKE', '%' . $soNo . '%');
        }

        return $workOrder->get();
    }
}
