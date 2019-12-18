<template>
    <a v-if="url !== null" :href="`/${url}`" rel="tooltip" :data-title="label" target="_blank" class="btn btn-light btn--icon">
        <span class="zmdi zmdi-download"></span>
    </a>
</template>

<script>
    export default {
        props: {
            label: {
                type: String,
                default: 'دریافت پرونده پیوست'
            },
            url: {
                type: String,
                default: ''
            }
        },
        mounted() {
            $(this.$el).tooltip();
        },
        methods: {
            /*showUploader() {
                console.log('Enable cropper...');
                this.$parent.enableUploader = true;
            }*/
        }
    }
</script>