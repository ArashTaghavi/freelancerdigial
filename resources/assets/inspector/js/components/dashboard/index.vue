<template>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dashboard</h3>
            </div>
            <div class="card-body">Dashboard Content</div>
        </div>
</template>

<script>
    export default {
        data() {
            return {
                companies: []
            }
        },
        async mounted() {
            this.companies = await this.getCompanies();
        },
        methods: {
            async getCompanies() {
                let {data} = axios.get('/api/user/companies');
                return data;
            }
        }
    }
</script>
