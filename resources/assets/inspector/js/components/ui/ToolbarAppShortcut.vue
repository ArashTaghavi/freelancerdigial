<template>
    <a v-if="checkAccess" @click.prevent="handleClick" :class="`app-shortcuts__item ${itemClass}`">
        <i :class="`zmdi zmdi-${icon}`"></i>
        <small class="">{{ title }}</small>
    </a>
</template>

<script>
    export default {
        props: {
            permission: {
                type: [String, Array],
                default: function () {
                    return [];
                }
            },
            icon: {
                type: String,
                default: ''
            },
            title: {
                type: String,
                default: ''
            },
            to: {
                type: String,
                default: ''
            },
            type: {
                type: String,
                default: 'link'
            },
            itemClass: {
                type: String,
                default: 'col-4'
            }
        },
        methods: {
            handleClick() {
                if (this.type === 'link') {
                    this.$router.push(this.to);
                }
                if (this.type === 'button') {
                    this.$emit('click');
                }
            },
        },
        computed: {
            checkAccess() {
                if (this.permission.length === 0) {
                    return this.to !== '' ? this.hasAccessToRoute(this.to) : true;
                } else {
                    return this.hasAccess(this.permission);
                }
            }
        }
    }
</script>