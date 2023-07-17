<?php

namespace App\Models\Settings;

use App\Models\BaseModel;

class SettingsMaster extends BaseModel
{
    protected $collection = 'common_settings';
    protected $fillable = [
        'settingKey',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
