<template>
    <portlet :title="title" :animated="false">
        <portlet-button key="cpp-01" slot="buttons" type="light" icon="delete" title="حذف" @click="reset" v-if="enablePicker"/>
        <portlet-button key="cpp-02" slot="buttons" type="light" icon="plus" title="افزودن" @click="showPicker" v-if="!enablePicker"/>

        <div v-if="enablePicker">
            <input type="text"
                   readonly
                   v-model="selectedTitle"
                   class="form-control content-picker text-center"
                   @click="openPickerModal"
                   :placeholder="placeholder"/>

            <modal title="انتخاب محتوا" id="content-picker-modal" submit-text="انتخاب محتوا" size="lg" :show-submit-button="true" v-on:submit="handleSubmit">
                <radio-list :items="linkableTypes" v-model="selectedType" item-class="col-md-3"/>
                <ui-input v-model="contentTitle" placeholder="عنوان محتوا" @blur="handleTitleChange" class="m-t-20"/>
                <vuetable ref="vuetable"
                          :api-url="getApiUrl"
                          :fields="fields"
                          pagination-path=""
                          :per-page="10"
                          :css="dataTableCss.table"
                          :sort-order="sortOrder"
                          :multi-sort="true"
                          :http-fetch="(apiUrl, httpOptions) => this.dataTableHttpFetch(apiUrl, httpOptions)"
                          no-data-template="<div class='alert alert-info'>نتیجه ای یافت نشد.</div>"
                          :append-params="moreParams"
                          @vuetable:pagination-data="onPaginationData"/>

                <vuetable-pagination-info ref="paginationInfo" :info-template="dataTablePaginationTemplate"
                                          info-class="pagination-info"/>

                <vuetable-pagination ref="pagination" :css="paginationCss" @vuetable-pagination:change-page="onChangePage"/>

                <div v-if="id != null" class="alert alert-dark text-right m-t-20">
                    <span>محتوای انتخاب شده: </span><strong>{{ selectedTitle }}</strong>
                </div>
            </modal>
        </div>


    </portlet>
</template>

<script>
    import PickerColumn from './ContentPickerColumn'

    Vue.component('content-picker-column', PickerColumn);

    export default {
        data() {
            return {
                type: null,
                id: null,
                linkableTypes: [],
                selectedType: '',
                contentTitle: '',
                dataTableCss: {
                    table: {
                        tableClass: 'table table-striped table-hover',
                        ascendingIcon: 'icon-arrow-up',
                        descendingIcon: 'icon-arrow-down'
                    },
                    icons: {
                        first: 'glyphicon glyphicon-step-backward',
                        prev: 'glyphicon glyphicon-chevron-left',
                        next: 'glyphicon glyphicon-chevron-right',
                        last: 'glyphicon glyphicon-step-forward',
                    },
                },
                dataTablePaginationTemplate: "",
                paginationCss: {
                    wrapperClass: 'pagination',
                    activeClass: 'active',
                    disabledClass: 'disabled',
                    pageClass: 'paginate_button',
                    linkClass: 'paginate_button',
                    icons: {
                        first: '',
                        prev: '',
                        next: '',
                        last: ''
                    },
                },
                fields: [
                    {
                        name: '__sequence',
                        title: '#',
                        titleClass: 'text-right',
                        dataClass: 'text-right'
                    },
                    {
                        name: '__component:content-picker-column',
                        title: '<strong class="icon-pencil"></strong>',
                        titleClass: 'text-right',
                        dataClass: 'text-right'
                    }
                ],
                sortOrder: [
                    {field: 'id', sortField: 'id', direction: 'desc'}
                ],
                selectedTitle: null,
                enablePicker: this.notEmpty,
                moreParams: {}
            };
        },
        props: {
            title: {
                type: String,
                default: 'محتوای مقصد'
            },
            placeholder: {
                type: String,
                default: 'برای انتخاب محتوا کلیک کنید.'
            },
            linkableTitle: {
                type: String,
                default: null
            },
            linkableType: {
                type: String,
                default: null
            },
            linkableId: {
                type: [String, Number],
                default: null
            },
            languageId: {
                type: Number,
                default: 1
            }
        },
        computed: {
            getApiUrl() {
                return `/base/select-content/${this.languageId}`;
            },
            notEmpty() {
                return this.type !== null && this.id !== null;
            }
        },
        methods: {
            openPickerModal() {
                $(this.$el).find('.modal').modal('show');
            },
            closePickerModal() {
                $(this.$el).find('.modal').modal('hide');
            },
            refreshDataTable() {
                let vm = this;
                Vue.nextTick(function () {
                    vm.$refs.vuetable.refresh();
                });
            },
            onPaginationData(paginationData) {
                this.$refs.pagination.setPaginationData(paginationData);
                this.$refs.paginationInfo.setPaginationData(paginationData);
            },
            dataTableHttpFetch(apiUrl, httpOptions) {
                return axios.get(apiUrl, httpOptions);
            },
            onChangePage(page) {
                this.$refs.vuetable.changePage(page);
            },
            handleTypeChange(value) {
                this.type = value;
                this.moreParams.type = value;
                this.refreshDataTable();
            },
            handleTitleChange(event) {
                this.moreParams.filter.title = event.target.value;
                this.refreshDataTable();
            },
            handleSubmit() {
                this.$events.fire('submit-data');
            },
            reset() {
                this.type = null;
                this.id = null;
                this.selectedTitle = null;
                this.$events.fire('submit-data');

                this.enablePicker = false;
            },
            showPicker() {
                this.enablePicker = true;
            }
        },
        watch: {
            selectedType: function (newValue) {
                this.handleTypeChange(newValue);
            }
        },
        created() {
            axios.get('/base/linkable-types').then(response => this.linkableTypes = response.data);
            this.moreParams = {
                type: this.type,
                filter: {
                    title: this.contentTitle
                }
            };

            if (this.linkableTitle !== null && this.linkableType !== null && this.linkableId !== null) {
                this.type = this.linkableType;
                this.id = this.linkableId;
                this.selectedTitle = this.linkableTitle;
                this.showPicker();
            }
        },
        events: {
            'change-selected'(rowData) {
                this.id = rowData.id;
                this.selectedTitle = rowData.title;
            },
            'submit-data'() {
                this.$emit('change-type', this.type);
                this.$emit('change-id', this.id);
                this.closePickerModal();
            }
        }
    }
</script>

<style scoped>
    .content-picker {
        cursor: pointer;
        font-size: 11px;
    }
</style>