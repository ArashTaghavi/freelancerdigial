<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 offset-4">
                    <div class="form-group">
                        <label for="title">عنوان</label>
                        <input class="form-control form-control-sm" type="text" id="title"
                               placeholder="عنوان خود را اینجا وارد نمایید."
                               v-model="form.title">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">توضیحات</label>
                        <textarea rows="10" class="form-control form-control-sm" type="text" id="description"
                                  placeholder="توضیحات خود را اینجا وارد نمایید."
                                  v-model="form.description">
                        </textarea>
                    </div>
                </div>
                <div class="col-md-12">
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
                attachments: [],
                company: [],
                attachment_id: 0,
                reset_form: false,
                dropOptions: {
                    url: `/api/user/companies/upload-attachment/${this.$route.params.id}`,
                    maxFilesize: 2 * 1024, // MB
                    maxFiles: 5,
                    chunking: true,
                    chunkSize: 1024 * 1000, // Bytes
                    thumbnailWidth: 150, // px
                    thumbnailHeight: 150,
                    addRemoveLinks: true,
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
        },
        methods: {
            handleSubmit() {
                this.form.description = CKEDITOR.instances.description.getData();
                if (this.attachment_id === 0) {
                    axios.post(`/companies/${this.$route.params.id}/attachment`, this.form)
                        .then(response => {
                            this.successNotify(response.data.message);
                            this.getAttachmentList();
                            this.form = {
                                title: '',
                            };
                            CKEDITOR.instances.description.setData('');
                            this.attachment_id=0;
                        }).catch(error => {
                        this.errorNotify(error.message);
                    })
                } else {
                    axios.put(`/companies/attachment/${this.attachment_id}`, this.form)
                        .then(response => {
                            this.successNotify(response.data.message);
                            this.getAttachmentList();
                            this.form = {
                                title: '',
                            };
                            CKEDITOR.instances.description.setData('');
                        }).catch(error => {
                        console.log(error);
                    })
                }

            },
            afterFetchItem(response) {
                this.company = response.data;
                this.attachments = response.data.attachments;
                this.breadcrumb = [
                    {title: 'شرکت ها', to: '/companies'},
                    {title: this.company.title, to: `/companies/${this.company.id}/attachment`},
                ];
            },
            getAttachmentList() {
                axios.get(`/companies/attachment-list/${this.$route.params.id}`)
                    .then(response => {
                        this.afterFetchItem(response);
                    })
                    .catch(error => this.errorNotify(error.message));
            },
            handleUpdate(id) {
                window.scrollTo(0, 0);
                this.attachment_id = id;
                this.reset_form = true;
                axios.get(`/companies/attachment/${id}`).then(response => {
                    this.form = response.data;
                    CKEDITOR.instances.description.setData(this.form.description);
                }).catch(error => console.log(error));
            },
            handleDelete(id) {
                this.deleteConfirm()
                    .then(confirm => {
                        if (confirm) {
                            axios.delete(`/companies/attachment/${id}`).then(response => {
                                this.successNotify(response.data.message);
                                this.getAttachmentList();
                            }).catch(error => this.errorNotify(error));
                        }
                    })
                    .catch(error => this.errorNotify(error));
            },
            handleDeleteFile(id, file) {
                this.deleteConfirm()
                    .then(confirm => {
                        if (confirm) {
                            axios.delete(`/companies/attachment/single/${id}?file=${file}`).then(response => {
                                this.successNotify(response.data.message);
                                this.getAttachmentList();
                            }).catch(error => this.errorNotify(error));
                        }
                    })
                    .catch(error => this.errorNotify(error));
            },
            jdate(date) {
                return moment(date).format('jYYYY/jM/jD');
            },
            handleReset() {
                this.form.title = '';
                this.reset_form = false;
                window.scrollTo(0, 0);
                CKEDITOR.instances.description.setData('');
            }
        }
    }
</script>
