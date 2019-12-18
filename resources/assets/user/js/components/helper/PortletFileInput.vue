<template>
    <button :class="`btn btn-labeled mb-2 actions__item fa btn-${type} btn-xs upload-btn`" type="button"
            rel="tooltip" :data-title="title">
        <span class="btn-label">
            <i :class="`fa fa-${icon}`"></i>
        </span>
        {{title}}
        <input type="file"
               class="file-input"
               :accept="accept"
               name="file_source"
               @change="handleFileChange">
    </button>

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
                default: 'upload'
            },
            type: {
                type: String,
                default: 'success'
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
    .upload-btn {
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .file-input {
        cursor: pointer;
        position: absolute;
        z-index: 2;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: block;
        filter: alpha(opacity=0);
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
        opacity: 0;
        background-color: transparent;
        color: transparent;
    }
</style>