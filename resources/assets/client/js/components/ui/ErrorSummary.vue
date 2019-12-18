<template>
    <div class="alert alert-danger text-right">
        <i class="icon-close"></i>
        <strong>{{ title }}</strong>
        <ul class="error-summary-list">
            <li v-for="error in errors">{{ error[0] }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: 'خطای اعتبارسنجی!'
            },
            pageForm: {
                type: Object,
                default: function () {
                    return {};
                }
            },
            errors: {
                type: Object,
                default: function () {
                    return {};
                }
            }
        },
        mounted() {
            let vm = this;
            console.log(this.pageForm);
            for (let field in this.pageForm) {
                this.$watch(`pageForm.${field}`, function (newVal) {
                    vm.$emit('fieldchange', field);
                });
            }
        }
    }
</script>

<style>
    .error-summary-list li {
        list-style-type: disc;
        margin-right: 70px;
    }
</style>