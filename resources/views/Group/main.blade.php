@extends('layouts.app')
@section('content')
<div class="container">



    <div class="d-flex flex-column mb-5 align-items-center">

        <h2>Группа "{{ $group->name }}"</h2>
        <div>

        </div>
    </div>
    @if(auth()->user()->checkRole(2))
        <div class="row d-flex justify-content-center">
            <div class="col-3"><a class="btn btn-primary" href="{{ route('group.students.index') }}">Список учеников</a></div>
            <div class="col-3"><a class="btn btn-primary" href="{{ route('group.tests.index') }}">Ваши тесты</a></div>
            <div class="col-3"><a class="btn btn-primary" href="{{ route('group.homework.index') }}">Домашнее задание</a></div>
        </div>
        <div>
            <h4 class="text-center pt-5">Реферальная ссылка Вашей группы</h4>
            <input class="form-actions w-100 text-center" type="text" readonly value="{!! route('register','s=' . $group->ref_link) !!}">
        </div>
    @elseif(auth()->user()->checkRole(3) || auth()->user()->checkRole(1))
    <div class="d-flex flex-column align-items-center">
        <h2 class="pb-3">Домашнее задание</h2>
        <div class="mb-5 border border-dark w-100 p-5">{!! $group->daily_task ?? 'Ничего не задано' !!} </div>
        <h2 class="pb-3">Тесты</h2>
        <div class="table-responsive">
            <table id="example" class="table table-striped table-sm text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Сложность</th>
                    <th>Время на выполнение  </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach(auth()->user()->group->tests()->paginate(10) as $test)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->difficulty }}</td>
                        <td>{{ $test->max_time }}</td>
                        <td><a class="btn btn-primary" href="/tests/test/{{$test->id}}">Пройти</a> </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $group->tests()->paginate(10)->links() }}
        </div>
    </div>
</div>

    @endif
@endsection
