@extends('layouts.app')
@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        {{ Form::open(['method' => 'PUT', 'route' => ['admin.test.update',$test->id]]) }}
        <h2>Название теста</h2>
        {!! Form::text('name', $test->name, ['class' => 'form-control']) !!}
        <h2>Категория теста</h2>
        {!! Form::hidden('category_id','teacher_test') !!}
        {!! Form::hidden('description', $test->description, ['class' => 'form-control', 'id' => 'emailTemplate']) !!}
        <h2>Описание теста</h2>
        <trix-editor input="emailTemplate"></trix-editor>
        <h2>Время на выполнение</h2>
        {!! Form::number('max_time',$test->max_time, ['class' => '','min' => '5']) !!} минут
        <h2>Сложность</h2>
        {!! Form::select('difficulty',
                ['1' => 'Начинающий','2' => 'Ученик', '3' => 'Знаток','4' => 'Профессионал','5' => 'Эксперт'],
                $test->difficulty, ['class' => 'form-control','min' => '5']) !!}
        {{ Form::submit('Сохранить изменения',['class' => 'btn btn-success btn-lg mt-4']) }}
        {{ Form::close() }}

    </main>





@endsection
