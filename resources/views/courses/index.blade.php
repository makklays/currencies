@extends('layouts.main')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/') }}"><i class="fa fa-home" aria-hidden="true"></i> Currencies</a></li>
            <li class="breadcrumb-item">View courses from DB</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center text-design2">View courses</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <!-- courses -->
            <div class="div-course">
                <div class="div-title">ID</div>
                <div class="div-title">Send currency</div>
                <div class="div-title">Recive currency</div>
                <div class="div-title">Send course</div>
                <div class="div-title">Recive course</div>
            </div>

            <div v-if="loading" class="loading">Loading... </div>

            <list-course
                v-for="(item, index) in courses"
                v-bind:id="item.id"
                v-bind:send_currency="item.send_currency"
                v-bind:recive_currency="item.recive_currency"
                v-bind:send_course="item.send_course"
                v-bind:recive_course="item.recive_course"
            ></list-course>

            <br/><br/>

            <!-- pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <button class="page-link" v-if="page != 1" v-on:click="newValues(1)">1</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link" v-if="page != 1" v-on:click="newValues(Math.ceil(page) - 1)" >prev</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link" v-if="Math.ceil(page - 2) > 1" v-on:click="newValues(Math.ceil(page - 2))" >@{{ Math.ceil(page - 2) }}</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link" v-if="Math.ceil(page - 1) > 1" v-on:click="newValues(Math.ceil(page - 1))" >@{{ Math.ceil(page - 1) }}</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link active" v-on:click="newValues( Math.ceil(page) )">@{{ Math.ceil(page) }}</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link" v-if="(Math.ceil(page) + 1) < pages" v-on:click="newValues(Math.ceil(page) + 1)" >@{{ Math.ceil(page) + 1 }}</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link" v-if="(Math.ceil(page) + 2) < pages" v-on:click="newValues(Math.ceil(page) + 2)" >@{{ Math.ceil(page) + 2 }}</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link" v-if="Math.ceil(page) + 1 <= pages" v-on:click="newValues(Math.ceil(page) + 1)" >next</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link" v-if="Math.ceil(page) + 1 <= pages" v-on:click="newValues(pages)" >@{{ pages }}</button>
                    </li>
                </ul>
            </nav>

            <br/><br/><br/>

        </div>
    </div>

@endsection

@section('scripts')

    <style>
        .div-title {
            width: 150px;
            text-align: center;
            font-weight: bold;
            border-bottom: 2px solid #dee2e6;
            padding: .75rem;
            border-top: 1px solid #dee2e6;
        }
        .div-value {
            width: 150px;
            text-align: center;
            padding: .5rem .5rem;
            border-bottom: 1px solid #dee2e6;
        }
        .loading {
            width: 600px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }
        .div-course {
            display: flex;
            box-sizing: border-box;
        }
        button.page-link, a.page-link {
            display: inline-block;
        }
        button.page-link, a.page-link {
            font-size: 20px;
            color: #29b3ed;
            font-weight: 500;
        }
        button.page-link.active, a.page-link.active {
            background-color: cadetblue;
            color: #FFFFFF;
        }
    </style>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script>
        Vue.component('list-course', {
            props: ['id', 'send_currency', 'recive_currency', 'send_course', 'recive_course'],
            template: `<div class="div-course">
                           <div class="div-value">#@{{ id }}</div>
                           <div class="div-value">@{{ send_currency }}</div>
                           <div class="div-value">@{{ recive_currency }}</div>
                           <div class="div-value">@{{ send_course | ff }}</div>
                           <div class="div-value">@{{ recive_course | ff }}</div>
                       </div>`,
            filters: {
                ff (value) {
                    if (value == 1) return value;
                    return new Number(value).toFixed(4);
                },
            },
        });

        var app = new Vue({
            el: '#app',
            data: {
                loading: true,
                courses: null,
                page: 1,
                pages: 1,
            },
            mounted() {
                axios.request({
                    method: 'get',
                    baseURL: 'http://currencies/api/courses',
                    params: {
                        page: new URL(location.href).searchParams.get('page'),
                        // answer: { toJSON: () => 42 },
                        // time: moment('2016-06-01')
                    },
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer $2y$10$AJnzvQAXE.zdvbdDIMHNpe/RPFAvwB9VDtDSuMB5dUcgGcDGaSZoG',
                    }
                })
                .then(response => {
                    console.log(response.data.data);
                    this.courses = response.data.data;
                    this.page = response.data.current_page;
                    // console.log(response.data.current_page);
                    // console.log(Math.ceil(response.data.last_page));
                    this.pages = response.data.last_page;
                })
                .catch((error) => {
                    console.log(error)
                })
                .finally(() => (this.loading = false));
            },
            // filters: {
            //     ff (value) {
            //         if (!value) return ''
            //         value = value.toNumber();
            //         return value.toFixed(2);
            //     },
            // },
            methods: {
                getScore(val) {
                    return val.toFixed(2);
                },
                newValues(newPage) {
                    axios.request({
                            method: 'get',
                            baseURL: 'http://currencies/api/courses',
                            params: {
                                page: newPage,
                                // answer: { toJSON: () => 42 },
                                // time: moment('2016-06-01')
                            },
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': 'Bearer $2y$10$AJnzvQAXE.zdvbdDIMHNpe/RPFAvwB9VDtDSuMB5dUcgGcDGaSZoG',
                            }
                        })
                        .then(response => {
                            console.log(response.data.data);
                            this.courses = response.data.data;
                            this.page = response.data.current_page;
                            // console.log(response.data.current_page);
                            // console.log(Math.ceil(response.data.last_page));
                            this.pages = response.data.last_page;

                            history.pushState({}, null, 'http://currencies/courses?page=' + newPage);

                        })
                        .catch((error) => {
                            console.log(error)
                        })
                        .finally(() => (this.loading = false));
                },
            },
            watch: {
                courses() {
                    // console.log(this.$route.query);
                    // console.log(new URL(location.href).searchParams.get('page'));
                    if (new URL(location.href).searchParams.get('page') != null) {
                        this.page = new URL(location.href).searchParams.get('page');
                    }
                }
            },
        });
    </script>

@endsection
