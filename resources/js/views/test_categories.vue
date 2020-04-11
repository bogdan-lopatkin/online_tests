<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 skv-heading">
                <h1>Протестируйте себя!</h1>
                <p>Выберите один из 9999+ тестов и проверьте свои знания.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="search-form">
                            <div class="search-wrapper">
                            <input type="search" class="search-field form-control is_search" placeholder="Поиск теста" v-model="search_for"  title="Поиск теста">
                            <i class="fa fa-times clear-search-input"></i>
                        </div>
                        <input @click="searchFor" type="button" class="search-submit btn btn-primary" value="Найти">
                </div>
            </div>
        </div>


        <div class="courses row">
            <div v-for="category in testCategories" class="course-wrapper col-lg-4 col-md-6 col-sm-12">
                <article class="course-item">
                    <div class="course-item__grouped">
                        <div class="course-item__details">
                            <h1> {{ category.category['name'] }}   </h1>

                            <small>
                                Уровень: от {{ difficulty[category.minDifficulty] }}
                                до {{ difficulty[category.maxDifficulty] }}
                            </small>

                        </div>
                        <div class="course-item__level">
                            <h5>{{ category.total }}</h5>
                            <small class="mb-3">тестов</small>
                        </div>
                        <router-link :to="{ name: 'tests', params: { categoryId: category.category_id } }" class="btn btn-medium btn-primary">
                        <i class="fa fa-chevron-circle-right">
                        </i>Перейти к тестам
                        </router-link>
                    </div>
                </article>
            </div>
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
                testCategories : [],
                difficulty : [],
                search_for : ''
            }
        },
         computed :{

        },
        methods : {
            fetchData() {
                this.error = this.users = null;
                this.loading = true;
                axios
                    .get(routes.tests)
                    .then(response => {
                        console.log(response);
                        this.testCategories = response.data.testCategories;
                        this.difficulty = response.data.difficulty;
                    });
            },
            searchFor()
            {
                if(this.search_for.length)
                    this.$router.push({ name: 'tests', params: { categoryId: '0'}, query: { s: this.search_for } });
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
        }
    }
</script>
