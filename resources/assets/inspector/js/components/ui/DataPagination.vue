<template>
    <div>
        <div>{{ current_page }}</div>
        <div>{{ from }}</div>
        <div>{{ to }}</div>
        <div>{{ last_page }}</div>
        <div>{{ per_page }}</div>
        <div>{{ total }}</div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                current_page: null,
                from: null,
                to: null,
                last_page: null,
                per_page: null,
                total: null
            }
        },
        props: {
            data: {
                type: Object
            }
        },
        created() {
            this.current_page = this.data.current_page;
            this.from = this.data.from;
            this.to = this.data.to;
            this.last_page = this.data.last_page;
            this.per_page = this.data.per_page;
            this.total = this.data.total;
        }
    }
</script>