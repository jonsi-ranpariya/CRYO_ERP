<?php

namespace App\Models\Partymaster;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactPerson extends BaseModel
{
    use HasFactory;

    protected $collection = 'party_contact_person';
    protected $fillable = [
        'partyId',
        'personName',
        'designation',
        'department',
        'division',
        'phoneNo',
        'phoneNoCode',
        'mobileNo',
        'mobileNoCode',
        'email',
        'faxNo',
        'extNumber',
        'note',
        'active',
        'autoSms',
        'autoEmail',
    ];
}
