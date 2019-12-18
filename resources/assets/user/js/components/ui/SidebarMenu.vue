<template>
    <ul class="metismenu" :id="id" style="height: 100%">
        <li v-for="item in items"
            v-if="item.visible"
            :class="[{ active : isOpened(item) }, { open : isOpened(item) }]"
            @click.prevent="parentItemClicked">

            <router-link v-if="!hasChild(item)" :to="item.route" active-class="current">
                <i :class="`icon-${item.icon}`"></i>
                <span>{{ item.title }}</span>
            </router-link>

            <a v-if="hasChild(item)" class="dropdown-toggle" data-toggle="dropdown">
                <i :class="`icon-${item.icon}`"></i>
                <span>{{ item.title }}</span>
            </a>

            <ul v-if="hasChild(item)" :class="[{'collapse' : true}, {'in': isOpened(item)}]">
                <li v-for="child in item.children" v-if="child.visible">
                    <router-link :to="child.route" exact-active-class="current">
                        <i :class="`icon-${child.icon}`"></i>
                        <span>{{ child.title }}</span>
                    </router-link>
                </li>
            </ul>
        </li>
    </ul>
</template>

<script>
    export default {
        props: {
            items: {
                type: Array,
                default: [
                    {
                        title: '',
                        icon: '',
                        route: ''
                    }
                ]
            },
            id: {
                type: String,
                default: 'side-menu'
            }
        },
        methods: {
            hasChild(item) {
                return item.hasOwnProperty('children');
            },
            isOpened(item) {
                if (this.hasChild(item)) {
                    let isActive = false;
                    item.children.forEach(item => {
                        if (item.route == this.$route.path) {
                            isActive = true;
                        }
                    });
                    return isActive;
                }
                return false;
            },
            parentItemClicked(event) {
                /*let parentElement = event.target.parentElement;
                let liElement = $(parentElement).closest('li');
                if (liElement.hasClass('open')) {
                } else {
                }*/
            },
        },
        created() {
            this.items.forEach(item => {
                if (this.hasChild(item)) {
                    item.opened = this.isOpened(item);
                }
                if (item.hasOwnProperty('route')) {
                    item.visible = this.hasAccessToRoute(item.route);
                }
                if (item.hasOwnProperty('children')) {
                    item.visible = false;
                    item.children.forEach(child => {
                        if (this.hasAccessToRoute(child.route)) {
                            item.visible = true;
                            child.visible = true;
                        } else {
                            child.visible = false;
                        }
                    });
                }
            });
        },
        mounted() {
            if (typeof metisMenu !== "undefined") {
                $(this.$el).metisMenu({
                    toggle: true
                });
            }
        }
    }
</script>