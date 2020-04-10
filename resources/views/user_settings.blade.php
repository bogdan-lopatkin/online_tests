@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center align-items-center">

        @teacher

          <h2 class="text-center">Ваша группа - {{ auth()->user()->group->name }}</h2>
        {{ Form::open(['method' => 'POST', 'route' => ['group.update'], 'class' => 'd-flex justify-content-center']) }}
        {!! Form::hidden('id',auth()->user()->group->id) !!}
        {!! Form::text('group_name',auth()->user()->group->name) !!}
        {!! Form::submit('Переименовать группу') !!}
        {!! Form::close() !!}
        @endteacher

        <h2 class="text-center pt-5">Ваш аккаунт</h2>
        {{ Form::open(['method' => 'PUT', 'route' => ['user.update',auth()->user()->id], 'class' => 'd-flex flex-column  align-items-start']) }}
        <div class="d-flex flex-column">
            <h4 class="pr-5">Логин</h4>
            {!! Form::text('name',auth()->user()->name) !!}
        </div>
        <div class="d-flex flex-column">
            <h4 class="pr-5">Изменить пароль</h4>
            {!! Form::input('password', 'new_password', null, ['placeholder' => 'Новый пароль']) !!}
            {!! Form::input('password', 'password_confirm', null,['placeholder' => 'Подтвердите новый пароль'] ) !!}
        </div>
        <div class="d-flex flex-column">
            <h4 class="pr-5">Введите текущий пароль что-бы внести изменения</h4>
            {!! Form::text('confirm_password',null) !!}
        </div>




        {!! Form::submit('Именить аккаунт') !!}
        {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
