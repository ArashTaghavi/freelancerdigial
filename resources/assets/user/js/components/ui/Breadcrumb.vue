<template>
    <div class="card">
        <div class="card-body">
            <ul class="list-inline">
                <li class="list-inline-item"><router-link :to="home.to">{{ home.title }}</router-link></li>
                <li class="list-inline-item" v-for="item in items">
                    / <router-link :to="item.to" exact-active-class="active">{{ item.title }}</router-link>
                </li>
                <li class="list-inline-item" v-if="current !== home.title"> / <a class="active">{{ current }}</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Breadcrumb',
        props: {
            home: {
                type: Object,
                default: function () {
                    return {
                        to: '/',
                        title: 'داشبورد'
                    };
                }
            },
            items: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            current: {
                type: String,
                default: ''
            }
        }
    }
</script>