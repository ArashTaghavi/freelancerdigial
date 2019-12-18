<template>
    <div :class="alertClass">
        <span>{{ message }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            cssClass: {
                type: String,
                default: 'alert alert-info text-center'
            },
            message: {
                type: String,
                default: 'هیچ نتیجه ای برای نمایش یافت نشد.'
            },
        },
        computed: {
            alertClass() {
                let _classObject = [];
                _classObject.push(this.cssClass);
                return _classObject;
            }
        }
    }

</script>