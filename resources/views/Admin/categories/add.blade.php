@extends('Admin.app')
@section('content')

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        {{ Breadcrumbs::render('categories.add') }}
        <h2 class="text-center">Добавление новой категории</h2>
        <form class="d-flex justify-content-center" method="post" action="{{ route('admin.category.store') }}">
            @csrf
            <input id="category_name" name="name" class="form-control-lg @error('name') alert-danger @enderror" type="text">
            <button class="btn btn-primary">Добавить категорию</button>
        </form>
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
