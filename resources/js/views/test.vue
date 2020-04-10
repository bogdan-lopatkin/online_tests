<template>
    <div v-if="!loading && !notAuthorized" @keyup.left="previousQuestion"
          @keyup.right="nextQuestion"
          tabindex="0" class="test-container">
        <div class="testsidebar">
            <header>
                <div class="site-branding">
                    <a title="OnlineTests">
                        <img  src="https://lh3.googleusercontent.com/SYxMV8opec7S9gZeblQmDcZs6yP21JivqHUDga0oNKi1kQPVMkoKmhEQNj3mrv45dK4h-w=s164" alt="Logo">
                    </a>
                </div>
            </header>
            <aside  class="quiz-info">
                <div  class="quiz-title">
                    <div  class="label">Тест</div>
                    <div  class="value">{{ testData['name'] }}</div>
                </div>
                <div  class="progress-item time">
                    <div  class="label">Время</div>
                    <div  class="value">
                        <i  class="far fa-clock"></i>
                        <span  class="current">{{ currentTime | humanTime }}</span>
                        <span  class="total"> / {{ testData['max_time'] }}:00</span>
                    </div>
                    <div  class="progress-bar" progressbar><span  :style="{width : TimeProgress + '%'}"></span></div>
                </div>
                <div  class="progress-item question-count">
                    <div  class="label">Вопрос</div>
                    <div  class="value">
                        <i  class="far fa-question-circle"></i>
                        <span v-html="currentQuestion"  class="current"></span>
                        <span  class="total"> / {{ testData.questions.length }}</span>
                    </div>
                    <div  class="progress-bar" progressbar><span  :style="{ width : questionProgress+'%' }"></span></div>
                </div>
            </aside>
        </div>

        <main  class="main-info">
            <div v-if="currentQuestioncheck(-1)"  class="quiz-info-container">
                <div v-html="testData['name']"></div>

                <div  class="instructions">
                    <h3 >Совет</h3>
                    <div >Можно использовать <b>left</b> и <b>right</b> стрелки клавиатуры что бы переключать вопросы.</div>
                </div>

                <div v-if="testAlreadyPassed" class="mt-5">
                    <h3>Вы уже прошли этот тест с результатом {{ previousResult }} / <b>{{ testData.max_points }}</b> баллов</h3>
                </div>
            </div>
            <div v-if="testEnded"  class="quiz-info-container">
                <div >Готовы отправить свой результат?</div>
                <div class="mt-3">
                    <div >У вас <b>{{ countUnanswered() }}</b> неотвеченных вопросов. Нажмите назад что бы еще раз проверить свои ответы или завершить тест что бы узнать свой результат.</div>
                </div>
            </div>
             <form ref="form" id="test_form" method="post" onsubmit="return false;" class="quiz-question-container">
                 <input type="hidden" name="_token" :value="csrf">
                 <input type="hidden" name="test_info" :value="resultInfo">
                    <div>
                        <article id="question_container"
                                 v-for="(question,index) in testData.questions"
                                 class="question-container"
                                v-show="currentQuestioncheck(index)">
                            <header class="header-container">
                                <h1>
                                    <span>{{ index+1 }}</span><strong v-html=" question['question_body'] "></strong>
                                </h1>
                            </header>
                            <section class="answers-container radio">
                                <div v-for="(answer) in question['answers']" class="answer-radio">
                                    <input v-model="picked[question.id]" :value="answer['id']" type="radio" :name="question['id']" :id="'answer'+answer['id']">
                                    <label v-html="answer['answer_body']" :for="'answer'+answer['id']" :class="labelChecked(question['id'],answer['id'])">
                                        <span  ></span>
                                    </label>
                                </div>
                            </section>
                        </article>
                    </div>
                 <div class="form-actions">
                     <div class="column">
                        <button type="button" v-show="previousQuestionAvailiable" @click="previousQuestion()" class="btn btn-previous">
                         <i class="fa fa-chevron-circle-left"></i>Назад</button>
                     </div>

                     <div v-if="currentQuestion==0" class="column">
                         <button type="button" @click="nextQuestion" class="btn btn-next">{{ start_button_text }}<i class="fa fa-chevron-circle-right"></i>
                         </button>
                     </div>
                     <div v-else-if="testEnded" class="column">
                         <button @click="submitResult" class="btn btn-next">Завершить тест <i class="fa fa-chevron-circle-right"></i>
                         </button>
                     </div>
                     <div v-else class="column">
                         <button type="button" @click="nextQuestion" class="btn btn-next">Вперед <i class="fa fa-chevron-circle-right"></i>
                         </button>
                     </div>
                 </div>
                </form>
        </main>
    </div>
    <div v-else class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Для прохождения тестов необходимо войти в свой аккаунт </div>

                        <div class="card-body">
                            <form method="POST" onsubmit="return false;">
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-mail адрес</label>

                                    <div class="col-md-6">
                                        <input v-model="email" id="email" type="email" class="form-control" name="email"  required autocomplete="email" autofocus>

                                        <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                                    <div class="col-md-6">
                                        <input v-model="password" id="password" type="password" class="form-control" name="password" required autocomplete="current-password">


                                        <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input v-model="remember" class="form-check-input" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label" for="remember">
                                                 Запомнить меня
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button @click="try_login" type="submit" class="btn btn-primary">
                                             Войти
                                        </button>

                                        <a class="btn btn-link" :href="restore">
                                            Забыли пароль?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PicZoom from 'vue-piczoom'
    export default {
        created() {
            this.fetchData();

            // this.testData = JSON.parse(this.json_data);  // info for result controller
            // let temp = {};
            // temp['id'] = this.testData['id'];
            // temp['name'] = this.testData['name'];
            // temp['points'] = this.testData['max_points'];
            // temp['questions'] = this.testData['questions'].length;
            // temp['difficulty'] = this.testData['difficulty'];
            // temp['category'] = this.testData['category']['name'];
            // this.resultInfo = JSON.stringify(temp);
            // temp = null;
            //
            // if(this.was != null) {                     // todo строгая  Проверка времени и ответов для экзаменов основанная на created_at
            //     let temp = JSON.parse(this.was)[0];
            //     if(temp.pivot.status === 'completed') {
            //         this.start_button_text = 'Пройти тест еще раз';
            //         this.testAlreadyPassed = true;
            //         this.previousResult = temp.pivot.mark;
            //     } else if(temp.pivot.status === 'started') {
            //         this.currentTime = temp.pivot.time_passed;
            //         let answers =  JSON.parse(temp.pivot.picked_answers);
            //         this.picked = answers;
            //        // this.currentQuestion = Object.keys(answers).length;  // Нужно ли перекидывать пользователя на последний ответ автоматически?
            //         this.start_button_text = 'Продолжить прохождение теста';
            //     }
            // }
        },
        mounted() {
            // var elements = document.getElementsByClassName('attachment attachment--preview attachment--png');
            // let i = 0;
            // while(elements.length > i) {
            //     let childNode = elements[i].getElementsByTagName("img");
            //     let parent = childNode[0].parentNode;
            //     elements[i].insertBefore(childNode[0],parent);
            //     elements[i].removeChild(elements[i].getElementsByTagName("a")[0]);
            //     i++;
            //  }

        },
        data : function () {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                currentQuestion : 0,
                currentTime : 0,
                testEnded : false,
                picked : {},
                startedAt : '',
                testData : [],
                resultInfo : '',
                start_button_text : 'Начать тест',
                testAlreadyPassed : false,
                previousResult : 0,
                json_data : '',
                was : '',
                loading : true,
                notAuthorized : false,
                restore : routes.restore_password,
                email : '',
                password : '',
                remember : ''
            }
        },
         computed :{
            questionProgress: function() {
                return this.currentQuestion/this.testData.questions.length* 100;
            },
            TimeProgress : function() {
                return this.currentTime/this.testData['max_time']/60 * 100;
            },
            previousQuestionAvailiable: function () {
                if(this.currentQuestion - 1 > 0)
                    return true;
                else
                    return false;
            },
        },
        methods : {
            fetchData() {
                this.loading = true;
                this.route = routes.result;
                let th = this;
                axios
                    .get(routes.test + this.$route.params.id)
                    .then(response => {
                        this.testData = response.data.testData[0];  // info for result controller
                        let temp = {};
                        temp['id'] = this.testData['id'];
                        temp['name'] = this.testData['name'];
                        temp['points'] = this.testData['max_points'];
                        temp['questions'] = this.testData['questions'].length;
                        temp['difficulty'] = this.testData['difficulty'];
                        temp['category'] = this.testData['category']['name'];
                        this.resultInfo = JSON.stringify(temp);
                        temp = null;

                        if(response.data.savedData[0] != null) {                     // todo строгая  Проверка времени и ответов для экзаменов основанная на created_at
                            let temp =  response.data.savedData[0];  //  JSON.parse(this.was)[0];
                            if (temp.pivot.status === 'completed') {
                                this.start_button_text = 'Пройти тест еще раз';
                                this.testAlreadyPassed = true;
                                this.previousResult = temp.pivot.mark;
                            } else if (temp.pivot.status === 'started') {
                                this.currentTime = temp.pivot.time_passed;
                                let answers = JSON.parse(temp.pivot.picked_answers);
                                this.picked = answers;
                                // this.currentQuestion = Object.keys(answers).length;  // Нужно ли перекидывать пользователя на последний ответ автоматически?
                                this.start_button_text = 'Продолжить прохождение теста';
                                this.tests = response.data.tests;
                            }
                        }
                        th.loading = false;
                    }).catch(
                    function (error) {
                        if(error.response.status == 403)
                            th.notAuthorized = true;
                    })
            },
            submitResult()
            {
                let resultInfo = this.resultInfo;
                let answers = this.picked;
                let id = this.resultInfo.id;
                this.$router.push({name : 'result', params : {resultInfo , answers }})
            },


            currentQuestioncheck(index) {
                if (this.currentQuestion == index + 1 && !this.testEnded)
                    return true;
                else
                    return false;
            },
            nextQuestion() {
                this.save();
                if (this.currentQuestion == 0)
                    this.countDownTimer();
                if (this.currentQuestion + 1 > this.testData.questions.length && !this.testEnded) {
                    this.testEnded = true;
                    this.currentQuestion++;
                }
                else if(!this.testEnded)
                    this.currentQuestion++;
            },
            previousQuestion() {
                this.save();
                if (this.currentQuestion - 1 > 0) {
                    this.currentQuestion--;
                    this.testEnded = false;
                }
            },
            countDownTimer() {
              //  this.testform();
              //  this.testform('ll');
                if (this.currentTime < this.testData['max_time'] * 60) {
                    setTimeout(() => {
                        this.currentTime++;
                        this.countDownTimer()
                    }, 1000)
                } else
                    this.$refs.form.submit();
            },
            labelChecked(question,answer) {
               let found = this.picked[question] == answer ?? false;
                 if(found)
                     return 'active';
                 else
                     return '';
            },
            save() {
                let currentTest = {};
                currentTest['testId'] = this.testData['id'];
                currentTest['answers'] = this.picked;
                currentTest['time'] = this.currentTime;
                axios.post('/api/test/save', JSON.stringify(currentTest));
                return true;
            },
            countUnanswered() {
                return this.testData.questions.length - Object.keys(this.picked).length;
            },
            try_login()
            {
                if(this.email && this.password && /\S+@\S+\.\S+/.test(this.email)) {
                    axios
                        .post(routes.login, {email: this.email, password: this.password, remember: this.remember})
                        .then(response => {
                            if(response.status == 204) {
                                this.notAuthorized = false;
                                this.fetchData();
                            }
                        }).catch(error => {
                        if(error.response.status == 422)
                                alert('Такой пользователь не найден');
                    })
                }
            }
        },

        filters : {
            humanTime : function (time) {
                let minute = 0;
                if(time > 60) {
                    while (time > 60) {
                        time -= 60;
                        minute++;
                    }
                }
                if(minute < 10)
                    minute = '0' + minute;
                if(time < 10)
                    time = '0' + time;
                return minute + ':' + time;
            },
            validateRawHTML : function (str) {

            }
        },
        components : {
            PicZoom
        },

    }
</script>
