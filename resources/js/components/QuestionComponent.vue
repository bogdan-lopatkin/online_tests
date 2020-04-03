<template>
    <div  @keyup.left="previousQuestion"
          @keyup.right="nextQuestion"
          tabindex="0" class="test-container">
        <div class="testsidebar">
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
                    <div >Можно использовать <b>left</b> и <b>right</b> стрелки клавиатуры что бы переключать восросы.</div>
                </div>
            </div>
            <div v-if="testEnded"  class="quiz-info-container">
                <div >Готовы отправить свой результат?</div>
                <div class="mt-3">
                    <div >У вас <b>{{ countUnanswered() }}</b> неотвеченных вопросов. Нажмите назад что бы еще раз проверить свои ответы или завершить тест что бы узнать свой результат.</div>
                </div>
            </div>
             <form ref="form" method="post" :action="route" class="quiz-question-container">
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
                         <button type="button" @click="nextQuestion" class="btn btn-next">Начать тест <i class="fa fa-chevron-circle-right"></i>
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
    import PicZoom from 'vue-piczoom'
    export default {
        props : ['json_data','was','route'],
        created() {
            this.testData = JSON.parse(this.json_data);  // info for result controller
            let temp = {};
            temp['id'] = this.testData['id'];
            temp['name'] = this.testData['name'];
            temp['points'] = this.testData['max_points'];
            temp['questions'] = this.testData['questions'].length;
            temp['difficulty'] = this.testData['difficulty'];
            temp['category'] = this.testData['category']['name'];
            this.resultInfo = JSON.stringify(temp);
            temp = null;

      //      if(this.was != null) {  // todo   Проверка времени и ответов для экзаменов
              // //  this.nextQuestion();
              //   let temp = JSON.parse(this.was);
              //   temp = temp[0].pivot;
              //   let answers =JSON.parse(temp.picked_answers);
              //   console.log(temp);
              //   this.currentTime = (new Date() - new Date(temp.created_at));
              //   for (var prop in answers) {
              //       this.picked[prop] = answers[prop];
              //   }
           // }
        }   ,
        mounted() {
            var elements = document.getElementsByClassName('attachment attachment--preview attachment--png');
            let i = 0;
            while(elements.length > i) {
                let childNode = elements[i].getElementsByTagName("img");
                let parent = childNode[0].parentNode;
                elements[i].insertBefore(childNode[0],parent);
                elements[i].removeChild(elements[i].getElementsByTagName("a")[0]);
                i++;
             }

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
                resultInfo : ''
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
