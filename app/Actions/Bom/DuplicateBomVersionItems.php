<?php

namespace App\Actions\Bom;

use App\Models\Bom\BomVersionItem;
use Lorisleiva\Actions\Concerns\AsAction;

class DuplicateBomVersionItems
{
    use AsAction;

    public function __construct(
        protected BomVersionItem $bomVersionItem
    )
    {}

    public function handle(
        array $ids,
        string $destinationId,
        string $bomId
    ): array
    {
        $itemDetails = $this->bomVersionItem->query()
            ->with('children')
            ->whereIn('versionId', $ids)
            ->whereNull('versionItemId')
            ->get();

        return $this->getVersionItemsChild(
            items: $itemDetails,
            destinationId: $destinationId,
            bomId: $bomId
        );
    }

    private function getVersionItemsChild(
        object $items,
        string $destinationId,
        string $bomId,
        ?string $parentId = null
    ): array
    {
        $copies = [];
        foreach ($items as $key => $item) {
            $copies[$key] = $item;
            $this->saveFormData(
                item: $item,
                destinationId: $destinationId,
                bomId: $bomId,
                parentId: $parentId
            );
        }

        return $copies;
    }

    private function saveFormData(
        object $item,
        string $destinationId,
        string $bomId,
        ?string $parentId = null
    ): void
    {
        $dataInsert = [
            'bomId' => $bomId,
            'versionId' => $destinationId,
            'versionItemId' => $parentId,
            'itemType' => $item->itemType ?? null,
            'itemCode' => $item->itemCode ?? null,
            'itemDescription' => $item->itemDescription ?? null,
            'itemAddDescription' => $item->itemAddDescription ?? null,
            'itemDrawingNumber' => $item->itemDrawingNumber ?? null,
            'itemMaterialSpecification' => $item->itemMaterialSpecification ?? null,
            'itemBomQty' => $item->itemBomQty ?? null,
            'itemBomQtyConv' => $item->itemBomQtyConv ?? null,
            'itemConvFactor' => $item->itemConvFactor ?? null,
            'itemUom' => $item->itemUom ?? null,
            'itemConvUom' => $item->itemConvUom ?? null,
            'itemConvQty' => $item->itemConvQty ?? null,
            'itemMaterialProcessType' => $item->itemMaterialProcessType ?? null,
            'itemAssemblyBomNumber' => $item->itemAssemblyBomNumber ?? null,
            'itemNote' => $item->itemNote ?? null,
            'itemDetailDescription' => $item->itemDetailDescription ?? null,
            'itemCurrentStock' => $item->itemCurrentStock ?? null,
            'itemPositionNumber' => $item->itemPositionNumber ?? null,
            'itemDrawingRevision' => $item->itemDrawingRevision ?? null,
            'itemIssueAtProcess' => $item->itemIssueAtProcess ?? null,
            'itemMake' => $item->itemMake ?? null,
            'itemStore' => $item->itemStore ?? null,
            'itemMaterialInput1' => $item->itemMaterialInput1 ?? null,
            'itemMaterialInput2' => $item->itemMaterialInput2 ?? null,
            'itemMaterialLenght' => $item->itemMaterialLenght ?? null,
            'itemMaterialQty' => $item->itemMaterialQty ?? null,
            'itemMaterialWeight' => $item->itemMaterialWeight ?? null,
            'itemRateFrom' => $item->itemRateFrom ?? null,
        ];

        $response = BomVersionItem::saveData($dataInsert);

        if (count($item->children) > 0) {
            $this->getVersionItemsChild(
                items: $item->children,
                destinationId: $destinationId,
                bomId: $bomId,
                parentId: $response->_id
            );
        }
    }
}
