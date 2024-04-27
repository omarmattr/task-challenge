<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userObj = new User();
        $userObj->name = 'User Omar';
        $userObj->email = 'omar@gmail.com';
        $userObj->password = Hash::make('123456');
        $userObj->type = 0;
        $userObj->save();
        
        $userObj = new User();
        $userObj->name = 'User Nour';
        $userObj->email = 'Nour@gmail.com';
        $userObj->password = Hash::make('123456');
        $userObj->type = 0;
        $userObj->save();

        $adminObj = new User();
        $adminObj->name = 'Admin Omar';
        $adminObj->email = 'adminomari@gmail.com';
        $adminObj->password = Hash::make('123456');
        $adminObj->type = 1;
        $adminObj->save();

        $superAdminObj = new User();
        $superAdminObj->name = 'admin Nour';
        $superAdminObj->email = 'superAdminNour@gmail.com';
        $superAdminObj->password = Hash::make('123456789');
        $superAdminObj->type = 2;
        $superAdminObj->save();

    }
}
