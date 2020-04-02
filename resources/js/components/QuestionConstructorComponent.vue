<template>
    <div   tabindex="0" class="test-container">
        <div class="testsidebar">
            <header>
                <div class="site-branding">
                    <a title="OnlineTests">
                        <img  src="https://lh3.googleusercontent.com/pxgNn18P6LN0FUBb2_CRNlMo0H7iKRCjIphtaDWEabVn6yiz8GiWzvIp7PCjV3gE-rlB-Q=s164" alt="Logo">
                    </a>
                </div>
            </header>
            <aside  class="quiz-info">
                <div  class="progress-item question-count">
                    <div  class="value">
                        <span  class="current">Категория
                              <select v-model="testCategory" name="category">
                                <option v-for="category in categories" :value="category.id">{{ category.name}}</option>
                           </select>
                        </span>
                    </div>
                    <hr>

                    <div  class="quiz-title">
                        <div   class="value"><textarea placeholder="Название теста" v-model="testName" class="testBuildInput"></textarea></div>
                </div>
                <div  class="progress-item time">
                    <div  class="value">
                        <i  class="far fa-clock"></i>
                        <span  class="current"><input id="timePick" min="5" v-model="max_time" type="number">минут</span>
                        <span  class="total"></span>
                    </div>
                </div>
                    <hr>
                    <div  class="value">
                        <span  class="current">Сложность:
                            <select v-model="testDifficulty" name="difficulty">
                                <option value="1">Начинающий</option>
                                <option selected value="2">Ученик</option>
                                <option value="3">Студент</option>
                                <option value="4">Знаток</option>
                                <option value="5">Профессионал</option>
                           </select>
                        </span>
                    </div>
                </div>
                <hr>
                <div  class="progress-item question-count">
                    <div  class="value">
                        <i  class="far fa-question-circle"></i>
                        <span  class="current">Вопросов: {{ testQuestions.length}} </span>
                    </div>
                </div>
                <div @click="saveTest" v-show="isBuilding" class="mt-5 pt-5">
                    <div class="mt-5 btn btn-dark">Завершить создание теста
                    </div>
                </div>
            </aside>
        </div>

        <main  class="main-info">
            <div v-if="!isBuilding"  class="quiz-info-container">
                <VueTrix @trix-attachment-add="handleAttachmentChanges" @trix-attachment-remove="remove"   v-model="testDescription"
                         placeholder="Развернутое описание теста,описание навыков необходимых для его прохождения"/>

                <div v-show="errors.length" class="instructions">
                    <h3> Ошибки </h3>
                    <div v-for="error in errors">{{error}}</div>
                </div>
            </div>
            <div v-if="buildEnded" class="quiz-info-container">
                <div >Готовы отправить свой результат?</div>
                <div class="mt-3">
                    <div >У вас <b>{{ }}</b> неотвеченных вопросов. Нажмите назад что бы еще раз проверить свои ответы или завершить тест что бы узнать свой результат.</div>
                </div>
            </div>
             <form  ref="form" method="post"  class="quiz-question-container">
                 <input type="hidden" name="_token" >
                 <input type="hidden" name="test_info" >
                    <div>
                        <article v-for="(question,index) in testQuestions" id="question_container"
                                 v-show="currentQuestionCheck(index)"
                                 class="question-container">
                                <header class="header-container">
                                <h1 style="width: 100%">
                                    <span style="top:-10px">{{ index+1 }} </span> Вопрос
                                    <button type="button" @click="deleteQuestion(index)"
                                            :disabled="index < 2"
                                            class="btn w-25 float-right mb-4 mr-0 btn-dark">Удалить вопрос</button>

                                </h1>
                                    <div  class="current d-flex justify-content-end te"><i>Баллов за вопрос</i><input id="pointsPick" min="5" v-model="question.points" type="number"></div>
                                    <VueTrix @trix-attachment-add="handleAttachmentChanges"  :class="questionEmpty ? 'border-danger w-100 border-bottom' : 'w-100'"  v-model="question.name"
                                             placeholder="Развернутое описание вопроса,позволяющее дать конкретный ответ"

                                    />
                                </header>
                            <section style="max-width: 860px;" class="answers-container radio">

                                <div class="form-group">
                                </div>
                                <h2 class="text-center">Ответы <button type="button" style="max-width: 165px; font-size: 14px"
                                                                       class="btn float-right m-0  btn-dark" @click="addNewAnswer(index)">Добавить ответ</button>
                                </h2>
                                <div v-for="(answer,childIndex) in question.answers"  class="w-100 answer-radio-add mb-3">
                                    <VueTrix @trix-attachment-add="handleAttachmentChanges" class="answer-trix"  v-model="answer.name"
                                             placeholder="Вариант ответа"
                                             :class="checkAnswer(answer) ? 'border-danger border-bottom border' : ''"
                                    />
                                    <div class="d-flex flex-column mt-auto" style="min-width: 50px; min-height:70px" >
                                        <button type="button" @click="deleteAnswer(index,childIndex)"
                                                :disabled="childIndex < 4"
                                                class="w-100 h-50 btn btn-danger"><i class="fa fa-trash"></i></button>
                                        <button @click="setCorrectAnswer(index,childIndex)" type="button"
                                                :disabled="answer.correct == true"
                                                class="w-100 h-50 btn btn-success"><i class="fa fa-check"></i></button>
                                    </div>
                                </div>

                            </section>
                        </article>
                    </div>
                 <div class="form-actions">
                     <div class="column">
                        <button type="button" v-show="currentPage > 0 "  @click="previousQuestion" class="btn btn-previous">
                         <i class="fa fa-chevron-circle-left"></i>Назад</button>
                     </div>

                     <div v-show="!isBuilding" @click="checkTestInfo" class="column">
                         <button type="button"  class="btn btn-next">Перейти к созданию вопросов<i class="fa fa-chevron-circle-right"></i>
                         </button>
                     </div>
                     <div  v-show="currentPage+1 < testQuestions.length" @click="nextQuestion" class="column">
                         <button type="button" class="btn btn-next">Вперед<i class="fa fa-chevron-circle-right"></i>
                         </button>
                     </div>
                     <div v-show="isBuilding && currentPage+1 >= testQuestions.length" @click="checkQuestion()" class="column">
                         <button type="button" class="btn btn-next">Создать еще один вопрос <i class="fa fa-chevron-circle-right"></i>
                         </button>
                     </div>
                 </div>
                </form>
        </main>
    </div>
</template>

<script>
    import VueTrix from "vue-trix"

        export default {
        props: ["categories",'upload_route','save_route'],
        created() {
            console.log('kk');
            window.addEventListener('beforeunload', this.leaving);
        },
        data: function () {
            return {
                currentQuestion: 0,
                testEnded: false,
                picked: {},
                testName: "",
                testDescription: "",
                testCategory: "",
                max_time: 5,
                totalQuestionCount: 0,
                max_points: 0,
                questions: 0,
                testDifficulty: "",
                currentPage: 0,
                buildEnded: false,
                testQuestions: [],
                isBuilding: false,
                newAnswer: "",
                imgPath : '',
                errors : [],
                incorrectAnswer : false,
                questionEmpty: false,
                submitted : false,
                deleteList : []
            };
        },
        methods: {
            addNewQuestion() {
                this.testQuestions.push({
                    name: "",
                    answers: [{ name: "", correct: false },
                        { name: "", correct: false },
                        { name: "", correct: false },
                        { name: "", correct: false }],
                    points: 5,
                });
                if (this.isBuilding) this.currentPage++;
            },
            startBuild() {
                this.addNewQuestion();
                this.isBuilding = true;
            },
            nextQuestion() {
                this.currentPage++;
            },
            previousQuestion() {
                this.currentPage--;
            },
            currentQuestionCheck(index) {
                return index == this.currentPage ? true : false;
            },
            addNewAnswer(index) {
               this.testQuestions[index].answers.push({name:'',correct:false});
            },
            setCorrectAnswer(index,childIndex) {
                this.testQuestions[index].answers.forEach((item) => {
                    item.correct = false;
                });
                this.testQuestions[index].answers[childIndex].correct = true;
            },
            saveTest() {
                    let testInfo = {};
                    testInfo.testName = this.testName;
                    testInfo.testDescription = this.testDescription;
                    testInfo.testCategory = this.testCategory;
                    testInfo.testDifficulty = this.testDifficulty;
                    testInfo.questions = this.testQuestions;
                    testInfo.questionsCount = this.testQuestions.length;
                    testInfo.maxTime = this.max_time;
                    testInfo.max_points = 0;
                    this.testQuestions.forEach((item) => {
                        testInfo.max_points += item.points;
                    });
                    console.log(testInfo);
                    console.log(JSON.stringify(testInfo));

                   let self = this;
                       axios.post(this.save_route,JSON.stringify(testInfo))
                        .then(function (response) {
                            //redirect logic
                            if (response.status == 200) {
                                console.log(self.submitted);
                                self.submitted = true;
                                window.location.href = response.request.responseURL;
                            } else {
                                alert(response);
                            }
                        });
            },
            deleteAnswer(index, childIndex) {
                this.testQuestions[index].answers.splice(childIndex, 1);
            },
            remove(event) {
                console.log(event.attachment);
                let file = event.attachment.attachment.attributes.values.href;
                axios.post('http://onlinetests/api/file/delete',JSON.stringify([file]))
            },

                handleAttachmentChanges(event) {
                let file = event.attachment.file;
                console.log(event.attachment.file);
                axios.defaults.headers.common["X-CSRF-TOKEN"] = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content');

                let key = this.createStorageKey(file);
                let formData = this.createFormData(key, file);

                  axios.post(this.upload_route, formData)
                    .then((response) => {
                        if (response.data != false) {
                            this.imgPath = response.data;
                            this.deleteList.push(this.imgPath);
                            let attributes = {
                                url: "http://onlinetests/storage/" + this.imgPath,
                                href:  this.imgPath,
                            };
                            event.attachment.setAttributes(attributes);
                        }
                    })
            },
            createStorageKey(file) {
                var date = new Date();
                var day = date.toISOString().slice(0, 10);
                var name = date.getTime() + "-" + file.name;
                return ["tmp", day, name].join("/");
            },

            createFormData(key, file) {
                var data = new FormData();
                data.append("key", key);
                data.append("Content-Type", file.type);
                data.append("file", file);
                return data;
            },
            deleteAnswer(index,childIndex) {
                this.testQuestions[index].answers.splice(childIndex,1);
            },
            deleteQuestion(index) {
                this.testQuestions.splice(index,1);
            },
             checkQuestion() {
                 this.incorrectAnswer = true;
                 this.questionEmpty = false;
                 if(this.testQuestions[this.currentPage].name.length < 5) {
                     this.questionEmpty = true;
                 }
                 this.testQuestions[this.currentPage].answers.forEach((item,index) => {
                     if(item.name.length < 5 && this.incorrectAnswer === true) {
                         this.incorrectAnswer = item;
                         return false;
                     }
                 });
                 if(this.incorrectAnswer === true && this.questionEmpty != true)
                 this.addNewQuestion();
             },
            checkTestInfo() {
                this.errors = [];
                if(this.testName.length < 5)
                    this.errors.push('Имя теста слишком короткое');
                if(this.testDescription.length < 5)
                    this.errors.push('Описание теста слишком короткое');
                if(!this.testCategory)
                    this.errors.push('Категория теста не выбрана');
                if(!this.testDifficulty)
                    this.errors.push('Сложность теста не выбрана');
                if (this.errors.length)
                    return false;
                else
                    this.startBuild();
            },
            checkAnswer(answer) {
                if(this.incorrectAnswer==answer)
                    return true;
                else
                    return false;
            },
            leaving(e) {
                if(this.submitted == false)
                    axios.post('http://onlinetests/api/file/delete',JSON.stringify(this.deleteList));
            }
        },
        components: {
            VueTrix,
        },
    };

</script>

