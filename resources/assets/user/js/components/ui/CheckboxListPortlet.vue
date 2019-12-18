<template>
    <portlet :title="title">
        <div class="listview listview-checkbox row">
            <div :class="`listview__item ${itemClass}`" v-for="item in items">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox"
                           class=""
                           :key='item.id'
                           :value="item.id"
                           v-model="selectedItems"
                           :disabled="disabled"
                           @change="updateValue"/>
                    <span class="custom-control-indicator"></span>
                    <span class="cursor-pointer">{{ item.title }}</span>
                </label>
            </div>
        </div>
    </portlet>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: ''
            },
            items: {
                type: [Array],
                default: function () {
                    return [];
                }
            },
            value: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            itemClass: {
                type: String,
                default: 'col-md-12'
            },
            disabled: {
                type: Boolean,
                default:  false
            }
        },
        data() {
            return {
                selectedItems: this.value || []
            };
        },
        methods: {
            updateValue() {
                this.$emit('input', this.selectedItems);
                this.$emit('update', this.selectedItems);
            }
        },
        mounted() {
        },
        watch: {
            value: function (newVal) {
                this.selectedItems = newVal;
            },
        }
    }
</script>