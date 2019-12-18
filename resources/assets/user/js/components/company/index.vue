<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <loading v-if="this.loading"/>
        <div class="card-body">
            <add-button href="/companies/create"/>
            <div class="row" v-if="companies.length>0">
                <div class="col-md-6" v-for="company in companies">
                    <div class="card box-shadow">
                        <div class="card-header bg-success">
                            <div class="row">
                                <div class="col-md-6">
                                    <router-link :to="`/companies/${company.id}/edit`" style="color: #fff">
                                        <h3 class="card-title">
                                            {{company.title}}
                                        </h3>
                                    </router-link>
                                </div>
                                <div class="col-md-6 text-right">
                                    <router-link title="مدارک" :to="`/companies/${company.id}/attachment`"
                                                 class="text-white">
                                        <i class="fa fa-file-alt"></i>
                                    </router-link>
                                    <router-link title="نمونه کارها" :to="`/companies/${company.id}/work-sample`"
                                                 class="text-white">
                                        <i class="fa fa-folder"></i>
                                    </router-link>
                                    <router-link title="اعضا" :to="`/companies/${company.id}/member`"
                                                 class="text-white">
                                        <i class="fa fa-users"></i>
                                    </router-link>
                                    <i class="fa fa-window-close" title="حذف" @click="handleDelete(company.id)"></i>

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8" v-html=company.description.substr(0,200)>
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
                                    <span v-if="company.reviewed !==null ">
                                        <span :class="getClass(company.reviewed.star,1)" class="fa fa-star"></span>
                                        <span :class="getClass(company.reviewed.star,2)" class="fa fa-star"></span>
                                        <span :class="getClass(company.reviewed.star,3)" class="fa fa-star"></span>
                                        <span :class="getClass(company.reviewed.star,4)" class="fa fa-star"></span>
                                        <span :class="getClass(company.reviewed.star,5)" class="fa fa-star"></span>

                                    <router-link :to="`/companies/${company.id}/review`">جزییات</router-link>
                                    </span>
                                    <span v-else class="badge badge-danger">بررسی نشده</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <router-link title="پروژه ها" :to="`/companies/${company.id}/reserved-project`"
                                                 class="text-white btn btn-xs btn-success">
                                        پروژه ها دریافتی

                                    </router-link>
                                    <router-link title="پروژه ها" :to="`/companies/${company.id}/project`"
                                                 class="text-white btn btn-xs btn-info">
                                        پروژه های ارسالی


                                    </router-link>
                                    <!--<span class="badge badge-green">
                                                   {{jdate(company.created_at)}}
                                               <i class="zmdi zmdi-calendar"></i>
                                              </span>-->
                                </div>
                            </div>
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
                companies: []
            }
        },
        methods: {
            getCompanyList() {
                axios.get('/companies').then(response => {
                    this.companies = response.data;
                    this.loading = false;
                }).catch(error => this.errorNotify(error.response.data.message));

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
                            }).catch(error => this.errorNotify(error.response.data.message));
                        }
                    })
                    .catch(error => this.errorNotify(error.response.data.message));

            },
            afterDeleteItem(response) {

            },
            getClass(value, num) {
                value = parseFloat(value);
                if (value >= 1 && num === 1) {
                    return 'checked';
                }

                if (value >= 2 && num === 2) {
                    return 'checked';
                }
                if (value >= 3 && num === 3) {
                    return 'checked';
                }
                if (value >= 4 && num === 4) {
                    return 'checked';
                }
                if (value >= 5 && num === 5) {
                    return 'checked';
                }
            },
        },
        created() {
            this.getCompanyList();

        },
    }
</script>
<style scoped>
    .checked {
        color: orange;
    }
</style>
