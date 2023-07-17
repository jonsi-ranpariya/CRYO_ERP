<?php

namespace App\Actions\Bom;

use App\Models\Bom\BillOfMaterialVersion;
use App\Models\Bom\BomVersionItem;
use App\Models\Bom\BomVersionItemMap;
use App\Models\Bom\BomVersionProcess;
use Lorisleiva\Actions\Concerns\AsAction;

class BillOfMaterialVersionAction
{
    use AsAction;

    public function handle($data)
    {
        if (is_array($data)) {
            $data['bomNumber'] = generateCodes(new BillOfMaterialVersion(),'B00001','bomNumber','B');
            $data['bomVersion'] = $this->bomVersion();
            return BillOfMaterialVersion::saveData($data);
        } else {
            $data1['bomId'] = $data;
            $data1['bomNumber'] = generateCodes(new BillOfMaterialVersion(),'B00001','bomNumber','B');
            $data1['bomVersion'] = $this->bomVersion();
            $data1['bomDescription'] = 'Standard Bill Of Material';
            $data1['bomUnit'] = 1;
            $data1['bomActive'] = '1';
            return BillOfMaterialVersion::saveData($data1);
        }
    }

    public function bomVersion()
    {
        $count = BillOfMaterialVersion::query()->latest()->count();
        return $count === 0 ? 1 : $count + 1;
    }

    public function delete($id)
    {
        BillOfMaterialVersion::deleteData(['bomId' => $id]);
        BomVersionItem::deleteData(['bomId' => $id]);
        BomVersionProcess::deleteData(['bomId' => $id]);
    }

    public function deleteVersionData($id)
    {
        BillOfMaterialVersion::destroyData($id);
        BomVersionItem::deleteData(['versionId' => $id]);
        BomVersionProcess::deleteData(['versionId' => $id]);
    }
}
