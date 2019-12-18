<template>
    <portlet :title="title">
        <portlet-button key="tp-01" slot="buttons" icon="plus" title="افزودن" v-if="!showInput" @click="() => { this.showInput = true }"/>
        <portlet-button key="tp-02" slot="buttons" icon="delete" title="حذف تمام برچسب ها" v-if="showInput" @click="clearTags"/>

        <tags-input v-if="showInput" v-model="tagsString" :tags="value" placeholder="افزودن برچسب" @tags-changed="updateTags"/>
    </portlet>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: 'برچسب ها'
            },
            reset: {
                type: Boolean,
                default: false
            },
            value: {
                type: Array
            }
        },
        data() {
            return {
                tagsString: '',
                showInput: false
            }
        },
        methods: {
            updateTags(newTags) {
                this.$emit('input', newTags);
            },
            clearTags() {
                this.$emit('input', []);
                this.showInput = false;
            }
        },
        computed: {
            hasValue() {
                return this.value.length > 0;
            }
        },
        watch: {
            value: function (newValue) {
                if (newValue.length > 0) {
                    this.showInput = true;
                } else {
                    this.showInput = false;
                }
            }
        }
    }
</script>