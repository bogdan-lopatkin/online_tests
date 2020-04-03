@extends('Admin.app')
@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        {{ Form::open(['method' => 'POST', 'route' => ['admin.answer.store']]) }}
        <h2>Ответ</h2>
        {!! Form::hidden('answer_body',null, ['class' => 'form-control', 'id' => 'description']) !!}
        {!! Form::hidden('question_id',$id, ['class' => 'form-control', 'id' => 'question_id']) !!}
        <trix-editor input="description"></trix-editor>
        {{ Form::submit('Отправить',['class' => 'btn btn-success  btn-lg mt-4']) }}
        {{ Form::close() }}

    </main>

@endsection
