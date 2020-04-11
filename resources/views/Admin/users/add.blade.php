@extends('Admin.app')
@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <h1>Добавить нового пользователя</h1>
        {{ Form::open(['method' => 'POST', 'route' => ['admin.user.store']]) }}
        <h2>Логин</h2>
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        <h2>Почта</h2>
        {!! Form::text('email',null,['class' => 'form-control','min' => '5']) !!}
                <label class="mt-1">
                    {!! Form::checkbox('confirm_email',1, 0 ,['class' => '']) !!}
                   Автоматически подтвердить почту
                </label>
        </div>
        <h2>Пароль</h2>
        {!! Form::input('password','password',null,['class' => 'form-control','min' => '5']) !!}
        <h2>Роли</h2>
        <div class="d-flex flex-column">
            @foreach($roles as $role)
                <label>
                    {!! Form::checkbox('role[]',$role->id, 0 ,['class' => '']) !!}
                    {{ $role->name}}
                </label>
            @endforeach
        </div>
        <h2>Забанен?</h2>
        {!! Form::select('banned',[0 => 'Нет',1 => 'Да'], 0,['class' => 'form-control']) !!}
        {{ Form::submit('Сохранить изменения',['class' => 'btn btn-success btn-lg mt-4']) }}
        {{ Form::close() }}
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

    </main>


@endsection
