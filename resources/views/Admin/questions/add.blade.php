@extends('Admin.app')
@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        {{ Breadcrumbs::render('question.add') }}
        {{ Form::open(['method' => 'POST', 'route' => ['admin.question.store']]) }}
        <h2>Вопрос</h2>
        {!! Form::hidden('description',null, ['class' => 'form-control', 'id' => 'description']) !!}
        <trix-editor input="description"></trix-editor>
        <h2>Принадлежит тесту</h2>
        {!! Form::select('test_id',$tests, 0, ['class' => 'form-control', 'id' => 'test_id']) !!}
        {{ Form::submit('Отправить',['class' => 'btn btn-success  btn-lg mt-4']) }}
        {{ Form::close() }}

    </main>

@endsection
