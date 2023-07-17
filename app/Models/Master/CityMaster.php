<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class CityMaster extends BaseModel
{
    protected $collection = 'city_masters';
    protected $fillable = [
        'city',
        'state',
        'country',
        'area',
        'addedFrom',
        'companyId',
    ];

    protected $appends = ['state_detail','country_detail'];

    public function stateData()
    {
        return $this->hasOne(StateMaster::class,'_id','state');
    }

    public function getStateDetailAttribute()
    {
        $state = $this->stateData()->first();
        if (empty($state)){
            return null;
        }

        $response['label'] = $state->state;
        $response['value'] = $state->_id;
        $response['code'] = $state->stateCode;
        return $response;
    }

    public function countryData()
    {
        return $this->hasOne(CountryMaster::class,'_id','country');
    }

    public function getCountryDetailAttribute()
    {
        $country = $this->countryData()->first();
        if (empty($country)){
            return null;
        }

        $response['label'] = $country->country;
        $response['value'] = $country->_id;
        return $response;
    }
}
