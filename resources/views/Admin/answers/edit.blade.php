@extends('Admin.app')
@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        {{ Form::open(['method' => 'PUT', 'route' => ['admin.answer.update',$answer->id]]) }}
        <h2>Ответ</h2>
        {!! Form::hidden('answer', $answer->answer_body, ['class' => 'form-control', 'id' => 'description']) !!}
        <trix-editor input="description"></trix-editor>
        {{ Form::submit('Сохранить изменения',['class' => 'btn btn-success  btn-lg mt-4']) }}
        {{ Form::close() }}

    </main>
@endsection
