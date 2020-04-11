@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center align-items-center">

        @teacher

          <h2 class="text-center">Ваша группа - {{ auth()->user()->group->name }}</h2>
        {{ Form::open(['method' => 'POST', 'route' => ['group.update'], 'class' => 'd-flex justify-content-center']) }}
        {!! Form::hidden('id',auth()->user()->group->id) !!}
        {!! Form::text('group_name',auth()->user()->group->name,['class' => 'form-control']) !!}
        {!! Form::submit('Переименовать группу') !!}
        {!! Form::close() !!}
        @endteacher

        <h2 class="text-center pt-5">Ваш аккаунт</h2>

        <div style="width: fit-content;">

        <h4 class="pt-5">Аватар</h4>
            {{ Form::open(['method' => 'POST', 'route' => ['avatar.upload'],'id' => 'photo_form', 'class' => 'd-flex justify-content-center',  'files' => true]) }}
            <img class="avatar_change"  src="{{ asset(auth()->user()->avatar_url) }}">
            {!! Form::file('img',['id' => 'select_button' , 'style' => 'visibility : hidden','accept' => "image/x-png,image/gif,image/jpeg" ]) !!}
            {!! Form::close() !!}


        </div>

        {{ Form::open(['method' => 'PUT', 'route' => ['user.update',auth()->user()->id], 'class' => 'd-flex flex-column  align-items-start']) }}
        <div class="d-flex flex-column">
            <h4 class=" pr-5">Логин</h4>
            {!! Form::text('name',auth()->user()->name,['class' => 'form-control']) !!}
        </div>
        <div class="d-flex flex-column">
            <h4 class="pt-3 pr-5">E-mail</h4>
            {!! Form::text('email',auth()->user()->email,['class' => 'form-control']) !!}
        </div>
        <div class="d-flex flex-column">
            <h4 class="pt-3 pr-5">Изменить пароль</h4>
            <input type="password" name="password" class="form-control" placeholder="Новый пароль">
            <input type="password" name="password_confirmation" class="mt-1 form-control" placeholder="Подтвердите новый пароль">
{{--            {!! Form::input('password', 'password', null, ['placeholder' => 'Подтвердите новый пароль','class' => 'form-control']) !!}--}}
{{--            {!! Form::input('password', 'password_confirmation ', null,['placeholder' => 'Подтвердите новый пароль','class' => 'form-control'] ) !!}--}}
        </div>
        <div class="d-flex flex-column">
            <h4 class="pt-3 pr-5">Введите текущий пароль что-бы внести изменения</h4>
            <input type="password" name="current_password" class="form-control" placeholder="Введите свой текущий пароль">
{{--            {!! Form::input('password','current_password',null,['placeholder' => 'Введите свой текущий пароль','class' => 'form-control']) !!}--}}
        </div>
        {!! Form::submit('Именить аккаунт', ['class' => 'btn-lg btn-success mt-3']) !!}
        {!! Form::close() !!}
        </div>
    @if ($errors->any())
        <div class="">
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    </div>


@endsection

@section('page-js-links')
    <script>
$(document).ready(function (e) {

    $('.avatar_change').on('click',(function(e) {
        $("#select_button").click();
}));
    $('#select_button').on('change ',(function(e) {
        $("#photo_form").submit();
    }));
});

</script>
@endsection
