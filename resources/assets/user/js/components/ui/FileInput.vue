<template>
    <a :class='`btn btn--icon btn-${type}`' rel="tooltip" :data-title="title" style="cursor: pointer;position:relative;margin-bottom:5px;">
        <i class="zmdi zmdi-upload"></i>
        <span v-if="showText" style="cursor: pointer">{{ title }}</span>
        <input type="file"
               class="file-input"
               :accept="accept"
               name="file_source"
               @change="handleFileChange">
    </a>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: 'انتخاب تصویر'
            },
            icon: {
                type: String,
                default: ''
            },
            type: {
                type: String,
                default: 'light'
            },
            accept: {
                type: String,
                default: ''
            },
            showText: {
                type: Boolean,
                default: false
            },
            maxSize: {
                type: Number,
                default: 1100000
            }
        },
        mounted() {
            $(this.$el).tooltip();
        },
        methods: {
            handleFileChange(event) {
                this.$emit('change', event);
            }
        }
    }
</script>

<style>
    .file-input {
        cursor: pointer;
        position: absolute;
        z-index: 2;
        top: 0;
        left: 0;
        filter: alpha(opacity=0);
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
        opacity: 0;
        background-color: transparent;
        color: transparent;
    }
</style>