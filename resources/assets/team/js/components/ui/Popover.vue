<template>
    <a href="#"
            @click.prevent=""
            :data-html="useHtml"
            data-toggle="popover"
            :data-trigger="trigger"
            :title="getTitle"
            :data-content="content"
            :data-placement="placement">
        <span :class="`zmdi zmdi-${icon}`"></span>
    </a>
</template>

<script>
    export default {
        props: {
            btnClass: {
                type: String,
                default: 'btn btn--icon btn-dark'
            },
            label: {
                type: [String, Number],
                default: 'info'
            },
            icon: {
                type: String,
                default: ''
            },
            title: {
                type: String,
                default: ''
            },
            content: {
                type: String,
                default: ''
            },
            useHtml: {
                type: Boolean,
                default: false
            },
            trigger: {
                type: String,
                default: 'focus'
            },
            placement: {
                type: String,
                default: 'left'
            }
        },
        computed: {
            getTitle() {
                return this.useHtml ? `<p class="text-center"><strong>${this.title}</strong></p>` : this.title;
            }
        },
        mounted() {
            $(this.$el).popover();
        }
    }
</script>