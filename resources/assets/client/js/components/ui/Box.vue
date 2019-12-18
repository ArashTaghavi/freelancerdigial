<template>
    <div class="card flex-row align-items-center align-items-stretch border-0">
        <div :class="`col-12 py-3 bg-${type} rounded-right`">
            <div class="h4 mt-0">{{title}}</div>
            <div class="text-uppercase">{{text}}</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Box",
        props: {
            text: {
                type: String,
                default: 'Text'
            },
            title: {
                type: String,
                default: 'Title'
            },
            type: {
                type: String,
                default: 'primary'
            }

        }
    }
</script>

<style scoped>

</style>