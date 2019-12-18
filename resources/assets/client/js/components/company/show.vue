<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">
                        {{company.title}}
                    </h2>
                    <hr>
                    <div style="line-height: 35px" class="text-justify" v-html="company.description">
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <a :href=company.profile_image>
                                تصویر شاخص
                                <img class="img-thumbnail" :src=company.profile_image :alt=company.profile_image>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <h4>پیوست ها:</h4>
                            <p
                                v-for="value in company.attachments">
                                <a :href=file
                                   class="text-white badge badge-purple mr-2"
                                   v-for="(file,index) in JSON.parse(value.attachment)">
                                    <i class="zmdi zmdi-download"></i>
                                    پیوست
                                    {{index + 1}}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12 card-body bg-gray">
                    <h3 class="text-center">فرم ارزیابی شرکت</h3>
                    <div class="form-group">
                        <label for="description">توضیحات</label>
                        <textarea rows="10" class="form-control form-control-sm" type="text" id="description"
                                  placeholder="توضیحات خود را اینجا وارد نمایید."
                                  v-model="form.description">
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="star">ستاره</label>
                        <select name="" id="star" v-model="form.star" class="form-control">
                            <option value="0">0</option>
                            <option value="0.5">0.5</option>
                            <option value="1">1</option>
                            <option value="1.5">1.5</option>
                            <option value="2">2</option>
                            <option value="2.5">2.5</option>
                            <option value="3">3</option>
                            <option value="3.5">3.5</option>
                            <option value="4">4</option>
                            <option value="4.5">4.5</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <submit-button @click="handleSubmit()"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            CKEDITOR.replace('description', {
                extraPlugins: 'cloudservices',
                language: 'fa',
                height: 300,
                toolbarCanCollapse: true
            });

        },
        data() {
            return {
                company: [],
                review: []
            }
        },
        created() {
            this.form = {
                description: '',
                star: ''
            };
            axios.get(`companies/${this.$route.params.id}`)
                .then(response => {
                    this.afterFetchItem(response);
                })
                .catch(error => this.errorNotify(error.message));

        },
        methods: {
            handleSubmit() {
                this.form.description = CKEDITOR.instances.description.getData();
                axios.post(`/companies/store-review/${this.$route.params.id}`, this.form).then(response => {
                    this.saveMessage(response.data.message);
                    this.$router.push('/companies');
                }).catch(error => {
                    this.errorNotify(error.message);
                });
            },
            afterFetchItem(response) {
                this.company = response.data;
                this.form.star = 0;
                let _description = '';
                if (response.data.reviewed != null)
                    this.form.star = response.data.reviewed.star;

                if (response.data.reviewed != null)
                    _description = response.data.reviewed.description;
                this.form.description = CKEDITOR.instances.description.setData(_description);
                this.breadcrumb = [
                    {title: 'شرکت ها', to: '/companies'},
                    {title: this.company.title, to: `/companies/${this.company.id}/show`}
                ];
            }
        },
    }
</script>
