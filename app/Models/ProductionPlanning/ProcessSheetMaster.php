<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;
use Jenssegers\Mongodb\Relations\HasMany;

class ProcessSheetMaster extends BaseModel
{

    protected $collection = 'process_sheet_master';

    protected $fillable = [
        'processSheetNo',
        'itemId',
        'itemCode',
        'itemDesc',
        'itemAddDesc',
        'itemDetailDesc',
        'itemDrawingNo',
        'itemDrawingRev',
        'scrapDetail',
        'loginDetail',
        'itemUom',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];

    public function itemDetails(): HasMany
    {
        return $this->hasMany(ProcessSheetList::class, 'processSheetId', '_id');
    }
}
