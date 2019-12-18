<template>
    <div :id="id" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div :class="getModalSize">
            <div class="modal-content">
                <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" @click="$emit('dismiss')">&times;</button>-->
                    <h5 class="modal-title">{{ title }}</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12" v-if="contentIcon.length > 0">
                        <p class="text-center m-t-30 m-b-40">
                            <i :class="`icon-${contentIcon} border border-primary img-circle text-primary font-xxxlg p-20`"></i>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <slot></slot>
                        </div>
                    </div>
                </div>

                <div v-if="showFooter" class="modal-footer text-center">
                    <!--<submit-button @click.prevent="$emit('submit')" />-->
                    <!--<ui-button icon="arrow-right" title="انصراف" />-->
                    <!--<back-button @click.prevent="$emit('dismiss')" />-->
                    <ui-button
                            v-if="showCancelButton"
                            icon="arrow-right"
                            data-dismiss="modal"
                            :showText="true"
                            :title="cancelText"
                            :is-loading="isLoading"
                            @click="$emit('dismiss')"/>
                    <ui-button
                            v-if="showSubmitButton"
                            type="light"
                            icon="check"
                            :showText="true"
                            :title="submitText"
                            :is-loading="isLoading"
                            @click="$emit('submit')"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            id: {
                type: String,
                default: 'modal'
            },
            title: {
                type: String,
                default: null
            },
            showCancelButton: {
                type: Boolean,
                default: true
            },
            showSubmitButton: {
                type: Boolean,
                default: true
            },
            submitText: {
                type: String,
                default: 'ثبت اطلاعات'
            },
            cancelText: {
                type: String,
                default: 'انصراف'
            },
            isLoading: {
                type: Boolean,
                default: false
            },
            contentIcon: {
                type: String,
                default: ''
            },
            showFooter: {
                type: Boolean,
                default: true
            },
            size: {
                type: String,
                default: ''
            }
        },
        watch: {
            isLoading: function (newValue) {
                if (newValue === true) {
                    $(this.$el).block({
                        message: '<div class="lds-css ng-scope"><div class="lds-spinner" style="100%;height:100%"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>'
                    });
                }
                if (!newValue) {
                    $(this.$el).unblock();
                }
            }
        },
        computed: {
            getModalSize() {
                let _classObject = [];
                _classObject.push('modal-dialog');
                if (this.size !== '') {
                    _classObject.push(`modal-${this.size}`);
                }
                return _classObject;
            }
        }
    }
</script>