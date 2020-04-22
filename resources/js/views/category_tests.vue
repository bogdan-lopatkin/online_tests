<template>
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="single-taxonomy">
                    <h1 v-if="!$route.query.s">{{ tests[0].category.name }}</h1>
                    <h1 v-else>Результаты поиска</h1>
                    <router-link class="btn btn-back" :to="{ name: 'test_categories'}"><i class="fa fa-chevron-left"></i>Обратно к категориям</router-link>
                </div>
            </div>
        </div>
        <div class="mb-3" v-for="(test,index) in tests">
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
                        <router-link :to="{ name: 'test', params: { id: test.id } }">
                            <span class="quizz-id">{{index+1}}</span>{{test['name']}}
                        </router-link>
                </h1>

                <p class="quiz-excerpt" v-html="test['description']"></p>
                <div class="quizz-buttons">
                    <router-link :to="{ name: 'test', params: { id: test.id } }" class="btn btn-secondary">
                        <i class="fa fa-chevron-circle-right"></i>ПРОЙТИ ТЕСТ
                    </router-link>
                    <button type="button" @click="showInfo(test)" class="btn btn-secondary btn-reversed">
                        <i class="fa fa-chevron-circle-right"></i>
                        БОЛЬШЕ ИНФОРМАЦИИ
                    </button>
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
                this.loading = true;
                axios
                    .get(routes.category_tests + this.$route.params.categoryId,{params: {s: query}})
                    .then(response => {
                        this.tests = response.data.tests;
                    });
            },
            showInfo(test) {
                alert("1)Максимальное время на выполнение теста - " + test.max_time + "минут \n" +
                      "2) Количество вопросов в тесте - " + test.questions)
            }
        },
    }
</script>
