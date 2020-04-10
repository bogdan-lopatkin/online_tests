@extends('layouts.app') @section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <h2>Домашнее задание для группы "{{ $group->name }}" </h2>
        {{ Form::open(['method' => 'PATCH', 'route' => ['group.homework.update',auth()->user()->group->id]]) }}
        {!! Form::hidden('daily_task', $group->daily_task,['id' => 'daily_task']) !!}
        <trix-editor input="daily_task"></trix-editor>

        {!! Form::submit() !!}
        {!! Form::close() !!}




    </main>

@endsection
