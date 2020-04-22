<template>
    <div class="container">
        <div class="test-result-info">
            <div class="column summary">
                <div class="quiz-info box-container">
                    <h1>{{ test.name }}</h1>
                    <div class="quiz-rating">
                        <div class="label">Сложность</div>
                        <div :class="'quizz-rating__stars star_' + test.difficulty">
                            <i class="fa fa-star" data-rating="1"></i>
                            <i class="fa fa-star" data-rating="2"></i>
                            <i class="fa fa-star" data-rating="3"></i>
                            <i class="fa fa-star" data-rating="4"></i>
                            <i class="fa fa-star" data-rating="5"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column main-info">
                <div class="box-container">
                    <div>
                        <div class="score">
                            <h2>Вы ответили на
                                <span class="value">{{ result['questions'] }}<span>/{{ test.questions }}</span></span>&nbsp;
                                <span class="fa fa-question-circle" aria-hidden="true"></span>
                            </h2>
                            <h2>И набрали
                                <span class="value">{{ result['points'] || checkResult() }}<span>/{{ test.points }}</span></span>&nbsp; баллов
                            </h2>
                        </div>
                        <div class="description">
                            <div>
                                <p>Поздравляем с завершением теста! Теперь Вы часть <strong>{{ test.category }}</strong> сообщества,проверившая свои знания!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['resultInfo', 'answers'],
        created() {
            this.fetchData();


        },
        data: function () {
            return {
                test: [],
                result: []
            }
        },
        methods: {
            fetchData() {
                if(!this.answers  && !this.resultInfo) {
                    if (!this.$route.params.id)
                        this.$router.push({name: 'test_categories'});
                    this.$router.push({name: 'test', params: {id: this.$route.params.id}});
                } else {
                    axios
                        .post(routes.result, {test_info: this.resultInfo, answers: this.answers})
                        .then(response => {
                            console.log(response);
                            this.test = response.data.test;
                            this.result = response.data.result;
                        })
                }
            }
        },
        filters : {
            checkResult : function (value) {
                if (value > test.points)
                    return test.points;
                else
                    return value;
            }
        }
    }
</script>
