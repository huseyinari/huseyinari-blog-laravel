<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class Roles_Seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->id = 1;
        $admin->roleName = 'Admin';
        $admin->save();

        $user = new Role();
        $user->id = 2;
        $user->roleName = 'User';
        $user->save();
    }
}
