<template>
    <li v-if="$slots['default']" class="dropdown hidden-xs-down">
        <a href="#" @click="clearTooltip" :title="title" data-toggle="dropdown"><i :class="`zmdi zmdi-${icon}`"></i></a>

        <div class="dropdown-menu dropdown-menu-right dropdown-menu--block" role="menu">
            <div class="row app-shortcuts">
                <slot></slot>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        props: {
            icon: {
                type: String,
                default: 'apps'
            },
            title: {
                type: String,
                default: ''
            },
        },
        mounted() {
            if (this.title !== '') {
                $(this.$el).find('>a').tooltip();
            }
        },
        methods: {
            clearTooltip() {
                $(this.$el).find('>a').tooltip('hide');
            }
        }
    }
</script>