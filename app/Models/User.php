<?php

namespace App\Models;

use App\Casts\CapitalizeWordsCast;
use App\Traits\DatabaseTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Maklad\Permission\Traits\HasPermissions;
use Maklad\Permission\Traits\HasRoles;

class User extends Authenticate
{
    use HasApiTokens, HasFactory, Notifiable, DatabaseTrait, HasPermissions, HasRoles;

    protected $connection = 'mongodb';
    protected $collection = 'users';
    protected $primaryKey = '_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'ability',
        'avtar',
        'role',
        'username',
        'companyId',
        'addedFrom',
        'name',
        'code',
        'userGeneralDetails',
        'userContactDetails',
        'userStatutoryDetails',
        'userCheckListDetails'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'first_name' => CapitalizeWordsCast::class,
        'last_name' => CapitalizeWordsCast::class,
        'name' => CapitalizeWordsCast::class
    ];
}
