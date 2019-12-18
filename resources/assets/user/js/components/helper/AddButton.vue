<template>
    <div class="text-right mb-3">
        <router-link :to="href" :class="`btn btn-sm btn-info btn--icon`" :title="label" style="color:#fff">
            <i v-if="icon !== ''" :class="`zmdi zmdi-${icon}`"></i>
            {{label}}
        </router-link>
    </div>
</template>

<script>
    export default {
        props: {
            label: {
                type: String,
                default: 'افزودن'
            },
            type: {
                type: String,
                default: 'info'
            },
            icon: {
                type: String,
                default: 'plus'
            },
            href: {
                type: String,
                default: '#'
            }
        },
        mounted() {
            $(this.$el).tooltip();
        }
    }
</script>
