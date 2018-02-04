<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\User::updateOrCreate([
            'email' => 'admin@admin.com'
        ],[
            'name' => 'Admin',
            'password' => bcrypt('password')
        ]);

    }
}
