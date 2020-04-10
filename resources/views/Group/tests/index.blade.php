@extends('layouts.app') @section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

        <h2>Тесты группы "{{ $group->name }}" <a class="btn btn-dark d-inline" href="{{ route('group.tests.create') }}">Добавить</a></h2>
        <div class="table-responsive">
            <table id="example" class="table table-striped table-sm text-center">
                <thead>
                <form method="get" action="{{ route('group.tests.index') }}">
                    @if( Request::get("param") != 'desc' )
                        <input type="hidden" name="param" value="desc">
                    @else
                        <input type="hidden" name="param" value="asc">
                    @endif
                    <tr>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'id'  }}">#</button></th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'name' }}">Название</button></th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'questions' }}">Количество вопросов</button> </th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'difficulty' }}">Сложность</button></th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'max_time' }}">Время на выполнение</button>  </th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'created_at' }}">Создан</button></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </form>
                </thead>

                <tbody>
                @foreach($group->tests()->paginate(10) as $test)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->questions }}</td>
                        <td>{{ $test->difficulty }}</td>
                        <td>{{ $test->max_time }}</td>
                        <td>{{ $test->created_at }}</td>
                        <td><a class="btn btn-outline-primary" href="{{ route('group.tests.show',$test->id) }}">Подробнее</a> </td>
                        <td><a class="btn btn-outline-info" href="{{ route('group.tests.edit',$test->id) }}">Редактировать</a></td>
                        <td>
                            {{ Form::open(['method' => 'DELETE', 'route' => ['group.tests.destroy', $test->id]]) }}
                            <button class="btn btn-outline-danger" onclick="return confirm('Вы уверены ?')">Удалить</button>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $group->tests()->paginate(10)->links() }}
        </div>
    </main>

@endsection
