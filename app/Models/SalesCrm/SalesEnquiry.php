<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;
use App\Models\Master\CityMaster;
use App\Models\Master\CountryMaster;
use App\Models\Master\StateMaster;
use App\Models\Partymaster\ContactPerson;
use App\Models\Partymaster\PartyMaster;
use Jenssegers\Mongodb\Relations\HasMany;
use Jenssegers\Mongodb\Relations\HasOne;

class SalesEnquiry extends BaseModel
{
    protected $collection = 'sales_enquiry';
    protected $fillable = [
        'enquiryNo',
        'partyId',
        'customerId',
        'customerCode',
        'customerName',
        'customerAddress',
        'customerCity',
        'customerState',
        'customerCountry',
        'customerPinCode',
        'customerFaxNo',
        'customercountryCode',
        'customerMobileNo',
        'customerEmailId',
        'customerWebsite',
        'customerProject',
        'customerGstNo',
        'customerPanNo',
        'contactPersonName',
        'personCountryCode',
        'contactPersonMobileNo',
        'contactPersonEmailId',
        'kindAttn',
        'reference',
        'ourReference',
        'industryType',
        'enquiryStage',
        'enquiryDate',
        'referenceDate',
        'isReviewDate',
        'reviewDate',
        'dueDate',
        'branch',
        'enquiryBy',
        'enquiryStatus',
        'enquiryAssignTo',
        'enquiryAssignName',
        'enquiryFollowUpBy',
        'followByName',
        'salesFrom',
        'salesType',
        'itemDetails',
        'loginData',
        'confirmationData',
        'letterData',
        'addedFrom',
        'companyId',
    ];
    protected $hidden = ['updated_at'];
    protected $appends = ['city_details'];

    /**
     * @return HasMany
     */
    public function itemDetails(): HasMany
    {
        return $this->hasMany(SalesItemDetails::class,'salesIqID','_id');
    }

    /**
     * @return HasOne
     */
    public function city(): HasOne
    {
        return $this->hasOne(CityMaster::class,'_id','customerCity');
    }

    public function getCityDetailsAttribute()
    {
       return $this->city()->first(['city']);
    }

    /**
     * @return HasOne
     */
    public function state(): HasOne
    {
        return $this->hasOne(StateMaster::class,'_id','customerState');
    }

    /**
     * @return HasOne
     */
    public function country(): HasOne
    {
        return $this->hasOne(CountryMaster::class,'_id','customerCountry');
    }

    /**
     * @return HasOne
     */
    public function kindAttnDetails(): HasOne
    {
        return $this->hasOne(ContactPerson::class,'_id','kindAttn');
    }

    /**
     * @return HasOne
     */
    public function partyDetails(): HasOne
    {
        return $this->hasOne(PartyMaster::class, '_id', 'partyId')->with('currenyDetails');
    }
}
