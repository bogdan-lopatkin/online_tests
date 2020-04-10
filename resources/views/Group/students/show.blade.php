@extends('layouts.app')
@section('content')
    <div class="container">

<h2>Результаты тестов ученика {{ $student->name }}</h2>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <form method="get" action="{{ route('admin.test.index') }}">
            <tr>
                <th>#</th>
                <th>Название</th>
                <th>Сложность</th>
                <th>Баллов набрано</th>
                <th>Статус</th>
                <th></th>
            </tr>
        </form>
        </thead>

        <tbody>
        @foreach($student->tests->where('group_id',auth()->user()->group->id) as $test)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $test->name }}</td>
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

                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
