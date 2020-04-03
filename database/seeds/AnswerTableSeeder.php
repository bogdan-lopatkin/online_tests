<?php

use Illuminate\Database\Seeder;

class AnswerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers')->insert([
            'question_id' => '1',
            'answer_body' => '<div>h1</div>',
            'is_correct' => 1,
        ]);
        DB::table('answers')->insert([
            'question_id' => '1',
            'answer_body' => '<div>span</div>',
            'is_correct' => 0,
        ]);
        DB::table('answers')->insert([
            'question_id' => '1',
            'answer_body' => '<div>link</div>',
            'is_correct' => 0,
        ]);
        DB::table('answers')->insert([
            'question_id' => '1',
            'answer_body' => '<div>meta</div>',
            'is_correct' => 0,
        ]);


        DB::table('answers')->insert([
            'question_id' => '2',
            'answer_body' => '<div>flex</div>',
            'is_correct' => 0,
        ]);
        DB::table('answers')->insert([
            'question_id' => '2',
            'answer_body' => '<div>i</div>',
            'is_correct' => 0,
        ]);
        DB::table('answers')->insert([
            'question_id' => '2',
            'answer_body' => '<div>span</div>',
            'is_correct' => 0,
        ]);
        DB::table('answers')->insert([
            'question_id' => '2',
            'answer_body' => '<div>render</div>',
            'is_correct' => 1,
        ]);


        DB::table('answers')->insert([
            'question_id' => '3',
            'answer_body' => '<div>i</div>',
            'is_correct' => 0,
        ]);
        DB::table('answers')->insert([
            'question_id' => '3',
            'answer_body' => '<div>b</div>',
            'is_correct' => 1,
        ]);
        DB::table('answers')->insert([
            'question_id' => '3',
            'answer_body' => '<div>p</div>',
            'is_correct' => 0,
        ]);
        DB::table('answers')->insert([
            'question_id' => '3',
            'answer_body' => '<div>div</div>',
            'is_correct' => 0,
        ]);

    }
}
