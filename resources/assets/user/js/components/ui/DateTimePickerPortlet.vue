<template>
    <div>
        <portlet-button slot="buttons" icon="delete" title="حذف" @click="clearValue" v-if="hasValue && reset"/>
        <ui-input v-model="date" :id="_uid.toString()" :rtl="false" :placeholder="title"/>
        <date-picker v-model="date" :type="type" :element="_uid.toString()" :min="min" :color="color"/>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: 'تاریخ'
            },
            reset: {
                type: Boolean,
                default: false
            },
            type: {
                type: String,
                default: 'datetime'
            },
            value: {
                type: [String, Array],
                default: ''
            },
            min: {
                type: String,
                default: ''
            },
            color: {
                type: String,
                default: '#0F1D34'
            }
        },
        data() {
            return {
                date: this.value !== null ? this.value : ''
            }
        },
        methods: {
            clearValue() {
                this.$emit('input', '');
                this.date = '';
            }
        },
        computed: {
            hasValue() {
                return this.value !== null && this.value !== '';
            }
        },
        watch: {
            date: function (newValue) {
                this.$emit('input', newValue);
            }
        }
    }
</script>