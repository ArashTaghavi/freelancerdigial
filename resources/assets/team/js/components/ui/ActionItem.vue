<template>
    <router-link :to="to" :class="`actions__item zmdi zmdi-${icon}`" :title="title"></router-link>
</template>

<script>
    export default {
        props: {
            to: {
                type: String,
                default: ''
            },
            title: {
                type: String,
                default: ''
            },
            icon: {
                type: String,
                default: 'check'
            }
        },
        mounted() {
            $(this.$el).tooltip();
        }
    }
</script>