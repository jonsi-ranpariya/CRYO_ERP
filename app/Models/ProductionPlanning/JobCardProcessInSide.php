<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;
use App\Models\Inventory\Transaction;
use App\Models\Master\MachineMaster;
use App\Models\Master\OperatorMaster    ;
use Jenssegers\Mongodb\Relations\MorphMany;

class JobCardProcessInSide extends BaseModel
{
    protected $collection = 'job_card_process_inside';
    protected $fillable = [
        'jobId',
        'InSideOperatorName',
        'selectBatch',
        'InSideOperatorDate',
        'InSideTotalAvlQty',
        'InSideIssueQty',
        'inSideAcceptQty',
        'inSideRejectQty',
        'inSideNoOfHr',
        'inSideRwQty',
        'inSideProcessCost',
        'inSideRemark',
        'InSideMachineNo',
        'standardSetTime',
        'standardTotalSetTime',
        'actualSetTime',
        'differenceSetTime',
        'standardProcessTime',
        'standardTotalProcessTime',
        'actualProcessTime',
        'differenceProcessTime',
        'standardTotalTime',
        'standardTotalTolTime',
        'actualTotalTime',
        'differenceTotalTime',
        'standardProcess',
        'accessQty',
    ];
    protected $appends = ['operator_name','machine_number'];

    public function operatorDetails()
    {
        return $this->hasOne(OperatorMaster::class,'_id','InSideOperatorName');
    }

    public function getOperatorNameAttribute()
    {
        return $this->operatorDetails()->first(['operatorName']);
    }

    public function machineDetails()
    {
        return $this->hasOne(MachineMaster::class,'_id','InSideMachineNo');
    }

    public function getMachineNumberAttribute()
    {
        return $this->machineDetails()->first(['machineName']);
    }
}
