<?php

namespace App\Services\ProductionPlanning;

use App\Contracts\RequestServiceInterface;
use App\Models\Bom\BomVersionItem;
use App\Models\ProductionPlanning\JobCardProcessDetails;
use App\Models\ProductionPlanning\JobCards;
use App\Models\ProductionPlanning\ProcessSheetList;
use App\Models\ProductionPlanning\ProcessSheetMaster;
use App\Models\ProductionPlanning\ShowIssueItems;
use Illuminate\Http\Request;

class JobCardService implements RequestServiceInterface
{
    public function handle(Request $request)
    {
        $dataInsert = $request->all();
        $dataInsert['jobCardNumber'] = generateCodes(new JobCards(), 'J00001', 'jobCardNumber', 'J');
        $bomVersionId = $dataInsert['bomNumber'] ?? null;
        $processNo = $dataInsert['processSheetNo'] ?? null;

        $response = JobCards::saveData($dataInsert);
        if ($response) {
            $processId = ProcessSheetMaster::where('processSheetNo', $processNo)->first()?->_id ?? null;
            if ($processId) {
                $this->addProcessSheetItems(
                    jobCard: $response,
                    processId: $processId
                );
            }
            if ($bomVersionId) {
                $this->addShowIssueItems(
                    jobCardId: $response->_id,
                    bomVersionId: $bomVersionId,
                    jobQty: (float)$response->quantityUm
                );
            }
        }

        return $response;
    }

    /**
     * @param JobCards $jobCard
     * @param string|null $processId
     * @return void
     */
    protected function addProcessSheetItems(
        JobCards $jobCard,
        ?string $processId
    ): void
    {
        $processSheets = ProcessSheetList::getData(['processSheetId' => $processId]);
        if ($processSheets->isNotEmpty()) {
            $processSheets->each(function (ProcessSheetList $processSheet) use ($jobCard) {
                JobCardProcessDetails::saveData([
                    'processId' => $processSheet->processId ?? null,
                    'processItemId' => $processSheet->processItemId ?? null,
                    'processSheetId' => $processSheet->processSheetId ?? null,
                    'bomId' => null,
                    'jobId' => $jobCard->_id,
                    'machineNumber' => $processSheet->machineNo ?? null,
                    'process' => $processSheet->_id ?? null,
                    'processDescription' => $processSheet->processDesc ?? null,
                    'operator' => null,
                    'quantity' => (float)$jobCard->quantityUm ?? 0,
                    'pendingQty' => (float)$jobCard->pendingJobQty ?? 0,
                    'acceptedQty' => (float)$jobCard->acceptedQty ?? 0,
                    'rejectedQty' => (float)$jobCard->rejectedQty ?? 0,
                    'rwQty' => (float)$jobCard->rwQty ?? 0,
                    'inspInstruction' => $processSheet->inspectionInst ?? null,
                    'inspectionBy' => $processSheet->inspectionBy ?? null,
                    'inspectionLevel' => $processSheet->inspectionLevel ?? null,
                    'specialTool' => $processSheet->specialTool ?? null,
                    'wtLoss' => $processSheet->wtLossPer ?? null,
                    'matWt' => $processSheet->matWt ?? null,
                    'scrapTolerance' => $processSheet->scrapTolerancePer ?? null,
                    'noOfHr' => null,
                    'setupTimeInMinute' => (float)$processSheet->setupTimeInMinute ?? 0,
                    'processTimeInMinute' => (float)$processSheet->processTimeInMinute ?? 0,
                    'remark' => null,
                ]);
            });
        }
    }

    /**
     * @param string|null $jobCardId
     * @param string|null $bomVersionId
     * @param float $jobQty
     * @return void
     */
    protected function addShowIssueItems(
        ?string $jobCardId,
        ?string $bomVersionId,
        float   $jobQty
    ): void
    {
        $bomVersionItems = BomVersionItem::getData(['versionId' => $bomVersionId, 'versionItemId' => null]);
        if ($bomVersionItems->isNotEmpty()) {
            $bomVersionItems->each(function ($bomVersionItem) use ($jobQty, $jobCardId) {
                ShowIssueItems::saveData([
                    'jobId' => $jobCardId,
                    'itemId' => $bomVersionItem->itemCode ?? null,
                    'issueItemCode' => $bomVersionItem->itemCode ?? null,
                    'issueItemDescription' => $bomVersionItem->itemDescription ?? null,
                    'issueItemAddDescription' => $bomVersionItem->itemAddDescription ?? null,
                    'issueItemDetailDescription' => $bomVersionItem->itemDetailDescription ?? null,
                    'issueItemDrawingNo' => $bomVersionItem->itemDrawingNumber ?? null,
                    'issueItemRevision' => $bomVersionItem->itemDrawingRevision ?? null,
                    'issueRequiredQty' => $bomVersionItem->itemBomQty ?? 0,
                    'issueRequiredQtyConv' => $bomVersionItem->itemConvQty ?? 0,
                    'issueItemQty' => 0,
                    'issueItemPendingQty' => $bomVersionItem->itemBomQty ?? null,
                    'issueItemUom' => getUomIdFromName(name: $bomVersionItem->itemUom) ?? null,
                    'issueItemConvUom' => $bomVersionItem->itemConvUom ?? null,
                    'issueItemConvFactor' => $bomVersionItem->itemConvFactor ?? null,
                    'issueItemConvQty' => $bomVersionItem->itemConvQty ?? null,
                    'issueCurrentStock' => $bomVersionItem->itemCurrentStock ?? 0,
                    'issueStockSubContractor' => 0,
                    'issueItemremark' => $bomVersionItem->itemNote ?? null,
                ]);
            });
        }
    }
}
