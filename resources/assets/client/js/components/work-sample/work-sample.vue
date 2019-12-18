<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">عنوان</label>
                        <input type="text" v-model="form.title" placeholder="عنوان را اینجا وارد نمایید."
                               class="form-control form-control-sm" id="title">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="link">لینک</label>
                        <input type="text" v-model="form.link" placeholder="لینک را اینجا وارد نمایید."
                               class="form-control form-control-sm" id="link">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <br>
                        <label for="description">توضیحات</label>
                        <textarea rows="12" class="form-control form-control-sm" type="text" id="description"
                                  placeholder="توضیحات خود را اینجا وارد نمایید."
                                  v-model="form.description">
                        </textarea>
                    </div>
                </div>
                <div class="col-md-6 text-right mt-3">
                    <div class="form-group text-left">
                        <label for="drop1">فایل های پیوست</label>
                        <vue-dropzone placeholder="sd" id="drop1" :options="dropOptions"></vue-dropzone>
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
                <div class="col-md-12">
                    <div class="card card-default" id="cardDemo1">
                        <div class="card-header">نمونه کارها
                            <a class="float-right" data-tool="card-collapse" data-toggle="tooltip" title=""
                               data-original-title="Collapse Card">
                                <em @click="toggle" class="fa fa-plus"></em>
                            </a>
                        </div>
                        <div class="card-wrapper collapse" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6" v-for="(work_sample,index) in work_samples">
                                        <div class="card box-shadow" :key="index">
                                            <div class="card-header bg-primary">
                                                <div class="row">
                                                    <div class="col-md-6 text-left">
                                                        <h3 class="card-title">
                                                            {{work_sample.title}}
                                                        </h3>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <i class="fa fa-edit" title="ویرایش"
                                                           @click="handleUpdate(work_sample.id)"></i>
                                                        <i class="fa fa-window-close" title="حذف"
                                                           @click="handleDelete(work_sample.id)"></i>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12"
                                                         v-html="work_sample.description.substr(0,100)"></div>
                                                    <hr>
                                                    <div class="col-md-12" style="overflow: auto">
                                                        <div class="btn-group">
                                                            <a class="btn btn-xs btn-purple" target="_blank"
                                                               v-if="work_sample.profile_image!=null"
                                                               v-for="(file,index) in JSON.parse(work_sample.profile_image)"
                                                               :href=file>
                                                                پیوست {{index+1}}
                                                            </a>
                                                        </div>
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
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                work_samples: [],
                work_sample_id: 0,
                reset_form: false,
                dropOptions: {
                    url: `/api/client/work-sample/upload-introduction`,
                    maxFilesize: 2 * 1024, // MB
                    thumbnailWidth: 150, // px
                    thumbnailHeight: 150,
                    addRemoveLinks: true,
                    progress: true,
                    dictDefaultMessage: 'فایل های خود را اینجا قرار دهید.',
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
                if (this.work_sample_id === 0) {
                    axios.post(`/work-sample`, this.form)
                        .then(response => {
                            this.successNotify(response.data.message);
                            this.getWorkSampleList();
                        }).catch(error => {
                        this.errorNotify(error.response.data.message);
                    })
                } else {
                    axios.put(`/work-sample/${this.work_sample_id}`, this.form)
                        .then(response => {
                            this.successNotify(response.data.message);
                            this.getWorkSampleList();
                            this.form = {
                                title: '',
                                description: ''
                            };
                        }).catch(error => {
                        this.errorNotify(error.response.data.message);
                    });
                    this.work_sample_id = 0;
                }

            },
            afterFetchItem(response) {
                this.work_samples = response.data;
                this.reset_form = false;

                this.breadcrumb = [
                    {title: 'نمونه کارها', to: '/work-sample'},
                    //{title: this.company.title, to: `/work-sample/${this.company.id}/work-sample`},
                ];
            },
            getWorkSampleList() {
                axios.get(`/work-sample`)
                    .then(response => {
                        this.afterFetchItem(response)
                    })
                    .catch(error => this.errorNotify(error.message));
            },
            handleUpdate(id) {
                window.scrollTo(0, 0);
                this.work_sample_id = id;
                this.reset_form = true;
                axios.get(`/work-sample/${id}`).then(response => {
                    this.form = response.data;
                }).catch(error => this.errorNotify(error.response.data.message));
            },
            handleDelete(id) {
                this.deleteConfirm()
                    .then(confirm => {
                        if (confirm) {
                            axios.delete(`/work-sample/${id}`).then(response => {
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
                this.form.title = '';
                this.form.description = '';
                this.form.link = '';
                this.reset_form = false;
                window.scrollTo(0, 0);
            },
            toggle(){
                  $('em').toggleClass('fa-plus').toggleClass('fa-minus');
            }
        }
    }
</script>
<style>
    .bootstrap-select.btn-group .dropdown-toggle .filter-option {
        text-align: right !important;
    }
    .zmdi-edit , em{
        cursor: pointer;
    }
</style>
