<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;
use App\Models\Master\ProcessMaster;
use App\Models\Master\TermsConditionGroupMaster;
use App\Models\ProductionPlanning\ProcessSheetMaster;
use Jenssegers\Mongodb\Relations\HasOne;

class ProcessSheetList extends BaseModel
{

    protected $collection = 'process_sheet_list';

    protected $fillable = [
        'processSheetId',
        'processItemId',
        'machineNo',
        'processId',
        'processDesc',
        'jigFixId',
        'jigFixNo',
        'specialTool',
        'inspectionLevel',
        'measuringInstId',
        'measuringInstDesc',
        'qcSamplePer',
        'processRate',
        'daysReq',
        'wtLossPer',
        'matWt',
        'burningLossPer',
        'scrapTolerancePer',
        'inspectionBy',
        'inspectionInst',
        'remark',
        'setupTimeInMinute',
        'processTimeInMinute',
        'userDetail',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
    protected $appends = ['process_details'];

    public function processSheetDetail()
    {
        return $this->hasOne(ProcessSheetMaster::class,'_id','processSheetId');
    }

    public function getProcessDetailsAttribute()
    {
        return $this->processSheetDetail()->first(['processSheetNo']);
    }

    /**
     * @return HasOne
     */
    public function processDetail()
    {
        return $this->hasOne(ProcessMaster::class, '_id','processId');
    }


}
