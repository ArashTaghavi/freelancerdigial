<template>
    <button :class="classObject" :rel="rel" :title="title" :disabled="isLoading" @click.prevent="handleClick">
        <i v-if="!isLoading" :class="`zmdi zmdi-${icon}`"></i>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'light'
            },
            icon: {
                type: String,
                default: ''
            },
            title: {
                type: String,
                default: ''
            },
            size: {
                type: String,
                default: ''
            },
            showText: {
                type: Boolean,
                default: true
            },
            showTooltip: {
                type: Boolean,
                default: true
            },
            isLoading: {
                type: Boolean,
                default: false
            },
            block: {
                type: Boolean,
                default: false
            },
            to: {
                type: String,
                default: ''
            },
            effect: {
                type: Boolean,
                default: false
            },
            submit: {
                type: Boolean,
                default: false
            }
        },
        created(){
            if (this.submit) {
                $(this.$el).attr('type', 'submit');
            }
        },
        mounted() {
            if (this.showTooltip) {
                $(this.$el).tooltip();
            }
        },
        computed: {
            classObject() {
                let classObject = ['btn', 'btn--icon'];
                if (this.type.length > 0) {
                    classObject.push(`btn-${this.type}`);
                }
                if (this.size.length > 0) {
                    classObject.push(`btn-${this.size}`);
                }
                if (this.block) {
                    classObject.push('btn-block');
                }
                return classObject;
            },
            rel() {
                return this.showTooltip ? 'tooltip' : '';
            }
        },
        methods: {
            handleClick(event) {
                if (this.to.length > 0) {
                    this.$router.push(this.to);
                }
                this.$emit('clicked');
                this.$emit('click');
                $(this.$el).tooltip('hide');
            }
        }
    }
</script>