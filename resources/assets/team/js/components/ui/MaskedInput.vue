<template>
    <div class="form-group">
        <label v-if="label !== ''">{{ label }}</label>
        <input class="form-control text-center"
               dir="ltr"
               :placeholder="placeholder"
               :disabled="disabled"
               v-bind:value="value"/>
        <i class="form-group__bar"></i>
    </div>
</template>

<script>
    export default {
        props: {
            label: {
                type: [String, Number],
                default: ''
            },
            placeholder: {
                type: String,
                default: ''
            },
            mask: {
                type: String,
                default: '0000'
            },
            disabled: {
                type: Boolean,
                default: false
            },
            options: {
                type: Object,
                default: function () {
                    let vm = this;
                    return {
                        onChange: function (value) {
                            vm.updateValue(value);
                        },
                    };
                }
            },
            value: {
                type: String,
                default: ''
            }
        },
        methods: {
            updateValue(value) {
                this.$emit('input', value);
            }
        },
        mounted() {
            $(this.$el).find('input').mask(this.mask, this.options);
        }
    }
</script>