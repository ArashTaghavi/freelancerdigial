<template>
    <textarea v-bind:value="value"></textarea>
</template>

<script>
    export default {
        props: {
            value: {
                type: String,
                default: ''
            }
        },
        methods: {
            initEditor() {
                let config = {
                    lang: 'fa-IR',
                    airMode: false,
                    direction: "rtl",
                    fontNames: [],
                    fontNamesIgnoreCheck: [],
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['picture', 'link', 'video', 'table', 'hr']],
                        ['height', ['height']],
                        ['misc', ['fullscreen', 'codeview']]
                    ]
                };
                let vm = this;
                config.callbacks = {
                    onInit: function () {
                        $(vm.$el).summernote("code", vm.value);
                    },
                    onChange: function (value) {
                        vm.$emit('input', value);
                    },
                };
                $(this.$el).summernote(config);
            }
        },
        mounted() {
            this.initEditor();
        }
    }
</script>