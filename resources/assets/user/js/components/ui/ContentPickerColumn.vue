<template>
    <span @click="$parent.$events.fire('change-selected', rowData)"
          class="picker-title-column">{{ rowData.title }}</span>
</template>

<script>
    export default {
        props: {
            rowData: {
                type: Object,
                required: true
            },
            rowIndex: {
                type: Number
            }
        }
    }
</script>

<style scoped>
    .picker-title-column {
        cursor: pointer;
    }
</style>