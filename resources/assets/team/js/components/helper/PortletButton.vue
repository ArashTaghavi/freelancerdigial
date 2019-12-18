<template>
    <button v-if="btnTitle" @click.prevent="handleClick()" :class="`btn btn-xs btn-labeled mb-2 btn-${type}`" :title="title"
            type="button">
        <span class="btn-label"><i :class="`fa fa-${icon}`"></i></span>{{title}}
    </button>
    <span v-else  :title="title" @click.prevent="handleClick()" class="mr-1 btn"><i :class="`fa fa-${icon}`"></i></span>

</template>

<script>
    export default {
        props: {
            btnTitle: {
                type: Boolean,
                default: true
            },
            icon: {
                type: String,
                default: ''
            },
            type: {
                type: String,
                default: 'success'
            },
            title: {
                type: String,
                default: ''
            },
            to: {
                type: String,
                default: ''
            },
            permission: {
                type: [String, Array],
                default: function () {
                    return [];
                }
            }
        },
        mounted() {
            $('a').tooltip('hide');
            $(this.$el).tooltip();
        },
        methods: {
            handleClick() {
                if (this.to === '') {
                    this.$emit('click');
                } else {
                    this.$router.push(this.to);
                }
            }
        },
        computed: {
            checkAccess() {
                if (this.permission === '')
                    return true;
                return this.hasAccess(this.permission);
            }
        }
    }
</script>