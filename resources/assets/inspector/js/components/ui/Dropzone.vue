<template>
    <form action="/file-upload" class="dropzone no-margin">
        <div class="fallback">
            <input name="file" type="file"/>
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            url: {
                type: String,
                default: null
            }
        },
        methods: {
            getAuthToken() {
                //return this.$auth.token();
            }
        },
        mounted() {
            $(this.$el).dropzone({
                url: this.url,
                headers: {
                    Authorization: 'Bearer ' + this.getAuthToken()
                },
                method: "post",
                withCredentials: true,
                parallelUploads: 1,
                uploadMultiple: false,
                maxFilesize: 256,
                paramName: "file",
                createImageThumbnails: true,
                maxThumbnailFilesize: 10,
                thumbnailWidth: 200,
                thumbnailHeight: 200,
                maxFiles: null,
                params: {

                },
                clickable: true,
                ignoreHiddenFiles: true,
                acceptedFiles: null,
                acceptedMimeTypes: null,
                autoProcessQueue: false,
                addRemoveLinks: true,
                previewsContainer: null,
                dictDefaultMessage: "فایل های خود را کشیده و اینجا رها کنید",
                dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",
                dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
                dictFileTooBig: "File is too big ({{filesize}}MB). Max filesize: {{maxFilesize}}MB.",
                dictInvalidFileType: "You can't upload files of this type.",
                dictResponseError: "Server responded with {{statusCode}} code.",
                dictCancelUpload: "Cancel upload",
                dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
                dictRemoveFile: "Remove file",
                dictRemoveFileConfirmation: null,
                dictMaxFilesExceeded: "You can only upload {{maxFiles}} files.",
            });
        }
    }
</script>