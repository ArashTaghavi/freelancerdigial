<template>
    <div v-if="$slots['default']" class="dropdown actions__item">
        <i data-toggle="dropdown" :class="`zmdi zmdi-${icon}`" aria-expanded="false"></i>
        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-39px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            tooltip: {
                type: String,
                default: ''
            },
            icon: {
                type: String,
                default: 'more-vert'
            }
        },
        mounted() {
            let vm = this;
            $(this.$el).find('[data-toggle="dropdown"]').tooltip({
                title: vm.tooltip
            });
        }
    }

</script>