<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6" v-for="company in companies">
                    <div class="card box-shadow">
                        <div class="card-header bg-success">
                            <a :href="`/inspector-panel#/companies/${company.id}/show`" style="color: #fff">
                                <h3 class="card-title">
                                    {{company.title}}
                                </h3>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8" v-html=company.description.substr(0,100)>
                                </div>
                                <div class="col-md-4">
                                    <img class="img-thumbnail" :src=company.profile_image :alt="`profile-${company.id}`"
                                         width="100%">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-secondary">
                            <div class="row">
                                <div class="col-md-6 text-left">
                                    امتیاز:
                                    <span v-if="company.reviewed !==null ">{{company.reviewed.star}}</span>
                                    <span v-else class="badge badge-danger">بررسی نشده</span>
                                </div>
                                <div class="col-md-6 text-right">
                                 <span class="badge badge-green">
                                                {{jdate(company.created_at)}}
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
</template>

<script>
    export default {
        data() {
            return {
                companies: []
            }
        },
        methods: {
            getCompanyList() {
                axios.get('/companies')
                    .then(response => this.companies = response.data)
                    .catch(error => this.errorNotify(error.message));
            },
            jdate(date) {
                return moment(date).format('jYYYY/jM/jD');
            },
            handleDelete(id) {
                this.deleteConfirm()
                    .then(confirm => {
                        if (confirm) {
                            axios.delete(`/companies/${id}`).then(response => {
                                this.getCompanyList();
                                this.successNotify(response.data.message);
                            }).catch(error => console.log(error));
                        }
                    })
                    .catch(error => this.errorNotify(error));

            },
            afterDeleteItem(response) {

            }
        },
        created() {
            this.getCompanyList()
        },
    }
</script>
