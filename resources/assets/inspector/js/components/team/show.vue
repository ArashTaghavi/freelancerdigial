<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        {{team.title}}
                    </span>
                    <a class="float-right" href="#" data-tool="card-collapse" data-toggle="tooltip" title=""
                       data-original-title="Collapse Card">
                        <em class="fa fa-minus text-black-50" @click="toggleClass($event,this)"></em>
                    </a>
                </div>
                <div class="card-wrapper collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div style="line-height: 35px" class="text-justify col-md-6" v-html="team.description">
                            </div>
                            <div class="col-md-6">
                                <a :href=team.profile_image>
                                    تصویر تیم
                                    <br>
                                    <img class="img-thumbnail" :src=team.profile_image :alt=team.profile_image>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        نمونه کار ها
                    </span>
                    <a class="float-right" href="#" data-tool="card-collapse" data-toggle="tooltip" title=""
                       data-original-title="Collapse Card">
                        <em class="fa fa-minus text-black-50" @click="toggleClass($event,this)"></em>
                    </a>
                </div>
                <div class="card-wrapper collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>توضیحات</th>
                                        <th>تصویر</th>
                                        <th>لینک</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="work_sample in work_samples">
                                        <td>{{work_sample.title}}</td>
                                        <td v-html="work_sample.description"></td>
                                        <td>
                                            <a :href=work_sample.profile_image target="_blank">
                                                <img :src=work_sample.profile_image :alt=work_sample.profile_image
                                                     style="width: 100%;max-width:200px">
                                            </a>
                                        </td>
                                        <td>
                                            <a :href=work_sample.link>مشاهده</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        اعضا تیم
                    </span>
                    <a class="float-right" href="#" data-tool="card-collapse" data-toggle="tooltip" title=""
                       data-original-title="Collapse Card">
                        <em class="fa fa-minus text-black-50" @click="toggleClass($event,this)"></em>
                    </a>
                </div>
                <div class="card-wrapper collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>نام و نام خانوادگی</th>
                                        <th>توضیحات</th>
                                        <th>تصویر</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="member in members">
                                        <td>{{member.firstname}} {{member.lastname}}</td>
                                        <td v-html="member.description"></td>
                                        <td>
                                            <img :src=member.profile_image :alt=member.profile_image
                                                 style="width: 100%;max-width:200px">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12 card-body bg-gray">
                    <h3 class="text-center">فرم ارزیابی تیم</h3>
                    <div class="form-group">
                        <label for="description">توضیحات</label>
                        <textarea rows="10" class="form-control form-control-sm" type="text" id="description"
                                  placeholder="توضیحات خود را اینجا وارد نمایید."
                                  v-model="form.description">
                        </textarea>
                    </div>
                    <div class="form-group" :key=index v-for="(assessment,index) in assessments">
                        <label :for="`star${assessment.id}`">{{assessment.title}}</label>
                        <select name="" :id="`star${assessment.id}`" v-model="form.scores[assessment.id]"
                                class="form-control">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <submit-button @click="handleSubmit()"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            CKEDITOR.replace('description', {
                extraPlugins: 'cloudservices',
                language: 'fa',
                height: 300,
                toolbarCanCollapse: true
            });

        },
        data() {
            return {
                team: [],
                review: [],
                work_samples: [],
                members: [],
                assessments: [],
            }
        },
        created() {
            this.form = {
                description: '',
                scores: {},
            };
            axios.get(`teams/${this.$route.params.id}`)
                .then(response => {
                    this.afterFetchItem(response);
                })
                .catch(error => this.errorNotify(error.response.data.message));
            axios.get(`/teams/assessment/list`).then(response => {
                this.assessments = response.data;
            })
                .catch(error => this.errorNotify(error.response.data.message));

        },
        methods: {
            handleSubmit() {
                this.form.description = CKEDITOR.instances.description.getData();
                axios.post(`/teams/store-review/${this.$route.params.id}`, this.form).then(response => {
                    this.successNotify(response.data.message);
                    this.$router.push('/teams');
                }).catch(error => {
                    this.errorNotify(error.response.data.message);
                });
            },
            afterFetchItem(response) {
                this.team = response.data;
                this.work_samples = response.data.twork_samples;
                this.members = response.data.tmembers;
                let _description = '';
                if (response.data.treviewed != null) {
                    _description = response.data.treviewed.description;
                    response.data.treviewed.details.forEach(item => {
                        this.form.scores[item.type] = item.score;
                    });
                }
                this.form.description = CKEDITOR.instances.description.setData(_description);
                this.breadcrumb = [
                    {title: 'تیم ها', to: '/teams'},
                    {title: this.team.title, to: `/teams/${this.team.id}/show`}
                ];
            },
            toggleClass(e,tag) {
                e.preventDefault();
                $(tag).toggleClass('fa-minus').toggleClass('fa-plus');
            }
        },
    }
</script>
<style scoped>
    th, td {
        text-align: center !important;
    }
</style>
