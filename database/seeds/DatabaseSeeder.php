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
        //factory(\App\User::class, 10)->create();
        factory(\App\Models\Radio::class, 10)->create()->each(function(\App\Models\Radio $radio) {
            $user = factory(\App\User::class)->create();
            $radio->users()->attach($user->id);
        });
        factory(\App\Models\Content::class, 80)->create();
        /** @var \App\User $user */
        $user = factory(\App\User::class)->create();
        $admin = new \App\Models\Roles\RoleAdmin;
        $admin->user_id = $user->id;
        $admin->save();
    }
}
