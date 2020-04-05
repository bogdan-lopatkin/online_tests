@extends('Admin.app')
@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        {{ Form::open(['method' => 'PUT', 'route' => ['admin.user.update',$user->id]]) }}
        <h2>Логин</h2>
        {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
        <h2>Почта</h2>
        {!! Form::text('email',$user->email,['class' => 'form-control','min' => '5']) !!}
        <h2>Роль</h2>
        {!! Form::select('role',$roles, 3,['class' => 'form-control']) !!}
        <h2>Забанен?</h2>
        {!! Form::select('banned',[0 => 'Нет',1 => 'Да'], $user->banned,['class' => 'form-control']) !!}
        {{ Form::submit('Сохранить изменения',['class' => 'btn btn-success btn-lg mt-4']) }}
        {{ Form::close() }}

    </main>


@endsection
