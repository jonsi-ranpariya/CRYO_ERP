<?php

namespace App\Models\Partymaster;

use App\Models\BaseModel;

class DeliveryAddress extends BaseModel
{
    protected $collection = 'party_delivery_address';
    protected $fillable = [
        'partyId',
        'companyId',
        'addedFrom',
        'country',
        'state',
        'city',
        'pinCode',
        'address',
        'phoneNo',
        'phoneNoCode',
        'faxNo',
        'emailId',
        'website',
        'vatNo',
        'cstNo',
        'gstin',
    ];
    protected $hidden = ['created_at','updated_at'];
}
