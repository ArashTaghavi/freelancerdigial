<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">نتیجه ارزیابی</h3>
                    <div class="p-5" style="line-height: 25px" v-html="team.treviewed.description"></div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ارزیابی</th>
                                <th>تعداد ستاره</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="detail in team.treviewed.details">
                                <td>{{getAssessment(detail.type)}}</td>
                                <td>
                                    <i v-for="star in detail.score" class="fa fa-star checked"></i>
                                </td>
                            </tr>
                            </tbody>
                        </table>

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
                team: []
            }
        },
        created() {
            axios.get(`/teams/review/${this.$route.params.id}`).then(response => this.afterFetchItem(response)).catch(error => this.errorNotify(error.response.data.message));
        },
        methods: {
            afterFetchItem(response) {
                this.team = response.data;
                this.breadcrumb = [
                    {title: 'تیم ها', to: '/teams'},
                    {title: this.team.title, to: `/teams`}
                ]
            },
            getAssessment(id) {
                if (id === 1)
                    return 'ارزیابی محیطی و فیزیکی';
                if (id === 2)
                    return 'ارزیابی نیروی کار بر اساس مهارت و تعداد';
                if (id === 3)
                    return 'ارزیابی نمونه کارها';
                if (id === 4)
                    return 'ارزیابی مدارک';
            }
        }
    }
</script>
<style scoped>
    .checked {
        color: orange;
    }
</style>
