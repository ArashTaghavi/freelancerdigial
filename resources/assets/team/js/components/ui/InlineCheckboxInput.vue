<template>
    <label class="custom-checkbox" style=";margin:15px 5px;">
        <input type="checkbox"
               class=""
               :value="value"
               :checked="checked"
               @change="$emit('change', $event.target.checked)">
        <span class="custom-control-indicator"></span>
        <span class="custom-control-description">{{ label }}</span>
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