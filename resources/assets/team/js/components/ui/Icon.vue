<template>
    <span v-if="icon.length > 0"
          :class="`zmdi zmdi-${icon} text text-${type}`"
          rel="tooltip"
          :style="style"
          :title="label"></span>
</template>

<script>
    export default {
        props: {
            icon: {
                type: String,
                default: ''
            },
            type: {
                type: String,
                default: 'default'
            },
            label: {
                type: String,
                default: ''
            },
            bold: {
                type: Boolean,
                default: false
            }
        },
        mounted() {
            $(this.$el).tooltip();
        },
        computed: {
            style() {
                if (this.bold) {
                    return "font-weight: bold";
                }
                else {
                    return '';
                }
            }
        }
    }
</script>