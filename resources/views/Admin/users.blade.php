@extends('Admin.app') @section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

        <h2>Пользователи <a class="btn btn-dark" href="{{ route('admin.user.create') }}">Добавить</a></h2>
        <div class="table-responsive">
            <table id="example" class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Логин</th>
                    <th>Почта</th>
                    <th>Почта подтверждена</th>
                    <th>Роль</th>
                    <th>Состояние</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->email_verified_at ? 'Да' : 'Нет' }}</td>
                    <td>{{ $user->role_id }}</td>
                    <td>{{ $user->banned ? 'Забанен' : 'Активен' }}</td>
                    <td>{{ $user->created_at }}</td>

                    <td><a class="btn btn-outline-info" href="{{ route('admin.user.edit',$user->id) }}">Редактировать</a></td>
                    <td>
                        {{ Form::open(['method' => 'DELETE', 'route' => ['admin.user.destroy', $user->id]]) }}
                            <button class="btn btn-outline-danger" onclick="return confirm('Забанить {{ $user->name }} ?')">Удалить</button>
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
