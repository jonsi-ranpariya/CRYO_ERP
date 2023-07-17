<?php

namespace App\Imports\Master;

use App\Enums\Master\ItemMaster\AlphabetClassEnum;
use App\Enums\Master\ItemMaster\ItemTypeEnum;
use App\Enums\Master\ItemMaster\MaterialProcessTypeEnum;
use App\Enums\Master\ItemMaster\MaterialProvidedByEnum;
use App\Enums\Master\ItemMaster\PesoStatusEnum;
use App\Enums\Master\ItemMaster\PlanningEnum;
use App\Enums\Master\ItemMaster\StatusEnum;
use App\Enums\Master\ItemMaster\YesNoEnum;
use App\Models\Master\ItemMaster;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;

class ItemMasterImport implements WithBatchInserts, WithChunkReading, OnEachRow
{
    use Importable;

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function onRow(Row $row)
    {
        try {
            $rowIndex = $row->getIndex();
            $row = array_map('trim', $row->toArray());
            if ($rowIndex != 1) {
                $data['make'] = $row[0];
                $data['itemCategory'] = getItemCategoryOptionByName($row[1]);
                $data['itemGroup'] = getItemGroupOptionByName($row[2]);
                $data['itemCode'] = $row[3];
                $data['itemDescription'] = $row[4];
                $data['uom'] = getUomIdFromName($row[5]);
                $data['cFactor'] = $row[6] ?? null;
                $data['convQty'] = $row[7] ?? null;
                $data['convUom'] = getUomIdFromName($row[8]);
                $data['batchWiseStock'] = in_array($row[9], YesNoEnum::getKeys()) ? YesNoEnum::getValue($row[9]) : null;
                $data['itemType'] = in_array($row[10], ItemTypeEnum::getKeys()) ? ItemTypeEnum::getValue($row[10]) : null;
                $data['materialProcessType'] = in_array(str_replace('-', '_', strtolower($row[11])), MaterialProcessTypeEnum::getKeys())
                    ? MaterialProcessTypeEnum::getValue(str_replace('-', '_', strtolower($row[11])))
                    : null;
                $data['considerInAccount'] = in_array($row[12], YesNoEnum::getKeys()) ? YesNoEnum::getValue($row[12]) : null;
                $data['status'] = in_array(str_replace(' ', '_', $row[13]), StatusEnum::getKeys())
                    ? StatusEnum::getValue(str_replace(' ', '_', $row[13]))
                    : null;
                $data['reason'] = null;
                $data['date'] = null;
                $data['planning'] = in_array($row[14], PlanningEnum::getKeys())
                    ? PlanningEnum::getValue($row[14])
                    : null;
                $data['stockAllocationAtWo'] = null;
                $data['serialNoWiseStock'] = in_array($row[15], YesNoEnum::getKeys()) ? YesNoEnum::getValue($row[15]) : null;
                $data['peso_approve'] = in_array(str_replace(' ','_', $row[16]), PesoStatusEnum::getKeys())
                    ?  PesoStatusEnum::getValue(str_replace(' ','_', $row[16]))
                    : null;
                $data['peso_reason'] = null;
                /* GENERAL DETAILS */
                $data['itemDetails']['description'] = $row[17] ?? null;
                $data['itemDetails']['detailDescription'] = $row[18] ?? null;
                $data['itemDetails']['drawingNumber'] = $row[19] ?? null;
                $data['itemDetails']['revision'] = $row[20] ?? null;
                $data['itemDetails']['materialSpecification'] = $row[21] ?? null;
                $data['itemDetails']['remarkNote'] = $row[22] ?? null;
                $data['itemDetails']['mainGroup'] = getItemMainGroupSubGroup($row[23]);
                $data['itemDetails']['subGroup'] = getItemMainGroupSubGroup($row[24]);
                $data['itemDetails']['serialNoCode'] = $row[25] ?? null;
                $data['itemDetails']['isItemDetailsData'] = true;
                /* PURCHASE DETAILS */
                $data['purchaseData']['minimumStockQuantity'] = (float)$row[26] ?? 0;
                $data['purchaseData']['maximumStockQuantity'] = (float)$row[27] ?? 0;
                $data['purchaseData']['minimumOrderQuantity'] = (float)$row[28] ?? 0;
                $data['purchaseData']['maximumOrderQuantity'] = (float)$row[29] ?? 0;
                $data['purchaseData']['leadTime'] = $row[30] ?? null;
                $data['purchaseData']['reorderQuality'] = $row[31] ?? null;
                $data['purchaseData']['class'] = in_array($row[32], AlphabetClassEnum::getKeys()) ? AlphabetClassEnum::getValue($row[32]) : null;
                $data['purchaseData']['grnRequired'] = in_array($row[33], YesNoEnum::getKeys()) ? YesNoEnum::getValue($row[33]) : null;
                $data['purchaseData']['materialProvidedBy'] = in_array($row[34], MaterialProvidedByEnum::getKeys()) ? MaterialProvidedByEnum::getValue($row[34]) : null;
                $data['purchaseData']['allowManualTransaction'] = in_array($row[35], YesNoEnum::getKeys()) ? YesNoEnum::getValue($row[35]) : null;
                $data['purchaseData']['purchaseOfficer'] = getUserIdByEmail($row[36]) ?? null;
                $data['purchaseData']['toleranceMinus'] = (float)$row[37] ?? 0;
                $data['purchaseData']['toleranceMinusValue'] = (float)$row[38] ?? 0;
                $data['purchaseData']['tolerancePlus'] = (float)$row[39] ?? 0;
                $data['purchaseData']['tolerancePlusValue'] = (float)$row[40] ?? 0;
                $data['purchaseData']['isPurchaseData'] = true;
                /* GENERAL DETAILS */
                $data['generalData']['isGeneralData'] = true;
                $data['generalData']['location'] = $row[41] ?? null;
                $data['generalData']['binNumber'] = $row[42] ?? null;
                $data['generalData']['weight'] = $row[43] ?? null;
                $data['generalData']['selfLifeDays'] = $row[44] ?? null;
                $data['generalData']['warrantyPeriod'] = $row[45] ?? null;
                $data['generalData']['testReportRequire'] = in_array($row[46], YesNoEnum::getKeys()) ? YesNoEnum::getValue($row[46]) : null;
                $data['generalData']['moduleNumber'] = $row[47] ?? null;
                /* HSN DETAILS */
                $data['hsnSacDetails']['ishsnSacDetails'] = true;
                $data['hsnSacDetails']['hsnSac'] = in_array($row[48], YesNoEnum::getKeys()) ? YesNoEnum::getValue($row[48]) : null;
                if (getHsnSacDetailsByNumber($row[49])){
                    $hsnDetails = getHsnSacDetailsByNumber($row[49]);
                    $hsnOption = [
                        'label' => $hsnDetails->codeDescription .' ('.$hsnDetails->codeNo.')',
                        'value' => $hsnDetails->_id,
                        'codeNo' => $hsnDetails->codeNo,
                    ];
                }
                $data['hsnSacDetails']['hsnSacDescription'] = $hsnOption ?? null;
                $data['hsnSacDetails']['hsnSacNo'] = $hsnOption['codeNo'] ?? null;
                ItemMaster::saveData($data);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
