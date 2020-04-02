@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($tests as $test)
                <article class="article article-quizz">
                    <div class="quizz-details">
                        <div class="info-cards">
                            <div class="info-card">
                                <div class="info-type">
                                    <i class="fa fa-question"></i>
                                    <span>ВОПРОСОВ</span>
                                </div>
                                <div class="info-value">
                                    <h4>{{$test['questions']}}</h4>
                                </div>
                            </div>
                            <div class="info-card">
                                <div class="info-type">
                                    <i class="far fa-clock"></i>
                                    <span>МИНУТ</span>
                                </div>
                                <div class="info-value">
                                    <h4>{{$test['max_time']}}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="quizz-ratings">
                            <div class="quizz-rating">
                                <span>Сложность</span>
                                <div class=" quizz-rating__stars star_{{$test['difficulty']}}">
                                    <i class="fa fa-star" data-rating="1"></i>
                                    <i class="fa fa-star" data-rating="2"></i>
                                    <i class="fa fa-star" data-rating="3"></i>
                                    <i class="fa fa-star" data-rating="4"></i>
                                    <i class="fa fa-star" data-rating="5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="quizz-description">
                        <h1>
                            <a href="https://skillvalue.com/quiz/en/dotnet/csharp-7-quiz-beginner-level/">
                                <span class="quizz-id">{{$loop->iteration}}</span>{{$test['name']}}</a>
                        </h1>

                        <p class="quiz-e    xcerpt">{{$test['description']}}</p>
                        <div class="quizz-buttons">


                            <a href="test/{{$test['id']}}" class="btn btn-secondary "><i class="fa fa-chevron-circle-right"></i>ПРОЙТИ ТЕСТ</a>
                            <a href="test/{{$test['id']}}" class="btn btn-secondary btn-reversed"><i class="fa fa-chevron-circle-right"></i>БОЛЬШЕ ИНФОРМАЦИИ</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </article>
@endforeach
</div>
    @endsection
