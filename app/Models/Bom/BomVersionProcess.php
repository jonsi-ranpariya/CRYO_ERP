<?php

namespace App\Models\Bom;

use App\Models\BaseModel;
use App\Models\Master\ProcessMaster;

class BomVersionProcess extends BaseModel
{
    protected $collection = 'bill_of_material_process';

    protected $fillable = [
        'bomId',
        'versionId',
        'machineNumber',
        'progressId',
        'progressDescription',
        'jigFixNumber',
        'specialTool',
        'inspectionLevel',
        'measuringDeviceLabel',
        'measuringDevice',
        'qcSample',
        'processRate',
        'daysRequire',
        'wtLoss',
        'matWt',
        'burningLoss',
        'scrapTolerance',
        'inspectionBy',
        'inspectionInstruction',
        'remark',
        'processSheetNumber',
        'matIssueWt',
        'scrapQty',
        'scrapCode',
        'addedFrom',
        'updatedFrom',
    ];

    protected $appends = ['progress_details'];

    public function processDetails()
    {
        return $this->hasOne(ProcessMaster::class,'_id','progressDescription');
    }

    public function getProgressDetailsAttribute()
    {
        $data = $this->processDetails()->first(['processName']);
        return empty($data) ? null : $data->processName;
    }
}
