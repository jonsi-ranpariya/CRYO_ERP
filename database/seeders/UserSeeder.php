<?php

namespace Database\Seeders;

use App\Enums\UserTypeEnums;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Psy\Util\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'Teacode',
            'last_name' => 'Admin',
            'email' => 'info@teacodes.com',
            'ability' => '[{"action":"manage","subject":"all"}]',
            'avatar' => null,
            'role' => UserTypeEnums::SUPER,
            'username' => UserTypeEnums::SUPER,
            'password' => Hash::make('123456'),
        ]);
    }
}
