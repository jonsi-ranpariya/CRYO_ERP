<?php

namespace App\Models\Administration;

use App\Models\BaseModel;
use App\Models\Master\CityMaster;
use App\Models\Master\CountryMaster;
use App\Models\Master\CurrencyMaster;
use App\Models\Master\StateMaster;

class Company extends BaseModel
{
    protected $collection = 'company';

    protected $fillable = [
        'companyCode',
        'companyName',
        'companyType',
        'address',
        'city',
        'state',
        'country',
        'pinCode',
        'currency',
        'phoneNumber',
        'phoneNumberCode',
        'faxNumber',
        'emailId',
        'website',
        'financialYearFrom',
        'financialYearTo',
        'gstNumber',
        'panNumber',
        'nameOfBeneficiary',
        'bankName',
        'branchName',
        'accountNumber',
        'ifsCode',
        'micrCode',
        'ewayEmail',
        'ewayUsername',
        'ewayPassword',
        'ewayClientId',
        'ewayClientSecret',
        'ewayGstin',
    ];

    protected $appends = [
        'city_data',
        'state_data',
        'country_data',
        'currency_data'
    ];

    public function cityDetails()
    {
        return $this->hasOne(CityMaster::class,'_id','city');
    }

    public function getCityDataAttribute()
    {
        return $this->cityDetails()->first(['city']);
    }

    public function stateDetails()
    {
        return $this->hasOne(StateMaster::class,'_id','state');
    }

    public function getStateDataAttribute()
    {
        return $this->stateDetails()->first(['state','stateCode']);
    }

    public function countryDetails()
    {
        return $this->hasOne(CountryMaster::class,'_id','country');
    }

    public function getCountryDataAttribute()
    {
        return $this->countryDetails()->first(['country']);
    }

    public function currencyDetails()
    {
        return $this->hasOne(CurrencyMaster::class,'_id','currency');
    }

    public function getCurrencyDataAttribute()
    {
        return $this->currencyDetails()->first(['currencyCode']);
    }
}
