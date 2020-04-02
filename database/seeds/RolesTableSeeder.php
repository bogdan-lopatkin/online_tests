<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Администратор'
        ]);
        DB::table('roles')->insert([
            'name' => 'Учитель'
        ]);
        DB::table('roles')->insert([
            'name' => 'Ученик'
        ]);
    }
}
