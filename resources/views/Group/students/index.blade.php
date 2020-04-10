@extends('layouts.app') @section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

        <h2>Пользователи</h2>
        <div class="table-responsive">
            <table id="example" class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Логин</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    @if($user->id != auth()->id())
                        <tr>
                    <td>{{ $loop->iteration }}</td>

                        <td>{{ $user->name }}</td>
                    <td><a class="btn btn-outline-info" href="{{ route('group.students.show',$user->id) }}">Посмотреть результаты</a></td>
                    <td>
                            {{ Form::open(['method' => 'DELETE', 'route' => ['group.students.destroy', $user->id]]) }}
                                <button class="btn btn-outline-danger" onclick="return confirm('Удалить {{ $user->name }} ?')">Удалить из группы</button>
                            {{ Form::close() }}
                    </td>
                </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
