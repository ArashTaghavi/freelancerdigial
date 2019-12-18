<template>
    <div class="form-group">
        <label v-if="label !== ''">{{ label }}</label>
        <input :type="type"
               class="form-control text-center "
               :placeholder="placeholder"
               @input="handleInput"
               @blur="handleBlue"
               :dir="direction"
               :maxlength="maxlength"
               :disabled="disabled"
               v-bind:value="value"/>
        <i class="form-group__bar"></i>
    </div>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'text'
            },
            label: {
                type: [String, Number],
                default: ''
            },
            placeholder: {
                type: [String, Number],
                default: ''
            },
            value: {
                type: [String, Number],
                default: ''
            },
            disabled: {
                type: Boolean,
                default: false
            },
            rtl: {
                type: Boolean,
                default: true
            },
            maxlength: {
                type: String,
                default: null
            }
        },
        methods: {
            handleInput(event) {
                this.$emit('input', event.target.value);
            },
            handleBlue(event) {
                this.$emit('blur', event);
            }
        },
        computed: {
            direction: function () {
                return this.rtl ? 'rtl' : 'ltr';
            }
        }
    }
</script>

