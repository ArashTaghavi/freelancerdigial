<template>
    <div class="scrolling" :style="`height: ${this.height}px`">
        <div class="scrollbar-inner">
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>
    .scrolling {
        position: relative;
        overflow: hidden;
    }
</style>

<script>
    export default {
        props: {
            height: {
                type: Number,
                default: 300
            }
        },
        methods: {
            initScrollbarTooltips() {
                let vm = this;
                Vue.nextTick().then(function () {
                    $(vm.$el).find('[rel="tooltip"]').tooltip();
                });
            }
        },
        updated() {
            this.initScrollbarTooltips();
        },
        mounted() {
            $(this.$el).find('.scrollbar-inner').scrollbar().scrollLock();
            this.initScrollbarTooltips();
        }
    }
</script>