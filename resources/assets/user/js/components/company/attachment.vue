<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <loading v-if="this.loading"/>
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step col-xs-3">
                    <a href="#step-1" type="button" class="btn btn-circle btn-default" disabled="disabled">1</a>
                    <p>
                        <small>ثبت شرکت</small>
                    </p>
                </div>
                <div class="stepwizard-step col-xs-3">
                    <router-link :to="`/companies/${$route.params.id}/attachment`" type="button"
                                 class="btn btn-default btn-circle btn-success">2
                    </router-link>
                    <p>
                        <small>مدارک</small>
                    </p>
                </div>
                <div class="stepwizard-step col-xs-3">
                    <router-link :to="`/companies/${$route.params.id}/work-sample`" type="button"
                                 class="btn btn-default btn-circle" disabled="disabled">3
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
                <div class="col-md-4 offset-4">
                    <div class="form-group">
                        <label for="title">عنوان</label>
                        <select class="form-control" name=""
                                title="نوع مدرک" v-model="form.type" id="type">
                            <option :value=attachment_type.id v-for="attachment_type in attachments_type">
                                {{attachment_type.title}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">توضیحات</label>
                        <textarea rows="12" class="form-control form-control-sm" type="text" id="description"
                                  placeholder="توضیحات خود را اینجا وارد نمایید."
                                  v-model="form.description">
                        </textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="drop1">فایل پیوست</label>
                    <vue-dropzone id="drop1" :options="dropOptions"></vue-dropzone>
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
                        <div class="col-md-6" v-for="(attachment,index) in attachments">
                            <div class="card box-shadow" :key="index">
                                <div class="card-header bg-primary">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            <h3 class="card-title" style="cursor: pointer"
                                                @click="handleUpdate(attachment.id)">
                                                {{attachment.title}}
                                            </h3>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <i class="zmdi zmdi-close" title="حذف"
                                               @click="handleDelete(attachment.id)"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12" v-html=attachment.description.substr(0,100)>
                                        </div>
                                        <div class="col-md-12">
                                            <span class="text-muted">پیوست ها: </span>
                                            <a class="badge badge-purple mr-2" :href=file
                                               v-for="(file,index) in JSON.parse(attachment.attachment)">
                                                <span>
                                                    <i class="zmdi zmdi-download"></i>
                                                    پیوست
                                                {{index +1}}
                                                </span>
                                                <span class="ml-5"
                                                      @click.prevent="handleDeleteFile(attachment.id,file)">
                                                    <i class="zmdi zmdi-close"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-secondary">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                           <span class="badge badge-green">
                                                {{jdate(attachment.created_at)}}
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
                attachments: [],
                attachments_type: [],
                company: [],
                attachment_id: 0,
                reset_form: false,
                dropOptions: {
                    url: `/api/user/companies/upload-attachment/${this.$route.params.id}`,
                    maxFilesize: 2 * 1024, // MB
                    maxFiles: 5,
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
                description: ''
            };
            this.getAttachmentList();
            axios.get('/companies/attachments/type').then(response => this.attachments_type = response.data)
                .catch(error => this.errorNotify(error.response.data.message));
        },
        methods: {
            handleSubmit() {
                this.loading = true;
                if (this.attachment_id === 0) {
                    axios.post(`/companies/${this.$route.params.id}/attachment`, this.form)
                        .then(response => this.nextStep(response)).catch(error => this.errorNotify(error.response.data.message));
                } else {
                    axios.put(`/companies/attachment/${this.attachment_id}`, this.form)
                        .then(response => {
                            this.loading = false;
                            this.successNotify(response.data.message);
                            this.getAttachmentList();
                            this.form = {
                                title: '',
                                description: ''
                            };
                        }).catch(error => this.errorNotify(error.response.data.message));
                }
                this.attachment_id = 0;
            },
            afterFetchItem(response) {
                this.company = response.data;
                this.attachments = response.data.attachments;
                this.breadcrumb = [
                    {title: 'شرکت ها', to: '/companies'},
                    {title: this.company.title, to: `/companies/${this.company.id}/attachment`},
                ];
                this.loading = false;

            },
            getAttachmentList() {
                axios.get(`/companies/attachment-list/${this.$route.params.id}`)
                    .then(response => {
                        this.afterFetchItem(response);
                    })
                    .catch(error => this.errorNotify(error.response.data.message));
            },
            handleUpdate(id) {
                this.loading = true;
                window.scrollTo(0, 0);
                this.attachment_id = id;
                this.reset_form = true;
                axios.get(`/companies/attachment/${id}`).then(response => {
                    this.form = response.data;
                    this.loading = false;
                }).catch(error => this.errorNotify(error.response.data.message));
            },
            handleDelete(id) {
                this.deleteConfirm()
                    .then(confirm => {
                        if (confirm) {
                            axios.delete(`/companies/attachment/${id}`).then(response => {
                                this.successNotify(response.data.message);
                                this.getAttachmentList();
                            }).catch(error => this.errorNotify(error.response.data.message));
                        }
                    })
                    .catch(error => this.errorNotify(error.response.data.message));
            },
            handleDeleteFile(id, file) {
                this.deleteConfirm()
                    .then(confirm => {
                        if (confirm) {
                            axios.delete(`/companies/attachment/single/${id}?file=${file}`).then(response => {
                                this.successNotify(response.data.message);
                                this.getAttachmentList();
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
            nextStep(response) {
                this.loading = false;
                if (response.data.next === false) {
                    this.successNotify(response.data.message);
                    this.getAttachmentList();
                    this.form = {
                        title: '',
                        description: ''
                    };
                } else {
                    this.successNotify(response.data.message);
                    this.$router.push(`/companies/${this.$route.params.id}/work-sample`)
                }
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
