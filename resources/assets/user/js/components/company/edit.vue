<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
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
                        <select class="form-control" name=""
                                v-model="form.category_id" id="category_id">
                            <option :value=category.id v-for="category in categories">
                                {{category.title}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tags">تگ ها</label>
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
                <div class="col-md-12 text-right mt-3 mb-3">
                    <div class="form-group">
                        <cropper-portlet v-model="form.profile_image" title="تصویر شاخص" place="right"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <span>ویدیو معرفی شرکت</span>
                    <vue-dropzone id="drop1" :options="dropOptions"></vue-dropzone>
                </div>
                <div class="col-md-6" v-if="form.introduction!==null">
                    <video :src=form.introduction style="width:100%" controls></video>
                </div>
                <div class="col-md-6" v-else>
                    <h6 class="text-center bg-warning-light p-5" style="margin-top: 20%">
                        ویدیویی برای معرفی بارگذاری نشده است.
                    </h6>
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
                    headers: {
                        'X-CSRF-TOKEN': window.token
                    }
                }
            }
        },
        mounted() {
            CKEDITOR.replace('description', {
                language: 'fa',
                height: 300,
                toolbarCanCollapse: true
            });
        },
        created() {

            axios.get(`companies/${this.$route.params.id}`)
                .then(response => {
                    this.afterFetchItem(response);
                })
                .catch(error => this.errorNotify(error.response.data.message));
            axios.get('/categories')
                .then(response => this.categories = response.data)
                .catch(error => this.errorNotify(error.response.data.message));

        },
        methods: {
            handleSubmit() {
                this.form.description = CKEDITOR.instances.description.getData();
                axios.put(`/companies/${this.$route.params.id}`, this.form).then(response => {
                    this.successNotify(response.data.message);
                    this.$router.push('/companies');
                }).catch(error => {
                    this.errorNotify(error.response.data.message);
                });
            },
            afterFetchItem(response) {
                this.form = response.data;
                CKEDITOR.instances.description.setData(this.form.description);
                this.breadcrumb = [
                    {title: 'شرکت ها', to: '/companies'},
                    {title: this.form.title, to: `/companies/${this.form.id}/edit`}
                ];
            },
            addTags() {
                this.form.tags.push(this.tag);
                this.tag = '';
            },
            removeTags(index) {
                this.form.tags.splice(index, 1);
            }
        },
    }
</script>
