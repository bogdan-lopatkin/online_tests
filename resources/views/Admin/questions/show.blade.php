@extends('Admin.app')
@section('content')

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        {{ Breadcrumbs::render('question.show',$question) }}
        <div class="table-responsive">
            <h2>Ответы на вопрос {!! $question->question_body !!} <a class="btn btn-dark" href="{{ route('admin.answer.create',$question->id) }}">Добавить</a></h2>
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
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'name' }}">Ответ</button></th>
                        <th><button class="btn btn-link" type="submit" name="orderBy" value="{{ 'questions' }}">Ответ верен?</button> </th>
                        <th></th>
                        <th></th>
                    </tr>
                </form>
                </thead>

                <tbody>
                @foreach($question->answers as $answer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{!! $answer->answer_body !!}</td>
                    <td>{{ $answer->is_correct ? 'Верный ответ' : 'Неверный ответ' }}</td>
                    <td><a class="btn btn-outline-info" href="{{ route('admin.answer.edit',$answer->id) }}">Редактировать</a></td>
                    <td>
                        {{ Form::open(['method' => 'DELETE', 'route' => ['admin.answer.destroy', $answer->id]]) }}
                            <button @if($answer->is_correct) disabled @endif class="btn btn-outline-danger" onclick="return confirm('Удалить ?')">Удалить</button>
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
