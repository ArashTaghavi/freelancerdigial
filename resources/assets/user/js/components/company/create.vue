<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step col-xs-3">
                    <a href="#step-1" type="button" class="btn btn-circle btn-default btn-success">1</a>
                    <p><small>ثبت شرکت</small></p>
                </div>
                <div class="stepwizard-step col-xs-3">
                    <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                    <p><small>مدارک</small></p>
                </div>
                <div class="stepwizard-step col-xs-3">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                    <p><small>نمونه کار</small></p>
                </div>
                <div class="stepwizard-step col-xs-3">
                    <router-link :to="``" type="button" class="btn btn-default btn-circle" disabled="disabled">3
                    </router-link>
                    <p><small>اعضا</small></p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="title">نام شرکت</label>
                        <input class="form-control form-control-sm" type="text" id="title"
                               placeholder="عنوان خود را اینجا وارد نمایید."
                               v-model="form.title">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="member_count">تعداد اعضا</label>
                        <input class="form-control form-control-sm" type="number" id="member_count"
                               placeholder="تعداد اعضای خود را اینجا وارد نمایید."
                               v-model="form.member_count">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="activity_duration">مدت فعالیت</label>
                        <input class="form-control form-control-sm" type="text" id="activity_duration"
                               placeholder="مدت فعالیت خود را اینجا وارد نمایید."
                               v-model="form.activity_duration">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="category_id">دسته بندی</label>
                        <select title="دسته بندی" class="form-control" name=""
                                v-model="form.category_id" id="category_id">
                            <option :value=category.id v-for="category in categories">
                                {{category.title}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tags">
                            تگ ها
                            <small class="text-muted">( برای بهتر دیده شدن در نتایج جستجو )</small>
                        </label>
                        <input class="form-control form-control-sm" type="text" id="tags"
                               placeholder="عنوان تگ را وارد کنید و اینتر بزنید."
                               v-model="tag" @keypress.enter="addTags">
                    </div>
                    <span class="text-muted" v-if="this.form.tags.length>0">
                            <i class="zmdi zmdi-tag"></i>
                            تگ ها:
                        </span>
                    <button class="mt-1 mr-1 btn btn-xs"
                            v-for="(_tag,index) in form.tags">
                                                <span>
                                                {{_tag}}
                                                </span>
                        <span class="ml-5"
                              @click="removeTags(index)">
                                                    <i class="zmdi zmdi-close"></i>
                                                </span>
                    </button>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="address">آدرس و شماره تماس</label>
                        <textarea class="form-control form-control-sm" type="text" id="address"
                                  placeholder="آدرس و شماره تماس خود را اینجا وارد نمایید."
                                  v-model="form.address"></textarea>
                    </div>
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
                <div class="col-md-6 text-left mt-3">
                    <div class="form-group">
                        <label for="">لوگو شرکت </label>
                        <br>
                        <cropper-portlet v-model="form.profile_image" title="تصویر شرکت" place="left"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <span style="font-size: 16px">ویدیو معرفی شرکت</span>
                    <br>
                    <br>
                    <vue-dropzone id="drop1" :options="dropOptions"></vue-dropzone>
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
    export default {
        data() {
            return {
                tag: '',
                categories: [],
                dropOptions: {
                    url: `/api/user/companies/upload-introduction`,
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
            axios.get('/categories')
                .then(response => this.categories = response.data)
                .catch(error => this.errorNotify(error.response.data.message));

        },
        mounted() {
            CKEDITOR.replace('description', {
                extraPlugins: 'cloudservices',
                language: 'fa',
                height: 300,
                toolbarCanCollapse: true
            });

        },
        methods: {
            handleSubmit() {
                this.form.description = CKEDITOR.instances.description.getData();
                axios.post(`/companies`, this.form).then(response => {
                    this.nextStep(response)
                }).catch(error => {
                    this.errorNotify(error.response.data.message);
                })
            },
            addTags() {
                if (this.form.tags !== '')
                    this.form.tags.push(this.tag);
                this.tag = '';
            },
            removeTags(index) {
                this.form.tags.splice(index, 1);
            },
            nextStep(response) {
                this.successNotify(response.data.message);
                this.$router.push(`/companies/${response.data.id}/attachment`);
            }
        }
    }
</script>
<style>
    .bootstrap-select.btn-group .dropdown-toggle .filter-option {
        text-align: right !important;
    }

    .stepwizard-step p {
        margin-top: 0px;
        color: #666;
    }

    .stepwizard-row {
        display: table-row;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        /*opacity: 1 !important;
        filter: alpha(opacity=100) !important;*/
    }

    .stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
        opacity: 1 !important;
        color: #bbb;
    }

    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-index: 0;
    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }
</style>
