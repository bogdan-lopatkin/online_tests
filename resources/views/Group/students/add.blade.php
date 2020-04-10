@extends('layouts.app')
@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <h1>Добавить нового пользователя</h1>
        {{ Form::open(['method' => 'PUT', 'route' => ['admin.user.store']]) }}
        <h2>Логин</h2>
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        <h2>Почта</h2>
        {!! Form::text('email',null,['class' => 'form-control','min' => '5']) !!}
        <h2>Забанен?</h2>
        {!! Form::select('banned',[0 => 'Нет',1 => 'Да'], null,['class' => 'form-control']) !!}
        <h2>Роль</h2>
        {!! Form::select('role',$roles, 3,['class' => 'form-control']) !!}
        {{ Form::submit('Сохранить изменения',['class' => 'btn btn-success btn-lg mt-4']) }}
        {{ Form::close() }}

    </main>


@endsection
