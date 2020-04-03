<?php

use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            'test_id' => 1,
            'points' => 10,
            'turn' => 0,
            'question_body' => '<div>Какой HTML <b>тег</b> можно использовать только один раз на странице?</div>',
        ]);
        DB::table('questions')->insert([
            'test_id' => 1,
            'points' => 10,
            'turn' => 0,
            'question_body' => '<div>Какой HTML <b>тег</b> не существует?</div>',
        ]);
        DB::table('questions')->insert([
            'test_id' => 1,
            'points' => 10,
            'turn' => 0,
            'question_body' => '<div>Какой HTML <b>тег</b> делает текст жирным?</div>',
        ]);

        factory(App\Models\Question::class, 250)->create();
    }
}
