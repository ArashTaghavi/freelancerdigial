<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body">
            <add-button href="/teams/create"/>
            <div class="row" v-if="teams.length>0">
                <div class="col-md-6" v-for="team in teams">
                    <div class="card box-shadow">
                        <div class="card-header bg-success">
                            <div class="row">
                                <div class="col-md-6">
                                    <router-link :to="`/teams/${team.id}/edit`" style="color: #fff">
                                        <h3 class="card-title">
                                            {{team.title}}
                                        </h3>
                                    </router-link>
                                </div>
                                <div class="col-md-6 text-right">
                                    <router-link title="نمونه کارها" :to="`/teams/${team.id}/work-sample`"
                                                 class="text-white">
                                        <i class="fa fa-folder"></i>
                                    </router-link>
                                    <router-link title="اعضا" :to="`/teams/${team.id}/member`"
                                                 class="text-white">
                                        <i class="fa fa-users"></i>
                                    </router-link>
                                    <i class="fa fa-window-close" title="حذف" @click="handleDelete(team.id)"></i>

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8" v-html=team.description.substr(0,200)>
                                </div>
                                <div class="col-md-4">
                                    <img class="img-thumbnail" :src=team.profile_image :alt="`profile-${team.id}`"
                                         width="100%">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-secondary">
                            <div class="row">
                                <div class="col-md-6 text-left">
                                    امتیاز:
                                    <span v-if="team.treviewed !==null ">
                                        <span :class="getClass(team.treviewed.star,1)" class="fa fa-star"></span>
                                        <span :class="getClass(team.treviewed.star,2)" class="fa fa-star"></span>
                                        <span :class="getClass(team.treviewed.star,3)" class="fa fa-star"></span>
                                        <span :class="getClass(team.treviewed.star,4)" class="fa fa-star"></span>
                                        <span :class="getClass(team.treviewed.star,5)" class="fa fa-star"></span>

                                    <router-link :to="`/teams/${team.id}/review`">جزییات</router-link>
                                    </span>
                                    <span v-else class="badge badge-danger">بررسی نشده</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <router-link title="پروژه ها" :to="`/teams/${team.id}/reserved-project`"
                                                 class="text-white btn btn-xs btn-success">
                                        پروژه ها دریافتی

                                    </router-link>
                                    <router-link title="پروژه ها" :to="`/teams/${team.id}/project`"
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
                teams: []
            }
        },
        methods: {
            getTeamList() {
                axios.get('/teams').then(response => this.teams = response.data).catch(error => this.errorNotify(error.response.data.message));

            },
            jdate(date) {
                return moment(date).format('jYYYY/jM/jD');
            },
            handleDelete(id) {
                this.deleteConfirm()
                    .then(confirm => {
                        if (confirm) {
                            axios.delete(`/teams/${id}`).then(response => {
                                this.getTeamList();
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
            this.getTeamList();

        },
    }
</script>
<style scoped>
    .checked {
        color: orange;
    }
</style>
