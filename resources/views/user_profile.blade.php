@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center align-items-center">
        <h2 class="text-center pt-5">Профиль {{ $user->name }}</h2>

        <div class="d-flex">
            <img class="avatar_change"  src="{{ Storage::url($user->avatar_url) }}">
            <div class="pt-4 pl-5">
                <h4>Логин - {{ $user->name }}</h4>
                <h4>Email - {{ $user->email }}</h4>
                <h4>Зарегистрирован {{ $user->humanDate($user->created_at) }}</h4>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-6">
                    <h2 class="text-center">Тесты пользователя</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Название</th>
                                    <th>Категория</th>
                                    <th>Сложность</th>
                                    <th>Баллов набрано</th>
                                    <th>Статус</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($user->tests as $test)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-break">{{ $test->name }}</td>
                                    <td>{!!$test->category->name ?? 'Учительский тест'!!}</td>
                                    <td> <div class="d-flex quizz-rating__stars star_{{ $test->difficulty }}">
                                            <i class="fa fa-star" ></i>
                                            <i class="fa fa-star" ></i>
                                            <i class="fa fa-star" ></i>
                                            <i class="fa fa-star" ></i>
                                            <i class="fa fa-star" ></i>
                                        </div>
                                    </td>
                                    <td><b>{{ $test->pivot->mark }}</b> / {{ $test->max_points }}</td>
                                    <td>
                                        @if($test->pivot->status === 'completed')
                                            Завершен
                                    </td>
                                    @elseif($test->pivot->status === 'started')
                                        Начат
                                    </td>
                                    @endif
                                    @empty
                                        <h3 class="pb-3 text-danger">Пользователь пока не проходил тесты</h3>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6">
                    <h2 class="text-center">Темы пользователя</h2>
                    @forelse($user->threads as $thread)
                        <div class="justify-content-start mt-5 d-flex align-items-center">
                            <span><img style="max-width: 70px" class="mr-5" src="{{ Storage::url($thread->owner->avatar_url) }}"></span>
                            <div class="d-flex flex-column">
                                <h3><a class="" style="color:black" href="{{ route('forum.thread.show',$thread->id) }}">{{ $thread->name }}</h3>
                                <div>
                                    <a class="text-uppercase font-weight-bold" style="font-size: 16px" href="#">{{ $thread->owner->name }}</a>
                                    <span style="color: gray">Создано {{ $thread->humanDate($thread->created_at) }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h3 class="pb-3 text-danger">Пользователь пока не создавал тем</h3>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

