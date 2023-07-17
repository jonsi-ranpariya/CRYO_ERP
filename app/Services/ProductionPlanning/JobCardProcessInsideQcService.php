<?php

namespace App\Services\ProductionPlanning;

use App\Contracts\RequestServiceInterface;
use App\Enums\Inventory\TransactionTypeEnum;
use App\Models\Inventory\LotOfStockLedger;
use App\Models\Inventory\StockLedger;
use App\Models\Inventory\Transaction;
use App\Models\QualityControl\JobCardProcessInsideQc;
use Illuminate\Http\Request;

class JobCardProcessInsideQcService implements RequestServiceInterface
{

    /**
     * @inheritDoc
     */
    public function handle(Request $request)
    {
        $dataInsert = $request->all();
        $jobCardInsideQc = JobCardProcessInsideQc::saveData($dataInsert);

        $transaction = $this->addTransactionAndAssignLot(jobCardInsideQc: $jobCardInsideQc);

        $this->addStockLedgerWithLot(
            jobCardInsideQc: $jobCardInsideQc,
            transaction: $transaction
        );

        return $jobCardInsideQc;
    }

    /**
     * @param JobCardProcessInsideQc $jobCardInsideQc
     * @return Transaction
     */
    private function addTransactionAndAssignLot(
        JobCardProcessInsideQc $jobCardInsideQc
    ): Transaction
    {
        $transaction = Transaction::saveData([
            'itemId' => getItemMasterIdByItemCode(itemCode: $jobCardInsideQc->itemCode),
            'itemCode' => $jobCardInsideQc->itemCode,
            'itemDescription' => $jobCardInsideQc->itemDescription,
            'itemAddDescription' => $jobCardInsideQc->itemAddDescription,
            'itemDetailDescription' => $jobCardInsideQc->itemDetailDescription,
            'itemDrawingNo' => $jobCardInsideQc->itemDrawingNo,
            'itemRev' => $jobCardInsideQc->itemRev,
            'itemMake' => $jobCardInsideQc->itemMake,
            'transaction' => 2,
            'documentNo' => $jobCardInsideQc->jobCardNo ?? null,
            'documentDate' => $jobCardInsideQc->jobCardDate ?? null,
            'transactionQty' => (int)$jobCardInsideQc->acceptedQty ?? 0,
            'rejectedQty' => (int)$jobCardInsideQc->rejectedQty ?? 0,
            'rate' => 0,
            'value' => 0,
            'woPoNo' => $jobCardInsideQc->workOrderNo ?? null,
            'openingStock' => 0,
            'currentStock' => 0,
            'minimumStock' => 0,
            'leadTime' => null,
            'reference' => null,
            'party' => null,
            'transactionType' => TransactionTypeEnum::Receipt,
            'itemUom' => $jobCardInsideQc->itemUom,
            'conversionUom' => null,
            'cFactor' => null,
            'conversionQty' => null,
            'issueByPerson' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'receivedByPerson' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'remark' => $jobCardInsideQc->remarkDetails['remark'] ?? null,
        ]);
        $jobCardInsideQc->transactions()->save($transaction);

        return $transaction;
    }

    /**
     * @param JobCardProcessInsideQc $jobCardInsideQc
     * @param Transaction $transaction
     * @return void
     */
    private function addStockLedgerWithLot(
        JobCardProcessInsideQc $jobCardInsideQc,
        Transaction $transaction
    ): void
    {
        $query = LotOfStockLedger::query()->with('stockLedger');
        if (!is_null($jobCardInsideQc->grnId)) {
            $query->where('grnId', $jobCardInsideQc->grnId);
            //get lot GRN Wise
            $lot = $query->first();
        }

        //create stock ledger
        $stockLeger = StockLedger::saveData([
            'itemId' => $transaction->itemId,
            'itemCode' => $jobCardInsideQc->itemCode,
            'itemDescription' => $jobCardInsideQc->itemDescription,
            'itemAddDescription' => $jobCardInsideQc->itemAddDescription,
            'itemDetailDescription' => $jobCardInsideQc->itemDetailDescription,
            'itemDrawingNo' => $jobCardInsideQc->itemDrawingNo,
            'itemRev' => $jobCardInsideQc->itemRev,
            'itemMake' => $jobCardInsideQc->itemMake,
            'transaction' => 2,
            'documentNo' => $jobCardInsideQc->jobCardNo ?? null,
            'documentDate' => $jobCardInsideQc->jobCardDate ?? null,
            'transactionQty' => (int)$jobCardInsideQc->acceptedQty ?? 0,
            'rejectedQty' => (int)$jobCardInsideQc->rejectedQty ?? 0,
            'rate' => 0,
            'value' => 0,
            'woPoNo' => $jobCardInsideQc->workOrderNo ?? null,
            'openingStock' => 0,
            'currentStock' => 0,
            'minimumStock' => 0,
            'leadTime' => null,
            'reference' => null,
            'party' => null,
            'transactionType' => TransactionTypeEnum::Receipt,
            'itemUom' => $jobCardInsideQc->itemUom,
            'conversionUom' => null,
            'cFactor' => null,
            'conversionQty' => null,
            'issueByPerson' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'receivedByPerson' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'remark' => $jobCardInsideQc->remarkDetails['remark'] ?? null,
        ]);

        if (empty($lot)) {
            $lotNumber = generateCodes(
                modal: new LotOfStockLedger(),
                initialCode: '00000001',
                dbField: 'lotNumber',
                assignLot: true
            );

            //Create Lot
            $lot = LotOfStockLedger::saveData([
                'lotNumber' => $lotNumber,
                'itemId' => $transaction->itemId,
                'grnId' => null,
                'poId' => null,
                'grnItemId' => null,
                'poItemId' => null,
                'inwardQcId' => null,
            ]);

            //Stock Assign Lot
            $lot->stockLedger()->save($stockLeger);
        }

        //Stock Assign Lot
        $lot->stockLedger()->save($stockLeger);
    }
}
