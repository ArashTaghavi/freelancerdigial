<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6" v-for="team in teams">
                    <div class="card box-shadow">
                        <div class="card-header bg-success">
                            <router-link :to="`teams/${team.id}/show`" style="color: #fff">
                                <h3 class="card-title">
                                    {{team.title}}
                                </h3>
                            </router-link>
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
                                    <div v-if="team.treviewed!=null" >
                                        <span :class="getClass(team.treviewed.star,1)" class="fa fa-star"></span>
                                        <span :class="getClass(team.treviewed.star,2)" class="fa fa-star"></span>
                                        <span :class="getClass(team.treviewed.star,3)" class="fa fa-star"></span>
                                        <span :class="getClass(team.treviewed.star,4)" class="fa fa-star"></span>
                                        <span :class="getClass(team.treviewed.star,5)" class="fa fa-star"></span>
                                    </div>
                                    <span v-else class="badge badge-danger">بررسی نشده</span>

                                </div>
                                <div class="col-md-6 text-right">
                                 <span class="badge badge-green">
                                                {{jdate(team.created_at)}}
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
                teams: []
            }
        },
        methods: {
            getCompanyList() {
                axios.get('/teams')
                    .then(response => this.teams = response.data)
                    .catch(error => this.errorNotify(error.response.data.message));
            },
            jdate(date) {
                return moment(date).format('jYYYY/jM/jD');
            },
            handleDelete(id) {
                this.deleteConfirm()
                    .then(confirm => {
                        if (confirm) {
                            axios.delete(`/teams/${id}`).then(response => {
                                this.getCompanyList();
                                this.successNotify(response.data.message);
                            }).catch(error => this.errorNotify(error.response.data.message));
                        }
                    })
                    .catch(error => this.errorNotify(error.response.data.message));

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
            afterDeleteItem(response) {

            }
        },
        created() {
            this.getCompanyList()
        },
    }
</script>
<style scoped>
    .checked {
        color: orange;
    }
</style>
