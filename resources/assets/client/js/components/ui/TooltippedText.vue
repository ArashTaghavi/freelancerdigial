<template>
    <span :style="style" :class="elementClass" :title="tooltip">{{ text }}</span>
</template>

<script>
    export default {
        props: {
            tooltip: {
                type: [String, Number],
                default: ''
            },
            text: {
                type: [String, Number],
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
            },
            elementClass() {
                let classObject = [];
                classObject.push('animated flash');
                return classObject;
            }
        },
        watch: {
            text(newValue) {
                let vm = this;
                $(this.$el).addClass('flash');
                setTimeout(function () {
                    $(vm.$el).removeClass('flash');
                }, 500);
            }
        }
    }
</script>