<?php

namespace App\Services\bom;

use App\Models\Bom\BillOfMaterialVersion;

class BomVersionService
{
    /**
     * @param string|null $itemCode
     * @return array
     */
    public function getBomItemsFromVersion(?string $itemCode): array
    {
        $fetchData = BillOfMaterialVersion::with(['bomDetails' =>
            fn($query) => $query->where(['itemCode' => $itemCode]),
        ])->has('bomDetails')->get();

        foreach ($fetchData as $key => $version) {
            if ($version->bomDetails) {
                $response[$key]['label'] = $version->bomNumber . ' - ' . $version->bomDescription;
                $response[$key]['value'] = $version->_id;
            }
        }

        return array_values($response ?? []);
    }

    /**
     * @param string|null $bomId
     * @return mixed
     */
    public function getBomVersionDetails(?string $bomId): mixed
    {
        return BillOfMaterialVersion::with(['versionItems' => function ($query) {
            $query->select(['_id', 'bomId', 'versionId']);
        }])
            ->has('versionItems')
            ->where(['bomId' => $bomId])
            ->get(['_id', 'bomDescription', 'bomVersion', 'bomNumber']);
    }
}
