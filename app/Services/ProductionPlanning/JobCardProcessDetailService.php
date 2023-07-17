<?php


namespace App\Services\ProductionPlanning;


use App\Models\Bom\BomVersionItem;
use App\Models\ProductionPlanning\JobCardProcessDetails;
use App\Models\ProductionPlanning\ShowIssueItems;

class JobCardProcessDetailService
{

    private JobCardProcessDetails $jobCardDetails;
    private BomVersionItem $bomVersionItem;
    private ShowIssueItems $showIssueItems;

    public function __construct(JobCardProcessDetails $jobCardDetails, BomVersionItem $bomVersionItem, ShowIssueItems $showIssueItems)
    {

        $this->jobCardDetails = $jobCardDetails;
        $this->bomVersionItem = $bomVersionItem;
        $this->showIssueItems = $showIssueItems;
    }

    public function saveProcessDetails(array $data)
    {
        $response = $this->jobCardDetails->saveData($data);
        $bomItems = collect($this->bomVersionItem->getData(['versionId' => $data['bomId']]));
        $this->saveBomVersionItemInProcessItem($response->_id, $response->jobId, $bomItems);
        return $response;
    }

    private function saveBomVersionItemInProcessItem(string $processId, string $jobId, object $bomItems)
    {
        foreach ($bomItems as $key => $item) {
            $dataInsert['processId'] = $processId;
            $dataInsert['jobId'] = $jobId;
            $dataInsert['issueItemCode'] = $item->itemCode ?? null;
            $dataInsert['issueItemDescription'] = $item->itemDescription ?? null;
            $dataInsert['issueItemAddDescription'] = $item->itemAddDescription ?? null;
            $dataInsert['issueItemDrawingNo'] = $item->itemDrawingNumber ?? null;
            $dataInsert['issueItemRevision'] = $item->itemDrawingRevision ?? null;
            $dataInsert['issueRequiredQty'] = $item->itemBomQty ?? null;
            $dataInsert['issueRequiredQtyConv'] = $item->itemBomQtyConv ?? null;
            $dataInsert['issueItemQty'] = 0;
            $dataInsert['issueItemUom'] = $item->itemUom ?? null;
            $dataInsert['issueItemConvUom'] = $item->itemConvUom ?? null;
            $dataInsert['issueItemConvFactor'] = $item->itemConvFactor ?? null;
            $dataInsert['issueItemConvQty'] = $item->itemConvQty ?? null;
            $dataInsert['issueCurrentStock'] = $item->itemCurrentStock ?? null;
            $dataInsert['issueStockSubContractor'] = null;
            $dataInsert['issueItemremark'] = $item->itemNote ?? null;
            $this->showIssueItems->saveData($dataInsert);
        }
    }

}
