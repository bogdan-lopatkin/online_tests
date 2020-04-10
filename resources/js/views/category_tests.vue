<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="single-taxonomy">
<!--                    @if(!$request)-->
                    <h1 v-if="!$route.query.s">{{ tests[0].category.name }}</h1>
<!--                    @else-->
                    <h1 v-else>Результаты поиска</h1>
<!--                    @endif-->
                    <router-link class="btn btn-back" :to="{ name: 'test_categories'}"><i class="fa fa-chevron-left"></i>Обратно к категориям</router-link>
<!--
                    <a href="{{  }}" class="btn btn-back"><i class="fa fa-chevron-left"></i>Обратно к категориям</a>
-->
                </div>
            </div>
        </div>
<!--        @foreach($tests as $test)-->
        <div class="mb-3" v-for="(test,index) in tests">
<!--        <div class="single-taxonomy">-->
<!--            @if($request)-->
<!--            <h4>Результаты в категории {{ $test->category->name ?? 'Ошибка бд' }}</h4>-->
<!--            @endif-->
<!--        </div>-->
        <article class="article article-quizz">
            <div class="quizz-details">
                <div class="info-cards">
                    <div class="info-card">
                        <div class="info-type">
                            <i class="fa fa-question"></i>
                            <span>ВОПРОСОВ</span>
                        </div>
                        <div class="info-value">
                            <h4>{{test['questions']}}</h4>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-type">
                            <i class="far fa-clock"></i>
                            <span>МИНУТ</span>
                        </div>
                        <div class="info-value">
                            <h4>{{test['max_time']}}</h4>
                        </div>
                    </div>
                </div>

                <div class="quizz-ratings">
                    <div class="quizz-rating">
                        <span>Сложность</span>
                        <div :class="'quizz-rating__stars star_' + test['difficulty']">
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
                    <a href="#">
                        <span class="quizz-id">{{index+1}}</span>{{test['name']}}</a>
                </h1>

                <p class="quiz-excerpt" v-html="test['description']"></p>
                <div class="quizz-buttons">


<!--                    <a href="" class="btn btn-secondary "><i class="fa fa-chevron-circle-right"></i>ПРОЙТИ ТЕСТ</a>-->
                    <router-link :to="{ name: 'test', params: { id: test.id } }" class="btn btn-secondary">
                        <i class="fa fa-chevron-circle-right"></i>ПРОЙТИ ТЕСТ
                    </router-link>
                    <a href="" class="btn btn-secondary btn-reversed"><i class="fa fa-chevron-circle-right"></i>БОЛЬШЕ ИНФОРМАЦИИ</a>
                </div>
            </div>
        </article>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.fetchData();
        },
        data : function () {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                tests : [{'category': 'promise'}]
            }
        },
        methods : {
            fetchData() {
                let query = this.$route.query.s;
                console.log(query);
                this.loading = true;
                axios
                    .get(routes.category_tests + this.$route.params.categoryId,{params: {s: query}})
                    .then(response => {
                        console.log(response);
                        this.tests = response.data.tests;
                    });
            }
        },
    }
</script>
