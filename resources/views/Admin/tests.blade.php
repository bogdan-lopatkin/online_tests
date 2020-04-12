@extends('Admin.app') @section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        {{ Breadcrumbs::render('tests') }}
        <h2>Тесты <a class="btn btn-dark" href="{{ route('admin.test.create') }}">Добавить</a></h2>
        <div class="table-responsive">
            <table class="table text-center table-striped table-sm">
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
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'questions' }}">Количество вопросов</button> </th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'category_id' }}">Категория</button></th>
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
                @foreach($tests as $test)
                    <tr>
                        <td>{{ $test->id }}</td>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->questions }}</td>
                        <td><a href="{{ route('admin.category.show',$test->category_id) }}">{!!$test->category->name ?? 'Учительский тест' !!}</a></td>
                        <td>{{ $test->difficulty }}</td>
                        <td>{{ $test->max_time }}</td>
                        <td>{{ $test->created_at }}</td>
                        <td><a class="btn btn-outline-primary" href="{{ route('admin.test.show',$test->id) }}">Подробнее</a> </td>
                        <td><a class="btn btn-outline-info" href="{{ route('admin.test.edit',$test->id) }}">Редактировать</a></td>
                        <td>
                            {{ Form::open(['method' => 'DELETE', 'route' => ['admin.test.destroy', $test->id]]) }}
                            <button class="btn btn-outline-danger" onclick="return confirm('Вы уверены ?')">Удалить</button>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $tests->links() }}
        </div>
    </main>
@endsection
