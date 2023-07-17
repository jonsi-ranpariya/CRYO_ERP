<?php
/**
 * Created by Jaymeen Darji.
 * User: jaymeen
 * Date: 3/10/23
 * Time: 3:16 PM
 */

namespace App\Services\Inventory;

use App\Models\Inventory\LotOfStockLedger;
use App\Models\Inventory\StockLedger;
use App\Models\Inventory\Transaction;

class StockLedgerService
{
    public static string $stockLedgerDocNumber = 'CEPL-STR-FRM';

    /**
     * @var string
     */
    private static string $lotNumber;

    /**
     * @return string
     */
    public static function getLotNumber(): string
    {
        return self::$lotNumber;
    }

    /**
     * @param string $lotNumber
     */
    public static function setLotNumber(string $lotNumber): void
    {
        self::$lotNumber = $lotNumber;
    }

    public function __construct()
    {
        self::setLotNumber(lotNumber: generateCodes(
            modal: new LotOfStockLedger(),
            initialCode: '00000001',
            dbField: 'lotNumber',
            assignLot: true
        ));
    }

    /**
     * @param array $dataInsert
     * @return object|false|array|null
     */
    public function transactionStoreService(array $dataInsert): object|false|array|null
    {
        return match ($dataInsert['transaction']) {
            2 => $this->createTransactionWithStockLedger(transactionData: $dataInsert),
            3 => $this->createMaterialIssueTransaction(dataInsert: $dataInsert),
            default => null
        };
    }

    /**
     * @param array $dataInsert
     * @param string|null $lotNumber
     * @return object|null
     */
    public function createTransactionItem(array $dataInsert, ?string $lotNumber = null): ?object
    {
        $dataInsert['rejectedQty'] = (float)$dataInsert['rejectedQty'];
        $dataInsert['transactionQty'] = (float)$dataInsert['transactionQty'];
        $dataInsert['rate'] = (float)$dataInsert['rate'];
        $dataInsert['value'] = $dataInsert['transaction'] == 3
            ? -abs(num: $dataInsert['value'])
            : $dataInsert['value'];

        if (!is_null(value: $lotNumber)) {
            $dataInsert['lotNumber'] = $lotNumber;
        }

        return Transaction::saveData(data: $dataInsert);
    }

    /**
     * @param array $data
     * @param string|null $lotNumber
     * @return object|null
     */
    public function createStockLedgerItem(array $data, ?string $lotNumber = null): ?object
    {
        $lotQty = LotOfStockLedger::where('itemId', $data['itemId'])->sum('quantity');
        if ($data['transaction'] == 3) {
            $finalQty = -abs(num: $data['transactionQty']);
            $finalQty = $finalQty + $lotQty;
        } else {
            $finalQty = $data['transactionQty'] + $lotQty;
        }

        $stockLedger = StockLedger::saveData(data: [
            'stock_ledger_doc_number' => self::$stockLedgerDocNumber,
            'transaction_id' => $data['_id'],
            'transaction_type' => $data['transactionType'],
            'document_number' => $data['documentNo'],
            'document_date' => $data['documentDate'],
            'wo_po_number' => $data['woPoNo'],
            'rate' => $data['rate'],
            'qty' => $finalQty,
            'amount' => $data['value'],
            'balance_qty' => $finalQty,
            'item_id' => $data['itemId'],
            'lot_number' => is_null(value: $lotNumber) ? self::getLotNumber() : $lotNumber,
        ]);

        $assignLot = LotOfStockLedger::where('lotNumber', $stockLedger->lot_number)
            ->where('quantity', '>', 0)
            ->oldest()
            ->first();

        if (!empty($assignLot)) {
            $assignLot->quantity = $data['transaction'] == 3
                ? $assignLot->quantity - (float)$data['transactionQty']
                : $assignLot->quantity + (float)$data['transactionQty'];
            $assignLot->update();
        }

        return $stockLedger;
    }

    /**
     * @param Transaction $transaction
     * @return object|null
     */
    public function assignLot(Transaction $transaction): ?object
    {
        return LotOfStockLedger::saveData(data: [
            'lotNumber' => self::getLotNumber(),
            'quantity' => $transaction->transactionQty,
            'itemName' => $transaction->itemDescription,
            'itemId' => $transaction->itemId,
            'documentName' => $transaction->documentNo,
            'documentNumber' => $transaction->documentDate,
            'documentDate' => $transaction->woPoNo
        ]);
    }

    /**
     * @param array $transactionData
     * @return array
     */
    public function createTransactionWithStockLedger(array $transactionData): array
    {
        $transaction = $this->createTransactionItem(
            dataInsert: $transactionData,
            lotNumber: self::getLotNumber()
        );
        $stockLedger = $this->createStockLedgerItem(data: $transaction->toArray());
        $assignLot = $this->assignLot(transaction: $transaction);

        return compact('transaction', 'stockLedger', 'assignLot');
    }

    /**
     * @param array $dataInsert
     * @return object|null|false
     */
    public function createMaterialIssueTransaction(array $dataInsert): false|null|object
    {
        $stockLedger = StockLedger::with('assignLot')
            ->where('item_id', $dataInsert['itemId'])
            ->where('balance_qty', '>', 0)
            ->oldest()
            ->first();

        if (is_null($stockLedger)) {
            return false;
        }

        $transactionQty = (float)$dataInsert['transactionQty'];
        $balanceQty = (float)$stockLedger->balance_qty;
        $stockLedger->balance_qty = $balanceQty - $transactionQty;

        if ($stockLedger->assignLot->isNotEmpty()) {
            $pendingQty = $stockLedger->balance_qty;
            $currentUsedQty = $stockLedger->balance_qty + $transactionQty;

            if ($pendingQty < 0) {
                $dataInsert['transactionQty'] = $currentUsedQty;
            }

            $transaction = $this->createTransactionItem(
                dataInsert: $dataInsert,
                lotNumber: $stockLedger->lot_number
            );
            $this->createStockLedgerItem(
                data: $transaction->toArray(),
                lotNumber: $stockLedger->lot_number
            );

            $totalQty = $stockLedger->assignLot->sum('balance_qty');
            $stockLedger->balance_qty = $totalQty - $currentUsedQty;
            $stockLedger->update();

            if ($pendingQty < 0 && $stockLedger->assignLot->sum(column: 'quantity') > $transactionQty) {
                $dataInsert['transactionQty'] = abs(num: $pendingQty);
                $this->createMaterialIssueTransaction(dataInsert: $dataInsert);
            }

            return $transaction;
        } else {
            return false;
        }
    }
}
