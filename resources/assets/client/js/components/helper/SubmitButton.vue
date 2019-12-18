<template>
    <button
        @click.prevent="handleClick"
        type="submit" :class="`btn btn-sm btn-success btn--icon`" :title="label">
        <i v-if="icon !== ''" :class="`zmdi zmdi-${icon}`"></i>
        {{label}}
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
                default: 'success'
            },
            icon: {
                type: String,
                default: 'check'
            }
        },
        methods: {
            handleClick(event) {
                this.$emit('clicked');
                this.$emit('click');
                $(this.$el).tooltip('hide');
            }
        },
        mounted() {
            $(this.$el).tooltip();
        }
    }
</script>
