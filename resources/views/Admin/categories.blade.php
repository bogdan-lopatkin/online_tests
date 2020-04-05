@extends('Admin.app') @section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <h2>Категории <a class="btn btn-dark" href="{{ route('admin.category.create') }}">Добавить</a></h2>
        <div class="table-responsive">
            <table id="example" class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Количество тестов</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->countTests[0]->total ?? 0 }}</td>
                    <td><a class="btn btn-outline-primary" href="{{ route('admin.category.show',$category->id) }}">Подробнее</a> </td>
                    <td><a class="btn btn-outline-info" href="{{ route('admin.category.edit',$category->id) }}">Редактировать</a></td>
                    <td>
                        {{ Form::open(['method' => 'DELETE', 'route' => ['admin.category.destroy', $category->id]]) }}
                            <button class="btn btn-outline-danger" onclick="return confirm('Удалить {{ $category->name }} ?')">Удалить</button>
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
