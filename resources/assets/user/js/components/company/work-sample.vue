<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step col-xs-3">
                    <router-link to="" type="button" class="btn btn-default btn-circle" disabled="disabled">1
                    </router-link>
                    <p>
                        <small>ثبت شرکت</small>
                    </p>
                </div>
                <div class="stepwizard-step col-xs-3">
                    <router-link :to="`/companies/${$route.params.id}/attachment`" type="button"
                                 class="btn btn-default btn-circle" disabled="disabled">2
                    </router-link>
                    <p>
                        <small>مدارک</small>
                    </p>
                </div>
                <div class="stepwizard-step col-xs-3">
                    <router-link :to="`/companies/${$route.params.id}/work-sample`" type="button"
                                 class="btn btn-circle btn-default btn-success">3
                    </router-link>
                    <p>
                        <small>نمونه کار</small>
                    </p>
                </div>
                <div class="stepwizard-step col-xs-3">
                    <router-link :to="`/companies/${$route.params.id}/member`" type="button"
                                 class="btn btn-default btn-circle" disabled="disabled">4
                    </router-link>
                    <p>
                        <small>اعضا</small>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 offset-2">
                    <div class="form-group">
                        <label for="title">عنوان</label>
                        <input type="text" v-model="form.title" placeholder="عنوان را اینجا وارد نمایید."
                               class="form-control form-control-sm" id="title">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="link">لینک</label>
                        <input type="text" v-model="form.link" placeholder="لینک را اینجا وارد نمایید."
                               class="form-control form-control-sm" id="link">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">توضیحات</label>
                        <textarea rows="11" class="form-control form-control-sm" type="text" id="description"
                                  placeholder="توضیحات خود را اینجا وارد نمایید."
                                  v-model="form.description">
                        </textarea>
                    </div>
                </div>
                <div class="col-md-6 text-right mt-3">
                    <div class="form-group">
                        <cropper-portlet v-model="form.profile_image" title="تصویر شرکت" place="right"/>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <div class="form-group">
                        <submit-button @click="handleSubmit"/>
                        <button v-if="reset_form"
                                @click="handleReset()"
                                class="btn btn-sm btn-danger btn--icon">
                            <i class="zmdi zmdi-replay"></i>
                            بازنشانی
                        </button>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6" v-for="(work_sample,index) in work_samples">
                            <div class="card box-shadow" :key="index">
                                <div class="card-header bg-primary">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            <h3 class="card-title" style="cursor: pointer"
                                                @click="handleUpdate(work_sample.id)">
                                                {{work_sample.title}}
                                            </h3>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <i class="zmdi zmdi-close" title="حذف"
                                               @click="handleDelete(work_sample.id)"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8" v-html="work_sample.description.substr(0,100)"></div>
                                        <div class="col-md-4">
                                            <a class="" :href=work_sample.profile_image>
                                                <img :src="work_sample.profile_image" class="img-thumbnail"
                                                     :alt="work_sample_id">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-secondary">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            <a :href=work_sample.link>
                                                <i class="zmdi zmdi-calendar"></i>
                                                لینک نمونه کار
                                            </a>
                                        </div>
                                        <div class="col-md-6 text-right">
                                           <span class="badge badge-green">
                                                {{jdate(work_sample.created_at)}}
                                            <i class="zmdi zmdi-calendar"></i>
                                           </span>
                                        </div>
                                    </div>
                                </div>
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
        data() {
            return {
                work_samples: [],
                company: [],
                work_sample_id: 0,
                reset_form: false,
                dropOptions: {
                    url: `/api/user/companies/upload-introduction/${this.$route.params.id}`,
                    maxFilesize: 2 * 1024, // MB
                    maxFiles: 1,
                    thumbnailWidth: 150, // px
                    thumbnailHeight: 150,
                    addRemoveLinks: true,
                    progress: true,
                    headers: {
                        'X-CSRF-TOKEN': window.token
                    }
                }

            }
        },
        created() {
            this.form = {
                title: '',
                description: '',
                link: ''
            };
            this.getWorkSampleList();
        },
        methods: {
            handleSubmit() {
                this.loading = true;
                if (this.work_sample_id === 0) {
                    axios.post(`/companies/${this.$route.params.id}/work-sample`, this.form)
                        .then(response => this.checkChangeRoute(response)).catch(error => {
                        this.errorNotify(error.response.data.message);
                    })
                } else {
                    axios.put(`/companies/work-sample/${this.work_sample_id}`, this.form)
                        .then(response => {
                            this.successNotify(response.data.message);
                            this.getWorkSampleList();
                            this.form = {
                                title: '',
                                description: ''
                            };
                        }).catch(error => {
                        this.errorNotify(error.response.data.message);
                    })
                }

            },
            afterFetchItem(response) {
                this.company = response.data;
                this.work_samples = response.data.work_samples;
                this.reset_form = false;
                this.breadcrumb = [
                    {title: 'شرکت ها', to: '/companies'},
                    {title: this.company.title, to: `/companies/${this.company.id}/work-sample`},
                ];
            },
            getWorkSampleList() {
                axios.get(`/companies/work-sample-list/${this.$route.params.id}`)
                    .then(response => {
                        this.afterFetchItem(response);
                    })
                    .catch(error => this.errorNotify(error.message));
            },
            handleUpdate(id) {
                window.scrollTo(0, 0);
                this.work_sample_id = id;
                this.reset_form = true;
                axios.get(`/companies/work-sample/${id}`).then(response => {
                    this.form = response.data;
                }).catch(error => this.errorNotify(error.response.data.message));
            },
            handleDelete(id) {
                this.deleteConfirm()
                    .then(confirm => {
                        if (confirm) {
                            axios.delete(`/companies/work-sample/${id}`).then(response => {
                                this.successNotify(response.data.message);
                                this.getWorkSampleList();
                            }).catch(error => this.errorNotify(error.response.data.message));
                        }
                    })
                    .catch(error => this.errorNotify(error.response.data.message));
            },

            jdate(date) {
                return moment(date).format('jYYYY/jM/jD');
            },
            handleReset() {
                this.form = {
                    title: '',
                    description: ''
                };
                this.reset_form = false;
                window.scrollTo(0, 0);
            },
            checkChangeRoute(response) {
                this.loading = false;
                this.changeRouteConfirm(response.data.message)
                    .then(confirm => {
                        if (confirm) {
                            this.$router.push(`/companies/${this.$route.params.id}/member`)
                        }
                    });
                //this.successNotify(response.data.message);
                this.getWorkSampleList();
                this.form = {
                    title: '',
                };
            }
        }
    }
</script>
<style>
    .bootstrap-select.btn-group .dropdown-toggle .filter-option {
        text-align: right !important;
    }

    .stepwizard-step p {
        margin-top: 0px;
        color: #666;
    }

    .stepwizard-row {
        display: table-row;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        /*opacity: 1 !important;
        filter: alpha(opacity=100) !important;*/
    }

    .stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
        opacity: 1 !important;
        color: #bbb;
    }

    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-index: 0;
    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }
</style>
