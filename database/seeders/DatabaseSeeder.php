<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            Roles_Seed::class,
            Users_Seed::class,
            Categories_Seed::class,
            Posts_Seed::class,
            Comments_Seed::class,
            Answers_Seed::class,
        ]);
    }
}
