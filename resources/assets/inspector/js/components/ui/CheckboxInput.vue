<template>
    <label class="custom-control custom-checkbox" style="margin-left: 0;display:block;margin-top:15px;margin-bottom:15px;">
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