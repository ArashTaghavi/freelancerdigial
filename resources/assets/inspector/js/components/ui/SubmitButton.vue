<template>
    <button type="submit" :class="`btn btn--icon btn-${type}`" :title="label">
        <i v-if="icon !== ''" :class="`zmdi zmdi-${icon}`"></i>
    </button>
</template>

<script>
    export default {
        props: {
            label: {
                type: String,
                default: 'ثبت'
            },
            type: {
                type: String,
                default: 'light'
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
