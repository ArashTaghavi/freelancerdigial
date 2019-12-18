<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body">
            <div class="row" v-if="projects.length>0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <td>عنوان</td>
                            <td>تاریخ شروع</td>
                            <td>تاریخ پایان</td>
                            <td>عملیات</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="project in projects">
                            <td>{{project.project.title}}</td>
                            <td>{{project.project.start_date}}</td>
                            <td>{{project.project.end_date}}</td>
                            <td>
                                <div class="btn-group">
                                    <router-link class="btn btn-xs btn-success" :to="`reserved-project/${project.project.id}/detail`">
                                        مشاهده
                                    </router-link>
                                    <span @click="handleDelete(project.project.id)" class="btn btn-xs btn-danger">حذف</span>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
            getProjectList() {
                axios.get(`/teams/reserved-project/${this.$route.params.id}`).then(response => this.projects = response.data).catch(error => this.errorNotify(error.response.data.message));
            },
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
                    .catch(error => this.errorNotify(error.response.data.message));

            },
            afterDeleteItem(response) {

            },
        },
        created() {
            this.getProjectList();
        },
    }
</script>
<style scoped>
    th, td {
        text-align: center;
    }
</style>
