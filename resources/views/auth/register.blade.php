@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Регистрация </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        @if($group)
                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                        @endif
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Имя</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputState" class="col-md-4 col-form-label text-md-right"> Выберите свою роль </label>

                            <div class="col-md-6">
                                <select id="inputState" name="role_id" class="form-control">
                                    @if(!$group)
                                        @foreach($roles as $role)
                                            @if($role->id != 1)
                                                <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value="{{ $roles[2]->id }}" selected>{{ $roles[2]->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        @if($group)
                            <div id="group_name" class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Название группы</label>
                                <div class="col-md-6">
                                    <input disabled id="group_name-input" type="text" class="form-control" value="{{ $group->name }}" name="group_name">
                                </div>
                            </div>
                        @else
                        <div id="group_name" style="display: none" class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Название группы</label>
                            <div class="col-md-6">
                                <input id="group_name-input" type="text" class="form-control @error('group_name') is-invalid @enderror"
                                       name="group_name">
                                @error('group_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтвержение пароля</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Зарегистрироваться
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
   @endsection

@section('page-js-links')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
@endsection


@section('page-js-script')
    <script>
        $(document).ready(function () {
            $("#inputState").change(function() {
                var val = $(this).val();
                console.log(val);
                if(val == 2) {
                    $("#group_name").show();
                }
                else {
                    $("#group_name").hide();
                    $("#group_name-input").val(null);
                }
            });
        });
    </script>
@endsection
