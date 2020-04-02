@extends('Admin.app')
@section('content')

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <h2 class="text-center">Редактирование категории</h2>
            {{ Form::open(['method' => 'PUT', 'route' => ['admin.category.update', $category->id]]) }}
            @csrf
            <input id="category_name" name="name" value="{{ old('name') ?? $category->name }}" class="form-control-lg @error('name') alert-danger @enderror" type="text">
            <button class="btn btn-primary">Редактировать категорию</button>
            {{ Form::close() }}
        @error('name')
        <div class="">
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                {{ $message }}
            </div>
        </div>
        @enderror
    </main>

@endsection
