<template>
    <input type="text"
           :placeholder="placeholder"
           v-bind:value="value"
           v-on:input="updateValue"
           v-on:blur="updateValue"
           class="form-control clockpicker-autoclose">
</template>

<script>
    export default {
        props: {
            placeholder: {
                type:String,
                default: 'انتخاب ساعت'
            },
            value: {
                type: String,
                default: ''
            }
        },
        methods: {
            updateValue(event){
                this.$emit('input', event.target.value);
            }
        },
        mounted() {
            $(this.$el).clockpicker({
                "donetext": "قبول",
                autoclose: true
            });
        }
    }
</script>