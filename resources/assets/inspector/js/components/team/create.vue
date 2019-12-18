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
                        <input class="form-control form-control-sm" type="text" id="category_id"
                               placeholder="عنوان خود را اینجا وارد نمایید."
                               v-model="form.category_id">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tags">تگ ها</label>
                        <input class="form-control form-control-sm" type="text" id="tags"
                               placeholder="عنوان تگ را وارد کنید و اینتر بزنید."
                               v-model="tag" @keypress.enter="addTags">
                    </div>
                    <div v-if="form.length>0">
                        <span class="text-muted">
                            <i class="zmdi zmdi-tag"></i>
                            برچسب ها:
                        </span>
                        <a class="badge badge-purple mr-2" :href=file
                           v-for="(tag,index) in form.tags">
                                                <span>
                                                {{tag}}
                                                </span>
                            <span class="ml-5"
                                  @click="removeTags(index)">
                                                    <i class="zmdi zmdi-close"></i>
                                                </span>
                        </a>
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
                <div class="col-md-12 text-right mt-3">
                    <div class="form-group">
                        <cropper-portlet v-model="form.profile_image" title="تصویر شاخص" place="right"/>
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
    export default {
        data() {
            return {
                tag: '',
            }
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
                    this.successNotify(response.data.message);
                    this.$router.push('/companies')
                }).catch(error => {
                    this.errorNotify(error.error);
                })
            },
            addTags() {
                this.form.tags.push(this.tag);
            },
            removeTags(index) {
                this.form.tags.splice(index,1);
            }
        }
    }
</script>
