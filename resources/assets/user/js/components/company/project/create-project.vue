<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title">عنوان</label>
                        <input class="form-control form-control-sm" type="text" id="title"
                               placeholder="عنوان خود را اینجا وارد نمایید."
                               v-model="form.title">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="category_id">دسته بندی</label>
                        <select class="form-control" name=""
                                v-model="form.category_id" id="category_id">
                            <option :value=category.id v-for="category in categories">
                                {{category.title}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="skill">مهارت های مورد نیاز</label>
                        <input class="form-control form-control-sm" type="text" id="skill"
                               placeholder="عنوان مهارت را وارد کنید و اینتر بزنید."
                               v-model="skill" @keypress.enter="addSkill">
                    </div>
                    <span class="text-muted" v-if="this.form.skill.length>0">
                            <i class="zmdi zmdi-tag"></i>
                            مهارت ها:
                        </span>
                    <button class="mt-1 mr-1 btn btn-xs"
                            v-for="(_skill,index) in form.skill">
                                                <span>
                                                {{_skill}}
                                                </span>
                        <span class="ml-5"
                              @click="removeSkill(index)">
                                                    <i class="zmdi zmdi-close"></i>
                                                </span>
                    </button>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">توضیحات</label>
                        <textarea rows="10" class="form-control form-control-sm" type="text" id="description"
                                  placeholder="توضیحات خود را اینجا وارد نمایید."
                                  v-model="form.description">
                        </textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">تاریخ شروع</label>
                        <date-picker v-model="form.start_date" format="jYYYY/jMM/jDD" :min="now"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">تاریخ پایان</label>
                        <date-picker v-model="form.end_date" format="jYYYY/jMM/jDD" :min="now"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="min_price">حداقل قیمت</label>
                        <input type="number" id="min_price" v-model="form.min_price"
                               class="form-control form-control-sm" min="0"
                               placeholder="حداقل قیمت را وارد نمایید.">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="max_price">حداکثر قیمت</label>
                        <input type="number" id="max_price" v-model="form.max_price"
                               class="form-control form-control-sm" min="0"
                               placeholder="حداکثر قیمت را وارد نمایید.">
                    </div>
                </div>
                <div class="col-md-12 text-left mt-3">
                    <div class="form-group">
                        <label for="drop1">فایل های پیوست</label>
                        <vue-dropzone id="drop1" :options="dropOptions"></vue-dropzone>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <div class="form-group">
                        <submit-button @click="handleSubmit"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker'

    Vue.use(VuePersianDatetimePicker, {
        name: 'custom-date-picker',
        props: {
            inputFormat: 'YYYY-MM-DD HH:mm',
            format: 'jYYYY-jMM-jDD HH:mm',
            editable: false,
            inputClass: 'form-control my-custom-class-name',
            placeholder: 'انتخاب تاریخ...',
            altFormat: 'YYYY-MM-DD HH:mm',
            color: '#00acc1',
            autoSubmit: false,
            //...
            //... And whatever you want to set as default
            //...
        }
    });
    export default {
        data() {
            return {
                categories: [],
                now: moment().format("jYYYY/jMM/jDD"),
                skill: '',
                dropOptions: {
                    url: `/api/user/projects/upload-introduction/file`,
                    maxFilesize: 2 * 1024, // MB
                    maxFiles: 5,
                    thumbnailWidth: 150, // px
                    thumbnailHeight: 150,
                    addRemoveLinks: true,
                    progress: true,
                    dictDefaultMessage: 'فایل های خود را اینجا قرار دهید.',
                    headers: {
                        'X-CSRF-TOKEN': window.token
                    }
                }

            }
        },
        created() {
            this.form.skill=[];
            axios.get('/categories')
                .then(response => this.afterFetchItem(response))
                .catch(error => this.errorNotify(error.response.data.message));
        },
        methods: {
            handleSubmit() {
                axios.post(`/projects/${this.$route.params.id}`, this.form).then(response => {
                    this.successNotify(response.data.message);
                    this.$router.push(`/companies/${this.$route.params.id}/project`)
                }).catch(error => {
                    this.errorNotify(error.response.data.message);
                })
            },
            addSkill() {
                if (this.form.skill !== '')
                    this.form.skill.push(this.skill);
                this.skill = '';
            },
            removeSkill(index) {
                this.form.skill.splice(index, 1);
            },
            afterFetchItem(response) {
                this.categories = response.data;
                this.breadcrumb = [
                    {title: 'پروژه ها', to: '/projects'}
                ]
            }
        },
        components: {
            datePicker: VuePersianDatetimePicker
        }
    }
</script>
<style>
    .filter-option {
        text-align: right !important;
    }

</style>
