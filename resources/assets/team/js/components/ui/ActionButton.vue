<template>
    <button v-if="visible && checkAccess" @click.prevent="$emit('click')" class="dropdown-item text-center">
        <slot></slot>
    </button>
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
                    return this.hasAccess(this.permissions);
                }
            }
        }
    }

</script>
<style>
    button {
        cursor: pointer;
    }
</style>