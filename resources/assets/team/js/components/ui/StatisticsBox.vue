<template>
    <div :class="containerClass">
        <router-link v-if="this.to !== ''" :to="to">
            <div class="quick-stats__item cursor-pointer">
                <div class="quick-stats__info">
                    <h2 v-text="content"></h2>
                    <small>{{ label }}</small>
                </div>
            </div>
        </router-link>
        <div v-if="this.to === ''" class="quick-stats__item">
            <div class="quick-stats__info">
                <h2 v-text="content"></h2>
                <small>{{ label }}</small>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                serverValue: ''
            }
        },
        computed: {
            classObject() {
                let classObject = [];
                classObject.push('');
                return classObject;
            },
            content() {
                if (this.value !== '') {
                    return this.value;
                } else {
                    if (this.apiUrl !== '') {
                        axios.get(this.apiUrl).then(response => {
                            this.serverValue = response.data;
                        });
                        return this.serverValue;
                    }
                }
            }
        },
        props: {
            label: {
                type: [String, Number],
                default: ''
            },
            value: {
                type: [String, Number],
                default: ''
            },
            icon: {
                type: String,
                default: ''
            },
            to: {
                type: String,
                default: ''
            },
            apiUrl: {
                type: String,
                default: ''
            },
            containerClass: {
                type: String,
                default: 'col-md-3 col-xs-6 xxs-full-width'
            }
        },
        created() {
        }
    }
</script>