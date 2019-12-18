<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <add-button :href="`project/create`"/>
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
                            <td>{{project.title}}</td>
                            <td>{{project.start_date}}</td>
                            <td>{{project.end_date}}</td>
                            <td>
                                <div class="btn-group">
                                    <router-link class="btn btn-xs btn-success" :to="`project/${project.id}/detail`">
                                        مشاهده
                                    </router-link>
                                    <router-link class="btn btn-xs btn-warning" :to="`project/${project.id}/edit`">
                                        ویرایش
                                    </router-link>
                                    <span @click="handleDelete(project.id)" class="btn btn-xs btn-danger">حذف</span>
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
                axios.get(`/companies/project/${this.$route.params.id}`).then(response => this.projects = response.data).catch(error => this.errorNotify(error.response.data.message));
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
