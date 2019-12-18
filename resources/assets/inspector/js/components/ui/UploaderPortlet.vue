<template>
    <portlet :title="title">
        <portlet-button key="uploader-portlet#01" slot="buttons" icon="delete" @click="clearFile" title="حذف" v-if="hasFile"/>
        <portlet-file-download-button key="uploader-portlet#02" slot="buttons" :url="value" v-if="hasFile && download"/>
        <portlet-button key="uploader-portlet#03" slot="buttons" icon="upload" @click="showUploader" title="بارگذاری" v-if="!enableUploader"/>

        <vue-dropzone v-if="enableUploader"
                      key="uploader-portlet#04"
                      ref="dropzone"
                      id="file-dropzone"
                      @vdropzone-canceled="handleCancelUpload"
                      @vdropzone-success="afterUpload"
                      :options="dropOptions"
                      class="m-t-10"/>
    </portlet>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: 'پرونده پیوست'
            },
            download: {
                type: Boolean,
                default: false
            },
            minimize: {
                type: Boolean,
                default: false
            },
            value: {
                type: [String, Array],
                default: ''
            }
        },
        data() {
            return {
                enableUploader: false,
                dropOptions: {
                    url: "/admin/services/storage/upload",
                    chunking: true,
                    chunkSize: 1500000,
                    addRemoveLinks: true,
                    maxFiles: 1,
                    chunksUploaded: (file, done) => {
                        this.afterChunkUpload(file, done)
                    },
                    // acceptedFiles: 'application/pdf',
                    dictRemoveFile: 'حذف پرونده',
                    dictCancelUpload: 'انصراف',
                    dictCancelUploadConfirmation: 'آیا برای انصراف بارگذاری اطمینان دارید؟',
                    dictMaxFilesExceeded: 'امکان بارگذاری پرونده دیگر به دلیل محدودیت تعداد بارگذاری وجود ندارد.',
                    dictDefaultMessage: 'فایل های خود را کشیده و در این قسمت رها کنید.',
                    previewTemplate: '<div class="dz-preview dz-file-preview card-header">\n' +
                        '  <div class="dz-details">\n' +
                        '    <div class="dz-filename"><span data-dz-name></span></div>\n' +
                        '    <div class="dz-size" data-dz-size></div>\n' +
                        '  </div>\n' +
                        '  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>\n' +
                        '  <div class="dz-success-mark"><span class="icon-check text-success"></span></div>\n' +
                        '  <div class="dz-error-mark"><span class="icon-ban text-danger"></span></div>\n' +
                        '  <div class="dz-error-message"><span data-dz-errormessage></span></div>\n' +
                        '</div>',
                },
            }
        },
        methods: {
            showUploader() {
                this.enableUploader = true;
            },
            clearFile() {
                this.$emit('input', null);
                this.enableUploader = false;
            },
            handleCancelUpload(file) {
                axios.post(`/admin/services/storage/cancel-upload/${file.upload.uuid}`)
                    .then(response => {
                    })
                    .catch(exception => {
                    });
            },
            afterUpload(file, response) {
                if (response.hasOwnProperty('filename')) {
                    this.$emit('input', response.filename);
                }
            },
            afterChunkUpload(file, done) {
                this.$emit('input', file.upload.uuid);
                done();
            },
            bytesToSize(bytes) {
                let sizes = ['بایت', 'کیلوبایت', 'مگابایت', 'گیگابایت', 'ترابایت'];
                if (bytes === 0) return '۰ بایت';
                let i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
            },
        },
        computed: {
            hasFile() {
                return this.value !== null && this.value !== '';
            }
        }
    }
</script>