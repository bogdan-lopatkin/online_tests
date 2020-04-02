@extends('Admin.app')
@section('content')

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <h2>Тесты в категории {{ $category->name }} <a class="btn btn-dark" href="{{ route('admin.test.create') }}">Добавить новый тест</a></h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <form method="get" action="{{ route('admin.test.index') }}">
                    @if( Request::get("param") != 'desc' )
                        <input type="hidden" name="param" value="desc">
                    @else
                        <input type="hidden" name="param" value="asc">
                    @endif
                    <tr>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'id'  }}">#</button></th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'name' }}">Название</button></th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'questions' }}">Количество вопросов</a> </th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'difficulty' }}">Сложность</button></th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'max_time' }}">Время на выполнение</a>  </th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'created_at' }}">Создан</button></th>
                    </tr>
                </form>
                </thead>

                <tbody>
                @foreach($category->tests()->paginate(5) as $test)
                    <tr>
                        <td>{{ $test->id }}</td>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->questions }}</td>
                        <td>{{ $test->difficulty }}</td>
                        <td>{{ $test->max_time }}</td>
                        <td>{{ $test->created_at }}</td>
                        <td><a class="btn btn-outline-primary" href="{{ route('admin.test.show',$test->id) }}">Подробнее</a> </td>
                        <td><a class="btn btn-outline-info" href="{{ route('admin.test.edit',$test->id) }}">Редактировать</a></td>
                        <td>
                            {{ Form::open(['method' => 'DELETE', 'route' => ['admin.test.destroy', $test->id]]) }}
                            <button class="btn btn-outline-danger" onclick="return confirm('Удалить {{ $test->name }} ?')">Удалить</button>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $category->tests()->paginate(5) }}
        </div>
    </main>
@endsection
