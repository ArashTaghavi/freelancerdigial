<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body" v-if="project">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">{{project.title}}</h3>
                    <hr>
                </div>
                <div class="col-md-12 text-justify pr-5 pl-5"
                     style="line-height: 35px"
                     v-html=project.description></div>
                <div class="col-md-12 mt-3">
                    <div class="card card-default" id="cardDemo1">
                        <div class="card-header">
                            <span class="dpt">جزییات پروژه</span>
                            <a class="float-right" href="#" data-tool="card-collapse" data-toggle="tooltip" title=""
                               data-original-title="Collapse Card">
                                <em @click="toggle" class="fa fa-plus"></em>
                            </a>
                        </div>
                        <div class="card-wrapper collapse" style="">
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <span class="text-bold">
                                                            <i class="fa fa-calendar"></i>
                                                            تاریخ شروع :
                                                        </span>
                                                        <span>{{project.start_date}}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <span class="text-bold">
                                                            <i class="fa fa-calendar"></i>
                                                            تاریخ پایان :
                                                        </span>
                                                        <span>{{project.end_date}}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <span class="text-bold">
                                                            <i class="fa fa-money-bill"></i>
                                                            حداقل قیمت :
                                                        </span>
                                                        <span>{{project.min_price}}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <span class="text-bold">
                                                            <i class="fa fa-money-bill"></i>
                                                            حداکثر قیمت :
                                                        </span>
                                                        <span>{{project.max_price}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <h4>نیازمندی های پروژه:</h4>
                                                <span class="badge badge-info mb-4 mr-1"
                                                      v-for="skill in project.skill">
                                                    {{skill}}
                                                </span>

                                                <h4>پیوست ها :</h4>
                                                <a :href=file class="badge badge-success mb-1 mr-1"
                                                   target="_blank"
                                                   v-for="(file,index) in project.profile_image">
                                                    پیوست {{index+1}}
                                                </a>

                                            </div>
                                            <div class="col-md-4">
                                                <img :src=functor.image class="rounded-circle" width="100%" alt="">
                                                <h4 class="text-center mt-3">
                                                    {{functor.title}}
                                                </h4>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- START card-->
                    <div class="card card-default" id="demo">
                        <div class="card-header">
                            <span class="dpt">گفتگو با کارفرما</span>
                            <a class="float-right" data-tool="card-collapse" data-toggle="tooltip" title=""
                               data-original-title="Collapse Card">
                                <em class="fa fa-plus"></em>
                            </a>
                        </div>
                        <div class="card-wrapper collapse">
                            <div class="card-body chat">
                                <div class="row p-3" v-for="message in messages">
                                    <div class="col-md-4 col-sm-6 me" v-if="message.sender_id===me">
                                        {{message.body}}
                                        <div style="cursor: pointer"
                                             class="text-center pd-2"
                                             v-if="message.attachment!==null"
                                             @click="handleDownloadAttachment(message.id)">
                                            {{showAttachmentIfImage(message.attachment)}}
                                            <a :href=message.attachment v-if="show_image">
                                                <img :src=message.attachment width="30%"
                                                     :alt=message.id>
                                            </a>
                                            <a target="_blank" :href=message.attachment v-else
                                               class="btn btn-xs btn-info">
                                                <i class="fa fa-download"></i>
                                                دانلود
                                            </a>
                                        </div>

                                        <p class="text-right" style="font-size: 10px">{{jdate(message.created_at)}}</p>
                                    </div>
                                    <div v-else class="col-md-4 col-sm-6 offset-md-8 offset-sm-6 you">
                                        {{message.body}}
                                        <div style="cursor: pointer"
                                             class="text-center pd-2"
                                             v-if="message.attachment!==null"
                                             @click="handleDownloadAttachment(message.id)">
                                            {{showAttachmentIfImage(message.attachment)}}
                                            <a :href=message.attachment v-if="show_image">
                                                <img :src=message.attachment width="30%"
                                                     :alt=message.id>
                                            </a>
                                            <a target="_blank" :href=message.attachment v-else
                                               class="btn btn-xs btn-info">
                                                <i class="fa fa-download"></i>
                                                دانلود
                                            </a>
                                        </div>
                                        <p class="text-right" style="font-size: 10px">{{jdate(message.created_at)}}</p>

                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <vue-dropzone id="drop1" :options="dropOptions"></vue-dropzone>
                                    </div>
                                    <textarea name="" v-model="form.body" class="form-control type_msg"
                                              placeholder=""></textarea>
                                    <div class="input-group-append">
                                        <span @click="handleSubmit" class="input-group-text send_btn"><i
                                                class="fas fa-location-arrow"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END card-->
                </div>
            </div>
        </div>
        <div class="card-body" v-else>
            <h3 class="alert alert-danger text-center">
                پروژه واگذار نشده است.
            </h3>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                project: [],
                functor: [],
                messages: [],
                me: window.user_id,
                show_image: false,
                dropOptions: {
                    url: `/api/user/messages/upload/file/d`,
                    maxFilesize: 2 * 1024, // MB
                    maxFiles: 5,
                    thumbnailWidth: 150, // px
                    thumbnailHeight: 150,
                    addRemoveLinks: true,
                    progress: true,
                    dictDefaultMessage: '<span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>',
                    dictRemoveFile: 'حذف',
                    headers: {
                        'X-CSRF-TOKEN': window.token
                    }
                }

            }
        },
        methods: {
            jdate(date) {
                return moment(date).format('jYYYY/jM/jD H:m:s');
            },
            handleDelete(id) {
                this.deleteConfirm()
                    .then(confirm => {
                        if (confirm) {
                            axios.delete(`/projects/${id}`).then(response => {
                                this.getProjectList();
                                this.successNotify(response.data.message);
                            }).catch(error => this.errorNotify(error.response.data.message));
                        }
                    })
                    .catch(error => this.errorNotify(error));
            },
            getProject() {
                axios.get(`/projects/reserved-for-company/${this.$route.params.id}/${this.$route.params.pid}`)
                    .then(response => this.afterFetchItem(response))
                    .catch(error => this.errorNotify(error.response.data.message));
            },
            afterFetchItem(response) {
                this.project = response.data.project;
                this.project.skill = JSON.parse(response.data.project.skill);
                this.project.profile_image = JSON.parse(response.data.project.profile_image);
                this.getFunctor(this.project);
                this.breadcrumb = [
                    {title: 'پروژه های دریافتی', to: '/projects'},
                    {title: this.project.title, to: ''}
                ]
            },
            getFunctor(project) {
                let id = project.id;
                axios.get(`/projects/get-reserved-functor/${id}`)
                    .then(response => this.functor = response.data)
                    .catch(error => this.errorNotify(error.response.data.message));
            },
            toggle() {
                $('em').toggleClass('fa-plus fa-minus');
            },
            getMessages() {
                axios.get(`/messages/get-by-project-id/${this.$route.params.pid}`)
                    .then(response => this.messages = response.data)
                    .catch(error => this.errorNotify(error.response.data.message))
            },
            handleSubmit() {
                axios.post(`/messages/${this.$route.params.pid}/${true}`, this.form).then(response => this.afterSendMessage())
                    .catch(error => this.errorNotify(error.response.data.message));
            },
            afterSendMessage() {
                this.getMessages();
                this.form = {
                    body: ''
                };
            },
            handleDownloadAttachment(id) {
                axios.get(`/messages/download/${id}`).then(response => {
                    //window.URL.createObjectURL(new Blob([response.data]))

                });
            },
            showAttachmentIfImage(attachment) {
                let split_attachment = attachment.split('/');
                let file_name = split_attachment[split_attachment.length - 1];
                let split_file_name = file_name.split('.');
                let extension = split_file_name[split_file_name.length - 1];
                let allow_extension = ['jpg', 'jpeg', 'gif', 'bmp'];
                extension = extension.toLowerCase();
                if (allow_extension.includes(extension))
                    this.show_image = true;
                else
                    this.show_image = false;
            }
        },
        created() {
            this.getMessages();
            setInterval(() => {
                this.getMessages();
            }, 1000);
            this.getProject();
        }
    }
</script>
<style>
    .chat {
        background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
        background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
        max-height: 500px;
        overflow: auto;
    }

    .me {
        background-color: #82ccdd;
        color: #000;
        padding: 5px 20px;
        border-radius: 10px;
    }

    .you {
        color: #000;
        padding: 5px 20px;
        border-radius: 10px;
        background-color: #78e08f;
    }

    .dropzone {
        padding: 0 !important;
    }

    .vue-dropzone {
        min-height: auto !important;
    }

    .dz-default.dz-message {
        margin: 0 !important;
    }

    .attach_btn {
        border-radius: 0 !important;
        height: 51px !important;
    }
</style>
