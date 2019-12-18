<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step col-xs-3">
                    <router-link to="" type="button" class="btn btn-default btn-circle" disabled="disabled">1
                    </router-link>
                    <p><small>ثبت تیم</small></p>
                </div>
                <div class="stepwizard-step col-xs-3">
                    <router-link :to="`/teams/${$route.params.id}/work-sample`" type="button"
                                 class="btn btn-default btn-circle" disabled="disabled">2
                    </router-link>
                    <p><small>نمونه کار</small></p>
                </div>
                <div class="stepwizard-step col-xs-3">
                    <router-link :to="`/teams/${$route.params.id}/member`" type="button"
                                 class="btn btn-circle btn-default btn-success" >3
                    </router-link>
                    <p><small>اعضا</small></p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="firstname">نام</label>
                        <input class="form-control form-control-sm" type="text" id="firstname"
                               placeholder="نام اینجا وارد نمایید."
                               v-model="form.firstname">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="lastname">نام خانوادگی</label>
                        <input class="form-control form-control-sm" type="text" id="lastname"
                               placeholder="نام خانوادگی اینجا وارد نمایید."
                               v-model="form.lastname">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control form-control-sm" type="text" id="description"
                                  placeholder="توضیحات اینجا وارد نمایید."
                                  v-model="form.description"></textarea>
                    </div>
                </div>
                <div class="col-md-12 text-right mt-3 mb-3">
                    <div class="form-group">
                        <cropper-portlet v-model="form.profile_image" title="تصویر شاخص" place="right"/>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <div class="form-group">
                        <submit-button @click="handleSubmit"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3" :key=index v-for="(member,index) in members">
                    <div class="card box-shadow">
                        <div class="card-body">
                            <div class="text-right">
                                <i class="fa fa-window-close" title="حذف"
                                   @click="handleDelete(member.id)"></i>
                                <i class="fa fa-edit" title="حذف"
                                   @click="handleUpdate(member.id)"></i>
                            </div>
                            <img style="cursor: pointer;max-width: 100%" @click="handleUpdate(member.id)"
                                 :src=member.profile_image :alt=member.id>
                            <h4 class="text-center mt-4">{{member.firstname}} {{member.lastname}}</h4>
                        </div>
                        <div class="card-footer">
                            <p class="text-justify">
                                {{member.description}}
                            </p>
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
                members: [],
                member_id: 0,
                reset_form: false,
            }
        },
        created() {
            this.form = {
                firstname: '',
                lastname: '',
                description: ''
            };
            this.getMemberList();
        },
        methods: {
            handleSubmit() {
                if (this.member_id === 0) {
                    axios.post(`/teams/${this.$route.params.id}/member`, this.form)
                        .then(response => {
                            this.successNotify(response.data.message);
                            this.getMemberList();
                            this.form = {
                                firstname: '',
                                lastname: '',
                                description: '',

                            };
                        }).catch(error => {
                        this.errorNotify(error.response.data.message);
                    })
                } else {
                    axios.put(`/teams/member/${this.member_id}`, this.form)
                        .then(response => {
                            this.successNotify(response.data.message);
                            this.getMemberList();
                            this.form = {
                                firstname: '',
                                lastname: '',
                                description: '',
                            };
                            this.member_id = 0;
                        }).catch(error => {
                        this.errorNotify(error.response.data.message)
                    })
                }

            },
            afterFetchItem(response) {
                this.team = response.data;
                this.members = response.data.tmembers;
                this.breadcrumb = [
                    {title: 'تیم ها', to: '/teams'},
                    {title: this.team.title, to: `/teams/${this.team.id}/member`},
                ];
            },
            getMemberList() {
                axios.get(`/teams/member-list/${this.$route.params.id}`)
                    .then(response => {
                        this.afterFetchItem(response);
                    })
                    .catch(error => this.errorNotify(error.response.data.message));
            },
            handleUpdate(id) {
                window.scrollTo(0, 0);
                this.member_id = id;
                this.reset_form = true;
                axios.get(`/teams/member/${id}`).then(response => {
                    this.form = response.data;
                }).catch(error => this.errorNotify(error.response.data.message));
            },
            handleDelete(id) {
                this.deleteConfirm()
                    .then(confirm => {
                        if (confirm) {
                            axios.delete(`/teams/member/${id}`).then(response => {
                                this.successNotify(response.data.message);
                                this.getMemberList();
                            }).catch(error => this.errorNotify(error.response.data.message));
                        }
                    })
                    .catch(error => this.errorNotify(error.response.data.message));
            },
            handleDeleteFile(id, file) {
                this.deleteConfirm()
                    .then(confirm => {
                        if (confirm) {
                            axios.delete(`/teams/member/single/${id}?file=${file}`).then(response => {
                                this.successNotify(response.data.message);
                                this.getMemberList();
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
                    firstname: '',
                    lastname: '',
                    description: '',
                };
                this.reset_form = false;
                window.scrollTo(0, 0);
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
        color:#666;
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
        opacity:1 !important;
        color:#bbb;
    }
    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content:" ";
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
