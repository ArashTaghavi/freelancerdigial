<template>
    <input type="text"
           class="form-control"
           v-bind:value="value"
           v-on:input="updateValue"
           v-on:blur="updateValue"
           :placeholder="placeholder">
</template>

<script>
    export default {
        name: 'date-picker-input',
        props: {
            placeholder: {
                type: String,
                default: 'انتخاب تاریخ'
            },
            value: {
                type: String,
                default: ''
            }
        },
        methods: {
            updateValue(event) {
                this.$emit('input', event.target.value);
            }
        },
        mounted() {
            let datePickerOptions = {
                placeholder: this.placeholder,
                twodigit: true,
                closeAfterSelect: true,
                nextButtonIcon: "fa fa-arrow-right",
                previousButtonIcon: "fa fa-arrow-left",
                buttonsColor: "gray",
                markToday: true,
                markHolidays: true,
                highlightSelectedDay: true,
                sync: true
            };
            let number = Math.random();
            number.toString(36);
            let id = number.toString(36).substr(2, 9);
            $(this.$el).attr('id', id);
            kamaDatepicker(`${id}`, datePickerOptions);
        }
    }
</script>