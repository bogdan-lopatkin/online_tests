@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Подтвердите свою почту</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Свежая ссылка-подтверждения была отправлена на Вашу почту
                        </div>
                    @endif

                        Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.
                        Если Вы не получили письмо,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Нажмите сюда что бы запросить еще одно</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
