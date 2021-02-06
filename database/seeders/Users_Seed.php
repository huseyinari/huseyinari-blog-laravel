<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users_Seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->nameSurname = 'Hüseyin ARI';
        $user->email = 'hsynari1060@gmail.com';
        $user->roleId = 1;
        $user->isActive = 1;
        $user->password = Hash::make('ikizler42'); 
        $user->save();

        $user = new User();
        $user->nameSurname = 'Mustafa ARI';
        $user->email = 'mustafaari161@gmail.com';
        $user->roleId = 2;
        $user->isActive = 1;
        $user->password = Hash::make('7087231999'); 
        $user->save();
    }
}
