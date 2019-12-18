<template>
    <div>
        <vuetable ref="vuetable"
                  :api-url="apiUrl"
                  :fields="fields"
                  pagination-path=""
                  :per-page="perPage"
                  :css="dataTableCss.table"
                  :sort-order="sortOrder"
                  :multi-sort="true"
                  no-data-template="<div class='alert alert-info'>نتیجه ای یافت نشد.</div>"
                  :http-fetch="(apiUrl, httpOptions) => this.dataTableHttpFetch(apiUrl, httpOptions)"
                  :http-options="dataTableHttpOptions"
                  :append-params="moreParams"
                  @vuetable:pagination-data="onPaginationData"
        />
    </div>
</template>

<script>
    export default {
        props: {
            apiUrl: {
                type: String,
                default: ''
            },
            fields: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            sortOrder: {
                type: Array,
                default: function () {
                    return [
                        {
                            field: 'created_at',
                            sortField: 'created_at',
                            direction: 'desc'
                        }
                    ];
                }
            },
            moreParams: {
                type: Object,
                default: function () {
                    return {};
                }
            },
            perPageSelector: {
                type: Boolean,
                default: true
            }
            /*perPage: {
                type: Number,
                default: 20
            }*/
        },
        data() {
            return {
                dataTableHttpOptions: {
                    headers: {
                        //Authorization: 'Bearer ' + this.$auth.token()
                    }
                },
                dataTableCss: {
                    table: {
                        tableClass: 'table table-striped table-condensed table-hover',
                        ascendingIcon: 'zmdi zmdi-long-arrow-up',
                        descendingIcon: 'zmdi zmdi-long-arrow-down'
                    },
                    icons: {
                        first: 'glyphicon glyphicon-step-backward',
                        prev: 'glyphicon glyphicon-chevron-left',
                        next: 'glyphicon glyphicon-chevron-right',
                        last: 'glyphicon glyphicon-step-forward',
                    },
                },
                perPage: 10
            };
        },
        methods: {
            refreshDataTable() {
                let vm = this;
                Vue.nextTick(function () {
                    vm.$refs.vuetable.refresh();
                });
            },
            refresh() {
                let vm = this;
                Vue.nextTick(function () {
                    vm.$refs.vuetable.refresh();
                });
            },
            onPaginationData(paginationData) {
                this.$parent.$refs.pagination.$refs.pagination.setPaginationData(paginationData);
                this.$parent.$refs.pagination.$refs.paginationInfo.setPaginationData(paginationData);
                // this.$parent.$refs.pagination.$refs.paginationDropdown.setPaginationData(paginationData);
            },
            dataTableHttpFetch(apiUrl, httpOptions) {
                return axios.get(apiUrl, httpOptions);
            },
            changePerPage(perPage) {
                this.perPage = perPage;
                this.refresh();
            }
        }
    }
</script>
