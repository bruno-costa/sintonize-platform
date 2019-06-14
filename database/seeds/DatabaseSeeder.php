<?php

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
        factory(\App\Models\Radio::class, 10)->create();
        factory(\App\Models\Content::class, 80)->create();
        // $this->call(UsersTableSeeder::class);
    }
}
