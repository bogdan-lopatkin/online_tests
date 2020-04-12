<template>
    <div   tabindex="0" class="test-container">

        <VueTrix @trix-attachment-add="handleAttachmentChanges"  :class="questionEmpty ? 'border-danger w-100 border-bottom' : 'w-100'"  v-model="question.name"
            placeholder="Развернутое описание вопроса,позволяющее дать конкретный ответ"

/>

</template>

<script>
    import VueTrix from "vue-trix"

        export default {
        props: ["categories",'upload_route','save_route'],
        created() {
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
                    answers: [{ name: "", correct: true },
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
                let validated = true;
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
                if(this.incorrectAnswer === true && this.questionEmpty != true) {

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
                    axios.post(this.save_route, JSON.stringify(testInfo))
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
                }
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
                                url: "https://onlinetests1.s3.us-east-2.amazonaws.com/" + this.imgPath,
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

