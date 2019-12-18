<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body">
            <add-button href="/projects/create"/>
            <div class="row" v-if="projects.length>0">
                <div class="col-md-6" v-for="project in projects">
                    <div class="card box-shadow">
                        <div class="card-header bg-danger">
                            <div class="row">
                                <div class="col-md-6">
                                    <router-link :to="`/projects/${project.id}/edit`" style="color: #fff">
                                        <h3 class="card-title">
                                            {{project.title}}
                                        </h3>
                                    </router-link>
                                </div>
                                <div class="col-md-6 text-right">
                                    <router-link class="fa fa-edit" title="ویرایش"
                                                 :to="`/projects/${project.id}/edit`"></router-link>
                                    <i class="fa fa-window-close" title="حذف" @click="handleDelete(project.id)"></i>
                                    <router-link class="fa fa-eye" title="نمایش جزییات"
                                                 :to="`/projects/${project.id}/detail`"></router-link>

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12" v-html=project.description.substr(0,100)>
                                </div>
                                <div class="col-md-12" style="overflow: auto">
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-purple" target="_blank"
                                           v-if="project.profile_image!==null"
                                           v-for="(file,index) in JSON.parse(project.profile_image)"
                                           :href=file>
                                            پیوست {{index+1}}
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                         <span class="badge badge-green">
                             شروع
                                                {{project.start_date}}
                                            <i class="zmdi zmdi-calendar"></i>
                                           </span>
                            <span class="badge badge-green">
                             پایان
                                                {{project.end_date}}
                                            <i class="zmdi zmdi-calendar"></i>
                                           </span>
                            <span class="badge badge-purple">
                             حداقل
                                                {{project.min_price}}
                                            <i class="zmdi zmdi-money"></i>
                                           </span>
                            <span class="badge badge-purple">
                             حداکثر
                                                {{project.max_price}}
                                            <i class="zmdi zmdi-money"></i>
                                           </span>


                            <span class="btn btn-xs btn-success" v-if="project.status===1">
                                <i class="fa fa-check"></i>
                                تایید شده
                                           </span>
                            <span class="btn btn-xs btn-danger" v-if="project.status===2">
                                   <i class="fa fa-window-close"></i>
                                تایید نشده
                                           </span>
                            <span class="btn btn-xs btn-warning" v-if="project.status===3">
                                <i class="fa fa-question"></i>
                                در انتظار تایید
                                           </span>
                        </div>
                    </div>
                </div>

            </div>
            <not-found v-else/>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                projects: []
            }
        },
        methods: {
            jdate(date) {
                return moment(date).format('jYYYY/jM/jD');
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
            getProjectList() {
                axios.get('/projects')
                    .then(response => this.projects = response.data)
                    .catch(error => this.errorNotify(error.response.data.message));
            }
        },
        created() {
            return this.getProjectList()
        }
    }
</script>
