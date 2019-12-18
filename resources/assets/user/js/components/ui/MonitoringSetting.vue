<template>
    <div class="col-lg-12">
        <!-- START card-->
        <div class="card card-default" id="cardDemo1">
            <div class="card-header">فیلتر
                <a class="float-right" href="#" data-tool="card-collapse" data-toggle="tooltip" title=""
                   data-original-title="Collapse Card">
                    <em :class="`fa fa-${icon}`" @click="handleIcon"></em>
                </a>
            </div>
            <div class="card-wrapper collapse" style="">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="btn-group">
                                <div class="btn btn-info btn-xs" @click="$emit('setColumns',12)"> 1 ستون</div>
                                <div class="btn btn-success btn-xs" @click="$emit('setColumns',6)"> 2 ستون</div>
                                <div class="btn btn-danger btn-xs" @click="$emit('setColumns',4)"> 3 ستون</div>
                                <div class="btn btn-primary btn-xs" @click="$emit('setColumns',3)"> 4 ستون</div>
                                <!--           <div class="btn btn-warning btn-xs" @click="$emit('setColumns',0)">پیش فرض</div>-->
                            </div>
                        </div>
                        <div class="col-md-2">
                            <ui-select placeholder="معاونت" v-model="form.org" :options="org"/>
                        </div>
                        <div class="col-md-2">
                            <ui-select placeholder="سبد اطلاعاتی" v-model="form.source_id" :options="source"/>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <date-time-picker-portlet title="تاریخ شروع" v-model="form.start_time"
                                                              type="date"/>
                                </div>
                                <div class="col-md-6">
                                    <date-time-picker-portlet title="تاریخ پایان" v-model="form.end_time"
                                                              type="date"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <checkbox-portlet label="Real Time"/>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="btn-group">
                                <simple-button size="xs" title="روز جاری"
                                               @click="day(1,true)"/>
                                <simple-button size="xs" type="warning" title="دو روز اخیر" @click="day(-1)"/>
                                <simple-button size="xs" type="info" title="سه روز اخیر" @click="day(-2)"/>
                                <simple-button size="xs" type="danger" title="هفته جاری" @click="week"/>
                                <simple-button size="xs" type="success" title="ماه جاری" @click="month"/>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <div class="btn btn-success btn-xs" @click="doFilter(form)">اعمال</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END card-->
    </div>

</template>

<script>

    import SimpleButton from "./Simple-Button";

    export default {
        name: "MonitoringSetting",
        components: {SimpleButton},
        data() {
            return {
                now: moment().format('jYYYY/jMM/jDD'),
                source: [],
                org: [],
                icon: 'plus'
            }
        },
        created() {
            this.form = {
                start_time: '',
                end_time: ''
            };
            axios.options('request-report/source-list').then(response => this.source = response.data);
            axios.options('menus/get-roots-menu').then(response => this.org = response.data);
        },
        methods: {
            handleIcon() {
                if (this.icon === 'plus')
                    this.icon = 'minus';
                else
                    this.icon = 'plus';
            },
            day(value, currentDay = false) {
                let day = 1;
                if (currentDay) {
                    day = 0;
                }
                this.form.start_time = moment().add(day, 'days').format('jYYYY/jMM/jDD 00:00');
                this.form.end_time = moment().add(value, 'days').format('jYYYY/jMM/jDD 00:00');
                this.doFilter(this.form);
            },
            week() {
                this.form.start_time = moment().startOf('week').format('jYYYY/jMM/jDD 00:00');
                this.form.end_time = moment().endOf('week').add(1,'days').format('jYYYY/jMM/jDD 00:00');
                this.doFilter(this.form);
            },
            month() {
                this.form.start_time = moment().startOf('month').format('jYYYY/jMM/jDD 00:00');
                this.form.end_time = moment().endOf('month').add(1,'days').format('jYYYY/jMM/jDD 00:00');
                this.doFilter(this.form);
            },
            doFilter(form) {
                this.$events.fire('doFilters', form)
            },
        }
    }
</script>

<style scoped>

</style>