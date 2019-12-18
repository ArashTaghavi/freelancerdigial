<template>
    <button @click.prevent="$emit('click')" :class="`btn btn-${type} btn-${size}`">
        {{title}}
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'primary'
            },
            size: {
                type: String,
                default: 'sm'
            },
            title: {
                type: String,
                default: ''
            }
        }
    }

</script>
<style>
    button {
        cursor: pointer;
    }
</style>