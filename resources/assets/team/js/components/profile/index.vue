<template>
    <div class="card">
        <breadcrumb :items="breadcrumb" :current="$route.name"/>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="first_name">نام</label>
                        <input class="form-control form-control-sm" type="text" id="first_name"
                               placeholder="نام خود را اینجا وارد نمایید."
                               v-model="form.first_name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="first_name">نام خانوادگی</label>
                        <input class="form-control form-control-sm" type="text" id="last_name"
                               placeholder="نام خانوادگی خود را اینجا وارد نمایید."
                               v-model="form.last_name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">ایمیل</label>
                        <input class="form-control form-control-sm" type="text" id="email"
                               placeholder="ایمیل خود را اینجا وارد نمایید."
                               v-model="form.email">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="username">نام کاربری</label>
                        <input class="form-control form-control-sm" type="text" id="username"
                               v-model="form.username" disabled>
                    </div>
                </div>
                <div class="col-md-12 text-right mt-3">
                    <div class="form-group">
                        <cropper-portlet v-model="form.profile_image" title="تصویر پروفایل" place="right"/>
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
        created() {
            axios.get('/profile')
                .then(response => this.form = response.data)
                .catch(e => console.log(e));
        },
        methods: {
            handleSubmit() {
                axios.put(`/profile`, this.form).then(response => {
                    this.successNotify(response.data.message);
                }).catch(error => {
                    this.errorNotify(error.message);
                })
            }
        }
    }
</script>
