<template>
    <router-link v-if="visible && checkAccess" :to="to" class="dropdown-item text-center">
        <slot></slot>
    </router-link>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'link'
            },
            permission: {
                type: [String, Array],
                default: function () {
                    return [];
                }
            },
            visible: {
                type: Boolean,
                default: true
            },
            to: {
                type: String,
                default: ''
            },
            items: {
                type: Array
            }
        },
        computed: {
            checkAccess() {
                if (this.permission.length === 0) {
                    return true;
                } else {
                    return this.hasAccess(this.permission);
                }
            }
        },
        methods: {}
    }

</script>