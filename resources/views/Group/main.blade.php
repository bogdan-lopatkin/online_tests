@extends('layouts.app')
@section('content')
<div class="container">



    <div class="d-flex flex-column mb-5 align-items-center">

        <h2>Группа "{{ $group->name }}"</h2>
        <div>

        </div>
    </div>
    <div class="row">

        <div class="col-3"><a class="btn btn-primary" href="{{ route('group.students.index') }}">Список учеников</a></div>
        <div class="col-3"><a class="btn btn-primary" href="{{ route('group.tests.index') }}">Ваши тесты</a></div>
        <div class="col-3"><a class="btn btn-primary" href="{{ route('group.articles') }}">Ваши статьи</a></div>
        <div class="col-3"><a class="btn btn-primary" href="{{ route('group.homework.index') }}">Домашнее задание</a></div>

    </div>




    {{--        <div class="col-6">--}}
{{--            <h2>Тесты группы</h2>--}}
{{--            <div class="table-responsive">--}}
{{--                <table id="example" class="table table-striped table-sm">--}}
{{--                    <thead>--}}
{{--                    <form method="get" action="{{ route('admin.test.index') }}">--}}
{{--                        @if( Request::get("param") != 'desc' )--}}
{{--                            <input type="hidden" name="param" value="desc">--}}
{{--                        @else--}}
{{--                            <input type="hidden" name="param" value="asc">--}}
{{--                        @endif--}}
{{--                        <tr>--}}
{{--                            <th>#</th>--}}
{{--                            <th>Название</th>--}}
{{--                            <th>Вопросов</th>--}}
{{--                            <th>Сложность</th>--}}
{{--                            <th>Время на выполнение</th>--}}
{{--                        </tr>--}}
{{--                    </form>--}}
{{--                    </thead>--}}

{{--                    <tbody>--}}
{{--                    @foreach($group->tests()->paginate(10) as $test)--}}
{{--                        <tr>--}}
{{--                            <td>{{ $test->id }}</td>--}}
{{--                            <td>{{ $test->name }}</td>--}}
{{--                            <td>{{ $test->questions }}</td>--}}
{{--                            <td>{{ $test->difficulty }}</td>--}}
{{--                            <td>{{ $test->max_time }}</td>--}}
{{--                            <td><a class="btn btn-outline-primary" href="{{ route('admin.test.show',$test->id) }}">Подробнее</a> </td>--}}
{{--                            <td><a class="btn btn-outline-info" href="{{ route('admin.test.edit',$test->id) }}">Редактировать</a></td>--}}
{{--                            <td>--}}
{{--                                {{ Form::open(['method' => 'DELETE', 'route' => ['admin.test.destroy', $test->id]]) }}--}}
{{--                                <button class="btn btn-outline-danger" onclick="return confirm('Вы уверены ?')">Удалить</button>--}}
{{--                                {{ Form::close() }}--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--                {{ $group->tests()->paginate(10)->links() }}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-6">--}}
{{--            <h2>Статьи группы</h2>--}}
{{--            Когда-то сделаю--}}
{{--        </div>--}}
{{--    </div>--}}

</div>
@endsection
