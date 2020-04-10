@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12 skv-heading">
                    <h1>Протестируйте себя!</h1>
                    <p>Выберите один из 9999+ тестов и проверьте свои знания.
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="search-form">
                    <form role="search" method="get" class="search-form" action="{{ route('tests.category','search') }}">
                        <div class="search-wrapper">
                            <input type="search" class="search-field form-control is_search" placeholder="Поиск теста" value="" name="s" title="Поиск теста">
                            <i class="fa fa-times clear-search-input"></i>
                        </div>
                        <input type="submit" class="search-submit btn btn-primary" value="Найти">
                    </form>
                </div>
            </div>
        </div>


        <div class="courses row">
            @foreach($testCategories as $category)
            <div class="course-wrapper col-4">
                <article class="course-item">
                    <div class="course-item__grouped">
                        <div class="course-item__details">
                            <h1> {{ $category->category['name'] ?? 'Произошла ошибка' }}   </h1>

                            <small>
                                Уровень: от {{ $difficulty[$category->minDifficulty] }}
                                до {{ $difficulty[$category->maxDifficulty] }}
                            </small>

                        </div>
                        <div class="course-item__level">
                            <h5>{{ $category->total }}</h5>
                            <small>тестов</small>
                        </div>
                        <div class="clearfix"></div><a href="{{ route('tests.category',$category->category_id) }}" class="btn btn-medium btn-primary">
                            <i class="fa fa-chevron-circle-right">
                            </i>Перейти к тестам
                        </a>
                    </div>
                </article>
            </div>
            @endforeach
        </div>

</div>
    @endsection
