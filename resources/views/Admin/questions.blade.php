@extends('Admin.app')
@section('content')

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <h2>Вопросы <a class="btn btn-dark" href="{{ route('admin.question.create') }}">Добавить новый вопрос</a></h2>
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
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'name' }}">Вопрос</button></th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'name' }}">Принадлежит к тесту</button></th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'questions' }}">Количество ответов</button> </th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'difficulty' }}">Баллов за ответ</button></th>
                    </tr>
                </form>
                </thead>

                <tbody>
                @foreach($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>{!! $question->question_body !!}</td>
                    <td>{{ $question->test_id }}</td>
                    <td>{{ $question->answersCount[0]->total ?? 0  }}</td>
                    <td>{{ $question->points }}</td>
                    <td><a class="btn btn-outline-primary" href="{{ route('admin.question.show',$question->id) }}">Подробнее</a> </td>
                    <td><a class="btn btn-outline-info" href="{{ route('admin.question.edit',$question->id) }}">Редактировать</a></td>
                    <td>
                        {{ Form::open(['method' => 'DELETE', 'route' => ['admin.question.destroy', $question->id]]) }}
                        <button class="btn btn-outline-danger" onclick="return confirm('Удалить ?')">Удалить</button>
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
{{--            {{ $questions->paginate(5) }}--}}
        </div>
    </main>
@endsection
