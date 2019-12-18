<template>
    <div class="form-group">
        <select class="select2" style="width:100% !important;" @change="handleChange" multiple="multiple">
        </select>
        <div class="text-center" v-if="hasValue && this.delete === true">
            <ui-button title="حذف" icon="delete" class="m-t-10" @click="clearValue()"/>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            options: {
                type: Array,
                default: function () {
                    return []
                }
            },
            value: {
                type: [String, Number],
                default: 0
            },
            placeholder: {
                type: String,
                default: '--- انتخاب ---'
            },
            dir: {
                type: String,
                default: 'rtl'
            },
            delete: {
                type: Boolean,
                default: true
            }
        },
        mounted() {
            let vm = this;
            $(this.$el).find('select')
                .select2({
                    data: this.options,
                    dir: this.dir,
                    placeholder: this.placeholder
                })
                .val(this.value)
                .trigger('change')
                .on('change', function () {
                    vm.$emit('input', this.value);
                    vm.$emit('update:value', this.value);
                });
        },
        updated() {
            // $(this.$el).find('select').val(this.value).trigger('change');
        },
        methods: {
            clearValue() {
                $(this.$el).find('select').val(null).trigger('change');
            },
            handleChange(event) {
                this.$emit('change');
            },

        },
        watch: {
            value: function (value) {
                //this.$emit('input', this.value);
                $(this.$el).find('select').val(value).trigger('change');
            },
            options: function (value) {
                let vm = this;
                $(this.$el).find('select')
                    .select2({
                        data: this.options,
                        dir: this.dir,
                        placeholder: this.placeholder
                    })
                    .val(this.value)
                    .trigger('change')
                    .on('change', function () {
                        vm.$emit('input', this.value);
                        vm.$emit('update:value', this.value);
                    });
            }
        },
        computed: {
            hasValue() {
                return this.value !== null && this.value !== '';
            }
        },
        destroyed: function () {
            $(this.$el).find('select').off().select2('destroy')
        },

    }
</script>