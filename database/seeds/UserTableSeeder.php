<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => Hash::make('1234'),
            'role_id' => '3',
            'banned' => '0',
        ]);

        DB::table('users')->insert([
            'name' => 'banned_user',
            'email' => 'banned@gmail.com',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => Hash::make('1234'),
            'role_id' => '3',
            'banned' => '1',
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => Hash::make('1234'),
            'role_id' => '1',
            'banned' => '1',
        ]);
    }
}
