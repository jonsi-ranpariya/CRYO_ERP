<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Jenssegers\Mongodb\Relations\HasOne;

class TermsConditionTemplateItemMaster extends BaseModel
{

   protected $collection = 'terms_condition_template_item_master';
   protected $fillable = [
       'templateId',
       'tcGroup',
       'groupName',
       'tcDescription',
       'addedFrom',
       'updatedFrom',
       'created_at',
       'updated_at',
       'companyId',
   ];
    /**
     * @return HasOne
     */
    public function tcDetails()
    {
        return $this->hasOne(TermsConditionDetailsMaster::class, '_id','tcGroup');
    }


}
