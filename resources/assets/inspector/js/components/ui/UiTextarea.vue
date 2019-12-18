<template>
    <div class="form-group">
        <label v-if="label !== ''">{{ label }}</label>
        <textarea
                class="form-control text-center textarea-autosize"
                :placeholder="placeholder"
                @input="updateValue"
                @blur="updateValue"
                :disabled="disabled"
                rows="4"
                v-bind:value="value"></textarea>
        <i class="form-group__bar"></i>
    </div>
</template>

<script>
    export default {
        props: {
            label: {
                type: String,
                default: ''
            },
            placeholder: {
                type: String,
                default: ''
            },
            value: {
                type: [String, Number],
                default: ''
            },
            disabled:{
                type: Boolean,
                default: false
            }
        },
        methods: {
            updateValue(event) {
                this.$emit('input', event.target.value);
            }
        },
        mounted() {
           // autosize($(this.$el).find('textarea'));
        }
    }
</script>

