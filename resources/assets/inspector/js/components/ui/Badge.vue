<template>
    <span :class="`badge badge-${type}`" rel="tooltip" :title="label">
        <span v-if="icon.length > 0" :class="`icon-${icon}`"></span>
        <span v-if="showLabel && label.length > 0">{{ label }}</span>
    </span>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'primary'
            },
            icon: {
                type: String,
                default: ''
            },
            label: {
                type: String,
                default: ''
            },
            showLabel: {
                type: Boolean,
                default: true
            }
        },
        mounted() {
            if (this.label.length > 0){
                $(this.$el).tooltip();
            }
        }
    }
</script>