@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h2>Ваши тесты</h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <form method="get" action="{{ route('admin.test.index') }}">
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Сложность</th>
                        <th>Баллов набрано</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                </form>
                </thead>

                <tbody>
                @foreach($tests as $test)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $test->name }}</td>
                        <td>{!!$test->category->name ?? '<b>Ошибка</b>'!!}</td>
                        <td> <div class=" quizz-rating__stars star_{{ $test->difficulty }}">
                                <i class="fa fa-star" data-rating="1"></i>
                                <i class="fa fa-star" data-rating="2"></i>
                                <i class="fa fa-star" data-rating="3"></i>
                                <i class="fa fa-star" data-rating="4"></i>
                                <i class="fa fa-star" data-rating="5"></i>
                            </div>
                        </td>
                        <td><b>{{ $test->pivot->mark }}</b> / {{ $test->max_points }}</td>
                        <td>
                            @if($test->pivot->status === 'completed')
                                Завершен
                        </td>
                        <td></td>
                    @elseif($test->pivot->status === 'started')
                                Начат
                            <td><a class="btn btn-primary" href="{{ route('test',$test->id )}}">Продолжить прохождение</a></td>

                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
