<template>
    <router-link :to="to" :title="label" class="btn btn-dark btn--icon"><i class="zmdi zmdi-arrow-forward"></i></router-link>
</template>

<script>
    export default {
        props: {
            to: {
                type: String,
                default: ''
            },
            label: {
                type: String,
                default: 'بازگشت'
            }
        },
        mounted() {
            $(this.$el).tooltip();
        }
    }
</script>