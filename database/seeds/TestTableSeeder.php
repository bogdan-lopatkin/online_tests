<?php

use Illuminate\Database\Seeder;
use App\Models;
class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Test::class, 150)->create();
    }
}
