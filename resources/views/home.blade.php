@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        @if(auth()->user()->checkRole('teacher'))
            lll
        @endif

        @teacher
           Ваша группа - {{ auth()->user()->group->name }}
            <a href="{{ route('group.index') }}">Задать домашнее задание</a>
            <a href="{{ route('group.index') }}">Создать тест</a>
            <a href="{{ route('group.index') }}">Создать статью</a>
            <a href="{{ route('group.index') }}">Просмотреть учеников</a>
        @endteacher

        @if(auth()->user()->group_id)
            <div class="w-100 pb-5">
                <h2 class="text-center pb-2"> Вы состоите в группе  {{ auth()->user()->group->name }} </h2>
                <a href="{{ route('group.index') }}" class="btn w-25 btn-primary  ">Перейти к группе</a>
            </div>
            @endif
        <h2>Ваши тесты</h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <form method="get" action="{{ route('admin.test.index') }}">
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Сложность</th>
                        <th>Баллов набрано</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                </form>
                </thead>

                <tbody>
                @foreach($tests as $test)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $test->name }}</td>
                        <td>{!!$test->category->name ?? '<b>Ошибка</b>'!!}</td>
                        <td> <div class=" quizz-rating__stars star_{{ $test->difficulty }}">
                                <i class="fa fa-star" data-rating="1"></i>
                                <i class="fa fa-star" data-rating="2"></i>
                                <i class="fa fa-star" data-rating="3"></i>
                                <i class="fa fa-star" data-rating="4"></i>
                                <i class="fa fa-star" data-rating="5"></i>
                            </div>
                        </td>
                        <td><b>{{ $test->pivot->mark }}</b> / {{ $test->max_points }}</td>
                        <td>
                            @if($test->pivot->status === 'completed')
                                Завершен
                        </td>
                        <td></td>
                    @elseif($test->pivot->status === 'started')
                                Начат
                            <td><a class="btn btn-primary" href="/tests/test/{{$test->id}}">Продолжить прохождение</a></td>

                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
