@extends('Admin.app')
@section('content')
    @trixassets
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        {{ Form::open(['method' => 'PUT', 'route' => ['admin.question.update',$question->id]]) }}
        <h2>Вопрос</h2>
        {!! Form::hidden('question', $question->question_body, ['class' => 'form-control', 'id' => 'description']) !!}
        <trix-editor input="description"></trix-editor>
        <h2>Принадлежит к тесту</h2>
        {!! Form::select('test_id',$tests, $question->test_id, ['class' => 'form-control']) !!}
        <h2>Баллов за ответ</h2>
        {!! Form::number('points',$question->points, ['class' => '','min' => '5']) !!} баллов
        <br>  <!--fixme Убрать это -->
        {{ Form::submit('Сохранить изменения',['class' => 'btn btn-success  btn-lg mt-4']) }}
        {{ Form::close() }}

    </main>





@endsection
