<template>
    <label class="btn btn-primary">
        <input type="checkbox"
               class="mr-2"
               :value="value"
               :checked="checked"
               @change="$emit('change', $event.target.checked)">
        {{label}}
    </label>

</template>

<script>
    export default {
        props: [
            'label',
            'checked',
            'value'
        ],
        model: {
            prop: 'checked',
            event: 'change'
        },
        data() {
            return {};
        },
    }
</script>
<style scoped>
    input {
        vertical-align: -3px
    }
</style>