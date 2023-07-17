<?php

namespace App\Services\ProductionPlanning;

use App\Contracts\RequestServiceInterface;
use App\Enums\Inventory\TransactionTypeEnum;
use App\Http\Requests\ProductionPlanning\IssueQtyForJobCardRequest;
use App\Models\Inventory\LotOfStockLedger;
use App\Models\Inventory\MaterialIssue;
use App\Models\Inventory\StockLedger;
use App\Models\Inventory\Transaction;
use App\Models\ProductionPlanning\ShowIssueItems;
use Illuminate\Http\Request;

class JobCardMaterialIssueService implements RequestServiceInterface
{

    /**
     * @inheritDoc
     */
    public function handle(
        IssueQtyForJobCardRequest|Request $request
    ): ShowIssueItems
    {
        $showIssueItemId = $request->showIssueItemId;
        $canIssueQty = $request->canIssueQty;

        $materialIssue = materialIssue();
        $showIssueItem = $this->issueMaterialShowIssueItem(
            showIssueItemId: $showIssueItemId,
            canIssueQty: (float)$canIssueQty
        );
        $transaction = $this->createTransactionForItem(
            showIssueItem: $showIssueItem,
            materialIssue: $materialIssue
        );
        $this->createStockLedger(
            showIssueItem: $showIssueItem,
            transaction: $transaction
        );

        return $showIssueItem;
    }

    /**
     * @param string $showIssueItemId
     * @param float $canIssueQty
     * @return ShowIssueItems
     */
    protected function issueMaterialShowIssueItem(
        string $showIssueItemId,
        float $canIssueQty
    ): ShowIssueItems
    {
        $showIssueItem = ShowIssueItems::with('itemDetails')->find($showIssueItemId);
        $showIssueItem->issueItemPendingQty = (float)$showIssueItem->issueItemPendingQty - $canIssueQty;
        $showIssueItem->issueItemQty = (float)$showIssueItem->issueItemQty + $canIssueQty;
        $showIssueItem->update();
        return $showIssueItem;
    }

    /**
     * @param ShowIssueItems $showIssueItem
     * @param MaterialIssue $materialIssue
     * @return Transaction
     */
    protected function createTransactionForItem(
        ShowIssueItems $showIssueItem,
        MaterialIssue $materialIssue
    ): Transaction
    {
        $transaction = Transaction::saveData([
            'itemId' => $showIssueItem->itemId,
            'itemCode' => $showIssueItem->item_name->itemCode,
            'itemDescription' => $showIssueItem->issueItemDescription,
            'itemAddDescription' => $showIssueItem->issueItemAddDescription,
            'itemDetailDescription' => $showIssueItem->issueItemDetailDescription,
            'itemDrawingNo' => $showIssueItem->issueItemDrawingNo,
            'itemRev' => $showIssueItem->issueItemRevision,
            'itemMake' => $showIssueItem->itemDetails->make,
            'transaction' => 3,
            'documentNo' => $showIssueItem->jobCard_number->jobCardNumber,
            'documentDate' => $showIssueItem->jobCard_number->jobCardDate,
            'transactionQty' => $showIssueItem->issueItemQty,
            'rejectedQty' => null,
            'rate' => null,
            'value' => null,
            'woPoNo' => null,
            'openingStock' => 0,
            'currentStock' => $showIssueItem->issueCurrentStock,
            'minimumStock' => 0,
            'leadTime' => null,
            'reference' => null,
            'party' => null,
            'transactionType' => TransactionTypeEnum::Issue,
            'itemUom' => $showIssueItem->issueItemUom,
            'conversionUom' => $showIssueItem->issueItemConvUom,
            'cFactor' => $showIssueItem->issueItemConvFactor,
            'conversionQty' => $showIssueItem->issueItemConvQty,
            'issueByPerson' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'receivedByPerson' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'remark' => $showIssueItem->issueItemremark,
            'materialIssueId' => $materialIssue->_id,
        ]);

        $showIssueItem->transaction()->save($transaction);

        return $transaction;
    }

    /**
     * @param ShowIssueItems $showIssueItem
     * @param Transaction $transaction
     * @return void
     */
    protected function createStockLedger(
        ShowIssueItems $showIssueItem,
        Transaction $transaction
    ): void
    {
        $query = LotOfStockLedger::query()->with('stockLedger');
        if (!is_null($showIssueItem->jobCard_number)) {
            $query->where('documentNumber', $showIssueItem->jobCard_number->jobCardNumber);
            $lot = $query->first();
        }

        $stockLedger = StockLedger::saveData([
            'itemId' => $showIssueItem->itemId,
            'itemCode' => $showIssueItem->item_name->itemCode,
            'itemDescription' => $showIssueItem->issueItemDescription,
            'itemAddDescription' => $showIssueItem->issueItemAddDescription,
            'itemDetailDescription' => $showIssueItem->issueItemDetailDescription,
            'itemDrawingNo' => $showIssueItem->issueItemDrawingNo,
            'itemRev' => $showIssueItem->issueItemRevision,
            'itemMake' => $showIssueItem->itemDetails->make,
            'transaction' => 3,
            'documentNo' => $showIssueItem->jobCard_number->jobCardNumber,
            'documentDate' => $showIssueItem->jobCard_number->jobCardDate,
            'transactionQty' => $showIssueItem->issueItemQty,
            'rejectedQty' => null,
            'rate' => null,
            'value' => null,
            'woPoNo' => null,
            'openingStock' => 0,
            'currentStock' => $showIssueItem->issueCurrentStock,
            'minimumStock' => 0,
            'leadTime' => null,
            'reference' => null,
            'party' => null,
            'transactionType' => TransactionTypeEnum::Issue,
            'itemUom' => $showIssueItem->issueItemUom,
            'conversionUom' => $showIssueItem->issueItemConvUom,
            'cFactor' => $showIssueItem->issueItemConvFactor,
            'conversionQty' => $showIssueItem->issueItemConvQty,
            'issueByPerson' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'receivedByPerson' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'remark' => $showIssueItem->issueItemremark,
            'transaction_id' => $transaction->_id,
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
                'documentNumber' => $showIssueItem->jobCard_number->jobCardNumber,
                'documentDate' => $showIssueItem->jobCard_number->jobCardDate
            ]);

            //Stock Assign Lot
            $lot->stockLedger()->save($stockLedger);
        }

        $lot->stockLedger()->save($stockLedger);
    }
}
