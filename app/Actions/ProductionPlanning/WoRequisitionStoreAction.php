<?php

namespace App\Actions\ProductionPlanning;

use App\Contracts\RequestServiceInterface;
use App\Models\ProductionPlanning\ShowIssueItems;
use App\Models\ProductionPlanning\WoRequisition;
use App\Models\ProductionPlanning\WoRequisitionItems;
use App\Models\ProductionPlanning\WorkOrderItem;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class WoRequisitionStoreAction implements RequestServiceInterface
{
    use AsAction;

    public function handle(Request $request)
    {
        $data = $request->all();
        $data['reqNumber'] = generateCodes(new WoRequisition(), '00001', 'reqNumber');
        $response = WoRequisition::saveData($data);

        if ($response) {
            if (!empty($data['itemList'])) {
                $this->storeWoItems(
                    itemRequisitionId: $response->_id,
                    itemsList: $data['itemList']
                );
            }
            if (!empty($data['jobCardItemIds']) and !empty($data['jobCardId'])) {
                $this->storeJobCardItems(
                    itemRequisitionId: $response->_id,
                    jobCardId: $data['jobCardId'],
                    jobCardItems: $data['jobCardItemIds']
                );
            }
        }

        return $response;
    }

    private function storeWoItems(
        string $itemRequisitionId,
        array $itemsList
    ): void
    {
        $workOrderItems = WorkOrderItem::query()->whereIn('_id', $itemsList)->get();
        if ($workOrderItems->isNotEmpty()) {
            $workOrderItems->each(callback: function (WorkOrderItem $item) use ($itemRequisitionId) {
                $item->setAppends(['uom_detail']);
                WoRequisitionItems::saveData([
                    'woRequitionId' => $itemRequisitionId,
                    'jobCardId' => null,
                    'jobCardItemId' => null,
                    'itemType' => $item->itemType,
                    'itemCode' => $item->itemCode,
                    'itemDescription' => $item->itemDescription ?? null,
                    'itemAddDescription' => $item->itemAddDescription ?? null,
                    'itemDrawingNumber' => $item->itemDrawingNumber ?? null,
                    'itemDrawingRevision' => $item->itemRevision ?? null,
                    'itemUom' => $item->uom_detail->uom ?? null,
                    'itemConvUom' => $item->itemConvUom ?? null,
                    'itemDetailDescription' => $item->itemDetailDescription ?? null,
                    'itemReqQty' => $item->itemReqQty ?? null,
                    'itemReqQtyConv' => $item->itemReqQtyConv ?? null,
                    'itemPendingQty' => $item->itemReqQty ?? null,
                    'itemCfactor' => $item->itemConvFactor ?? null,
                    'itemCurrentStock' => $item->itemCurrentStock ?? null,
                    'itemConvQty' => $item->itemConvQty ?? null
                ]);
            });
        }
    }

    /**
     * @param string $itemRequisitionId
     * @param string $jobCardId
     * @param array $jobCardItems
     * @return void
     */
    private function storeJobCardItems(
        string $itemRequisitionId,
        string $jobCardId,
        array  $jobCardItems
    ): void
    {
        $issuesItems = ShowIssueItems::with('itemDetails')->whereIn('_id', $jobCardItems)->get();
        if ($issuesItems->isNotEmpty()) {
            $issuesItems->each(callback: function (ShowIssueItems $item) use ($itemRequisitionId, $jobCardId) {
                $item->setAppends(['uom_detail']);
                WoRequisitionItems::saveData([
                    'woRequitionId' => $itemRequisitionId,
                    'jobCardId' => $jobCardId,
                    'jobCardItemId' => $item->_id,
                    'itemType' => ($item->itemDetails->materialProcessType == 2) ? 'I' : 'A',
                    'itemCode' => $item->issueItemCode ?? null,
                    'itemDescription' => $item->issueItemDescription ?? null,
                    'itemAddDescription' => $item->issueItemAddDescription ?? null,
                    'itemDrawingNumber' => $item->issueItemDrawingNo ?? null,
                    'itemDrawingRevision' => $item->issueItemRevision ?? null,
                    'itemUom' => $item->uom_detail->uom ?? null,
                    'itemConvUom' => $item->issueItemConvUom ?? null,
                    'itemDetailDescription' => $item->issueItemDetailDescription ?? null,
                    'itemReqQty' => $item->issueItemQty ?? null,
                    'itemReqQtyConv' => $item->issueRequiredQtyConv ?? null,
                    'itemPendingQty' => $item->issueItemPendingQty ?? null,
                    'itemCfactor' => $item->issueItemConvFactor ?? null,
                    'itemCurrentStock' => $item->issueCurrentStock ?? null,
                    'itemConvQty' => $item->issueItemConvQty ?? null
                ]);
            });
        }
    }
}
