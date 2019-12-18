<template>
    <div class="vuetable-pagination bg-light card card-body">
        <vuetable-pagination-info ref="paginationInfo"  :info-template="dataTablePaginationTemplate"
                                  info-class="pagination-info" no-data-template=""/>
        <vuetable-pagination ref="pagination" :css="paginationCss" @vuetable-pagination:change-page="onChangePage"/>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                dataTablePaginationTemplate: "<strong>نمایش نتایج:</strong> {from} تا {to} <br/> <strong>تعداد کل نتایج:</strong> {total}",
                paginationCss: {
                    infoClass: 'text-center',
                    wrapperClass: 'vuetable-pagination text-center',
                    activeClass: 'btn-primary btn-xs text-white',
                    disabledClass: 'disabled',
                    pageClass: 'btn btn-border btn-xs',
                    linkClass: 'btn btn-border btn-xs',
                    icons: {
                        first: '',
                        prev: '',
                        next: '',
                        last: ''
                    },
                },
            };
        },
        methods: {
            onChangePage(page) {
                this.$parent.$refs.dataTable.$refs.vuetable.changePage(page);
            },
        }
    }
</script>