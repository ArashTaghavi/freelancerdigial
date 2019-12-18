<template>
    <div :class="wrapperClass">
        <label v-if="label.length > 0">{{ label }}</label>
        <slot></slot>
        <i class="form-group__bar"></i>
        <span v-if="icon.length > 0" class="input-group-addon">
            <i :class="`icon-${icon}`"></i>
        </span>
    </div>
</template>

<script>
    export default {
        name: "InputWrapper",
        props: {
            label: {
                type: String,
                default: ''
            },
            hasError: {
                type: Boolean,
                default: false
            },
            value: {
                type: String,
                default: ''
            },
            icon: {
                type: String,
                default: ''
            },
            labelSpan: {
                type: String,
                default: '2'
            },
            inputSpan: {
                type: String,
                default: '10'
            },
            round: {
                type: Boolean,
                default: true
            },
        },
        computed: {
            labelClass() {
                let labelClassObj = [];
                labelClassObj.push(`col-md-${this.labelSpan}`);
                return labelClassObj;
            },
            wrapperClass() {
                let wrapperClassObj = [];
                wrapperClassObj.push('form-group');
                //wrapperClassObj.push('row');
                if (this.hasError) {
                    wrapperClassObj.push('is-invalid');
                }
                return wrapperClassObj;
            },
            inputWrapperClass() {
                let inputWrapperClassObj = [];
                inputWrapperClassObj.push('input-group');
                // inputWrapperClassObj.push(`col-md-${this.inputSpan}`);
                if (this.round) {
                    //inputWrapperClassObj.push('round');
                }
                return inputWrapperClassObj;
            },
        }
    }
</script>

<style scoped>

</style>