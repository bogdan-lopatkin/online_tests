<template>
    <div  @keyup.left="previousQuestion"
          @keyup.right="nextQuestion"
          tabindex="0" class="test-container">
        <div class="sidebar">
            <header>
                <div class="site-branding">
                    <a title="OnlineTests">
                        <img  src="https://lh3.googleusercontent.com/pxgNn18P6LN0FUBb2_CRNlMo0H7iKRCjIphtaDWEabVn6yiz8GiWzvIp7PCjV3gE-rlB-Q=s164" alt="Logo">
                    </a>
                </div>
            </header>
            <aside  class="quiz-info">
                <div  class="quiz-title">
                    <div  class="label">Тест</div>
                    <div  class="value">{{ test['name'] }}</div>
                </div>
                <div  class="progress-item time">
                    <div  class="label">Время</div>
                    <div  class="value">
                        <i  class="far fa-clock"></i>
                        <span  class="current">{{ currentTime | humanTime }}</span>
                        <span  class="total"> / {{ test['max_time'] }}:00</span>
                    </div>
                    <div  class="progress-bar" progressbar><span  :style="{width : TimeProgress + '%'}"></span></div>
                </div>
                <div  class="progress-item question-count">
                    <div  class="label">Вопрос</div>
                    <div  class="value">
                        <i  class="far fa-question-circle"></i>
                        <span  class="current">{{ currentQuestion}}</span>
                        <span  class="total"> / {{ test['questions'] }}</span>
                    </div>
                    <div  class="progress-bar" progressbar><span  :style="{ width : questionProgress+'%' }"></span></div>
                </div>
            </aside>
        </div>

        <main  class="main-info">
            <div v-if="currentQuestioncheck(-1)"  class="quiz-info-container">
                <div >{{ test['name']}}</div>

                <div  class="instructions">
                    <h3 >Совет</h3>
                    <div >Можно использовать <b>left</b> и <b>right</b> стрелки клавиатуры что бы переключать восросы.</div>
                </div>
            </div>
            <div v-if="testEnded"  class="quiz-info-container">
                <div >Готовы отправить свой результат?</div>
                <div class="mt-3">
                    <div >У вас <b>{{ unanswered }}</b> неотвеченных вопросов. Нажмите назад что бы еще раз проверить свои ответы или завершить тест что бы узнать свой результат.</div>
                </div>
            </div>
             <form ref="form" method="post" action="/result" class="quiz-question-container">
                 <input type="hidden" name="_token" :value="csrf">
                    <div>
                        <article id="question_container"
                                 v-for="(question,index) in questions"
                                 class="question-container"
                                v-show="currentQuestioncheck(index)">
                            <header class="header-container">
                                <h1>
                                    <span>{{ index+1 }}</span><strong>{{ question['question_body'] }}</strong>
                                </h1>
                            </header>
                            <section class="answers-container radio">
                                <div v-for="(answer) in question['answers']" class="answer-radio">
                                    <input v-model="picked[index]" :value="answer['id']" type="radio" :name="'question'+question['id']" :id="'answer'+answer['id']">
                                    <label :for="'answer'+answer['id']" :class="labelChecked(answer['id'])">
                                        <span>{{ answer['answer_body'] }}</span>
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
                         <button type="button" @click="startTest()" class="btn btn-next">Начать тест <i class="fa fa-chevron-circle-right"></i>
                         </button>
                     </div>
                     <div v-else-if="testEnded" class="column">
                         <button class="btn btn-next">Завершить тест <i class="fa fa-chevron-circle-right"></i>
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
</template>

<script>
    export default {
        props : ['questions','test','was'],
        mounted() {
            let testInfo;
        if(this.was != 'null ') {
          testInfo  = JSON.parse(this.was);
          if(testInfo.testId == this.test.id)
          {
              if(confirm('Продолжить тест?')) {
                  this.currentTime = testInfo.time;
                  this.countDownTimer();
                  this.currentQuestion = testInfo.answered.length;
                  this.picked = testInfo.answered;
              }
          } else {
              if(confirm('Вы не закончили предыдущий тест, переключиться на него? В противном случае Ваши результаты будут удалены')) {
                  window.location.href = "/";
              }
          }

        }
        },
        data : function () {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                currentQuestion : 0,
                currentTime : 0,
                unanswered : 1,
                testEnded : false,
                picked : [],
                startedAt : ''
            }
        },
        computed :{
            questionProgress: function() {
                return this.currentQuestion/this.test['questions'] * 100;
            },
            TimeProgress : function() {
                return this.currentTime/this.test['max_time']/60 * 100;
            },
            previousQuestionAvailiable: function () {
                if(this.currentQuestion - 1 > 0)
                    return true;
                else
                    return false;
            },

        },
        methods : {
            currentQuestioncheck(index) {
                if (this.currentQuestion == index + 1 && !this.testEnded)
                    return true;
                else
                    return false;
            },
            nextQuestion() {
                if (this.currentQuestion + 1 > this.test['questions'])
                    this.testEnded = true;
                else
                    this.currentQuestion++;
            },
            previousQuestion() {
                if (this.currentQuestion - 1 > 0) {
                    this.currentQuestion--;
                    this.testEnded = false;
                }
            },
            countDownTimer() {
                this.save();
                if (this.currentTime < this.test['max_time'] * 60) {
                    setTimeout(() => {
                        this.currentTime++;
                        this.countDownTimer()
                    }, 1000)
                } else
                    this.$refs.form.submit();
            },
            startTest() {
                this.countDownTimer();
                this.nextQuestion();
            },
            labelChecked(id) {
               let found = this.picked.find(function(element) {
                    return element == id;
                    }
                )
                if(found)
                    return 'active';
                else
                    return '';
            },
            save() {
                let currentTest = {};
                currentTest['testId'] = this.test['id'];
                currentTest['answers'] = this.picked;
                currentTest['time'] = this.currentTime;
                axios.post('/api/test/save', JSON.stringify(currentTest));
            },
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

            }
        }

    }
</script>
