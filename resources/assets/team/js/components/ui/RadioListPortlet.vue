<template>
    <portlet :title="title">
        <div class="listview listview-checkbox row">
            <div :class="getItemClass" v-for="item in items">
                <label class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" :key='item.id' :value="item.id" v-model="selectedItems" :disabled="disabled" @change="updateValue"/>
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
                type: Array,
                default: function () {
                    return [];
                }
            },
            value: {
                type: [Number, String],
                default: 0
            },
            itemClass: {
                type: String,
                default: 'col-md-12 no-margin'
            },
            disabled: {
                type: Boolean,
                default: false
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
            }
        },
        computed: {
            getItemClass(){
                let _classObject = [];
                _classObject.push('listview__item');
                _classObject.push('no-margin');
                _classObject.push(this.itemClass);
                return _classObject;
            }
        },
        watch: {
            value: function (newVal) {
                this.selectedItems = newVal;
            },
        }
    }
</script>