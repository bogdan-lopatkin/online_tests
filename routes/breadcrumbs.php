<?php
// Home
Breadcrumbs::for('home', function ($trail) {
$trail->push('Учетная запись', route('home'));
});

// Home > About
Breadcrumbs::for('user_settings', function ($trail) {
$trail->parent('home');
$trail->push('Настройки пользователя', route('user.index'));
});

// Home > Blog
Breadcrumbs::for('blog', function ($trail) {
$trail->parent('home');
$trail->push('Blog', route('blog'));
});

Breadcrumbs::for('admin', function ($trail) {
$trail->push('Админка', route('admin.dashboard.index'));
});

Breadcrumbs::for('categories', function ($trail) {
    $trail->parent('admin');
    $trail->push('Категории', route('admin.category.index'));
});

Breadcrumbs::for('category.edit', function ($trail, $category) {
    $trail->parent('categories');
    $trail->push('Редактирование' . " " . $category->name, route('admin.category.edit', $category->id));
});

Breadcrumbs::for('category.show', function ($trail, $category) {
    $trail->parent('categories');
    $trail->push($category->name, route('admin.category.show', $category->id));
});
//{{ Breadcrumbs::render('category.edit',$category) }}

Breadcrumbs::for('tests', function ($trail) {
    $trail->parent('admin');
    $trail->push('Тесты', route('admin.test.index'));
});

Breadcrumbs::for('tests.edit', function ($trail, $test) {
    $trail->parent('tests');
    $trail->push('Редактирование' . " " . $test->name, route('admin.test.edit', $test->id));
});

Breadcrumbs::for('tests.show', function ($trail, $test) {
    $trail->parent('tests');
    $trail->push($test->name, route('admin.test.show', $test->id));
});

/////////////////////


Breadcrumbs::for('questions', function ($trail) {
    $trail->parent('admin');
    $trail->push('Вопросы', route('admin.question.index'));
});

Breadcrumbs::for('question.edit', function ($trail, $question) {
    $trail->parent('questions');
    $trail->push('Редактирование' . " " . strip_tags($question->question_body), route('admin.question.edit', $question->id));
});

Breadcrumbs::for('question.show', function ($trail, $question) {
    $trail->parent('questions');
    $trail->push(strip_tags($question->question_body), route('admin.question.show', $question->id));
});

//////////////////////


Breadcrumbs::for('answers.edit', function ($trail, $answer) {
    $trail->parent('question.show', \App\Models\Question::find($answer->question_id));
    $trail->push('Редактирование' . " " . strip_tags($answer->answer_body), route('admin.answer.edit', $answer->id));
});

Breadcrumbs::for('answers.add', function ($trail, $id) {
    $trail->parent('question.show',\App\Models\Question::find($id));
    $trail->push("Добавление нового ответа", route('admin.answer.store'));
});

Breadcrumbs::for('categories.add', function ($trail) {
    $trail->parent('categories');
    $trail->push("Добавление новогой категории", route('admin.answer.store'));
});
Breadcrumbs::for('question.add', function ($trail) {
    $trail->parent('questions');
    $trail->push("Добавление нового вопроса", route('admin.answer.store'));
});
Breadcrumbs::for('tests.add', function ($trail) {
    $trail->parent('tests');
    $trail->push("Добавление нового теста", route('admin.answer.store'));
});















// Editing




//Breadcrumbs::for('category.edit', function ($trail, $category) {
//    $trail->parent('admin', $category->name);
//    $trail->push('Редактирование' . " " . $category->name, route('admin.category.show', $category->id));
//});
//
//Breadcrumbs::for('category.edit', function ($trail, $category) {
//    $trail->parent('admin', $category->name);
//    $trail->push('Редактирование' . " " . $category->name, route('admin.category.show', $category->id));
//});
//
//Breadcrumbs::for('category.edit', function ($trail, $category) {
//    $trail->parent('admin', $category->name);
//    $trail->push('Редактирование' . " " . $category->name, route('admin.category.show', $category->id));
//});





// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
$trail->parent('admin', $post->category);
$trail->push($post->title, route('post', $post->id));
});
