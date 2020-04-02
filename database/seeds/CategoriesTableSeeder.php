<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'BackEnd'
        ]);
        DB::table('categories')->insert([
            'name' => 'FrontEnd'
        ]);
        DB::table('categories')->insert([
            'name' => 'Design'
        ]);
        DB::table('categories')->insert([
            'name' => 'SEO'
        ]);
    }
}
