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
        DB::table('tests')->insert([
            'name' => 'Единственный рабочий тест',
            'description' => 'Рабочий тест',
            'category_id' => 1,
            'difficulty' => 5,
            'max_time' => 25,
            'questions' => 3,
            'max_points' => 30,
            'created_by' => 0
        ]);
        factory(App\Models\Test::class, 150)->create();
    }
}
