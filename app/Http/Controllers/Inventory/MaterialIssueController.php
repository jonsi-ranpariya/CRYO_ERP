<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\ManualMaterialIssueRequest;
use App\Services\Inventory\StockLedgerService;

class MaterialIssueController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ManualMaterialIssueRequest $request
     */
    public function __invoke(ManualMaterialIssueRequest $request)
    {
        $materialList = collect(value: $request->materialIssueList);
        $itemIds = implode(',', $materialList->pluck('itemId')->toArray());
        $woNumbers = implode(',', $materialList->pluck('woNumber')->toArray());

        testDie($materialList);

        $materialList->each(callback: function (array $item): void {
            if (is_null(value: $item['woNumber'])) {
                $this->createTransaction(item: $item);
            } else {
                $this->createWorkOrderItem(item: $item);
            }
        });
        testDie('done');
    }

    protected function createWorkOrderItem(array $item)
    {
        testDie('with work order',0);
        testDie($item, 0);
    }

    protected function createTransaction(array $item)
    {
        testDie('without work order',0);
        testDie($item, 0);
    }
}
