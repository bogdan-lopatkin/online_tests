@extends('Admin.app')
@section('content')

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <h2>Тесты в категории {{ $category->name }} <a class="btn btn-dark" href="{{ route('admin.test.create') }}">Добавить новый тест</a></h2>
        <div class="table-responsive">
            <table class="table text-center table-striped table-sm">
                <thead>

                        <th>#</th>
                        <th>Название</th>
                        <th>Количество вопросов </th>
                        <th>Сложность</th>
                        <th>Время на выполнение  </th>
                        <th>Создан</th>
                    </tr>
                </form>
                </thead>

                <tbody>
                @foreach($category->tests()->paginate(15) as $test)
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
