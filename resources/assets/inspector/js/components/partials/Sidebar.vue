<template>
    <aside class="aside-container">
        <!-- START Sidebar (left)-->
        <div class="aside-inner">
            <nav class="sidebar" data-sidebar-anyclick-close="">
                <!-- START sidebar nav-->
                <ul class="sidebar-nav">
                    <!-- START user info-->
                    <li class="has-user-block">
                        <div class="collapse" id="user-block">
                            <div class="item user-block">
                                <!-- User picture-->
                                <div class="user-block-picture">
                                    <div class="user-block-status">
                                        <img class="img-thumbnail rounded-circle"
                                             :src=profile_image
                                             alt="Avatar" width="60" height="60">
                                        <div class="circle bg-success circle-lg"></div>
                                    </div>
                                </div>
                                <!-- Name and Job-->
                                <div class="user-block-info">
                                    <span class="user-block-name">{{user.first_name}} {{user.last_name}}</span>
                                    <!--<span class="user-block-role"></span>-->
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- END user info-->
                    <!-- Iterates over all sidebar items-->
                    <li class="nav-heading ">
                        <span data-localize="sidebar.heading.HEADER">منوی اصلی</span>
                    </li>
                    <li class=" ">
                        <router-link to="/">
                            <em class="icon-speedometer"></em>
                            <span data-localize="sidebar.nav.WIDGETS">داشبورد</span>
                        </router-link>
                    </li>
                    <li class=" ">
                        <router-link to="/profile">
                            <em class="icon-user"></em>
                            <span data-localize="sidebar.nav.WIDGETS">پروفایل</span>
                        </router-link>
                    </li>
                    <li class=" ">
                        <router-link to="/companies">
                            <em class="icon-user"></em>
                            <span data-localize="sidebar.nav.WIDGETS">شرکت ها</span>
                        </router-link>
                    </li>
                    <li class=" ">
                        <router-link to="/teams">
                            <em class="icon-user"></em>
                            <span data-localize="sidebar.nav.WIDGETS">تیم ها</span>
                        </router-link>
                    </li>
                </ul>
                <!-- END sidebar nav-->
            </nav>
        </div>
        <!-- END Sidebar (left)-->
    </aside>
</template>

<script>
    export default {
        name: "Sidebar",
        data() {
            return {
                user: {},
                profile_image: ''
            }
        },
        created() {
            this.user = JSON.parse(localStorage.getItem('user_info'));
            this.profile_image = this.user.profile_image !== null ? this.user.profile_image : '/panel-assets/img/user/02.jpg'
        }

    }
</script>

<style scoped>

</style>
