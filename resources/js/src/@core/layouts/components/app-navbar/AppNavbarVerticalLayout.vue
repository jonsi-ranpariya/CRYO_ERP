<template>
    <div class="navbar-container d-flex content align-items-center">

        <!-- Nav Menu Toggler -->
        <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item">
                <b-link
                    class="nav-link"
                    @click="toggleVerticalMenuActive"
                >
                    <feather-icon
                        icon="MenuIcon"
                        size="21"
                    />
                </b-link>
            </li>
        </ul>

        <!-- Left Col -->
        <div class="bookmark-wrapper align-items-center flex-grow-1 d-none d-lg-flex">

            <!-- Bookmarks Container -->
            <bookmarks/>
            <b-navbar-nav class="nav align-items-center mr-auto">
                <b-nav-item id="currentTime">
<!--                    <feather-icon
                        slot="button-content"
                        icon="ClockIcon"
                        size="21"
                    >
                    </feather-icon>-->
                    <p style="margin-top: 15px" class="text-muted">{{ dateTime }}</p>
<!--                    <b-tooltip
                        triggers="hover"
                        target="currentTime"
                        :title=""
                    />-->
                </b-nav-item>
            </b-navbar-nav>
        </div>

        <b-navbar-nav class="nav align-items-center ml-auto">
            <!--<locale />-->
            <!--<dark-Toggler class="d-none d-lg-block" />-->

            <!-- <app-auto-log-out />-->
            <search-bar/>
            <!--<cart-dropdown />-->
            <notification-dropdown/>
            <user-dropdown/>
        </b-navbar-nav>
    </div>
</template>

<script>
    import {
        BLink, BNavbarNav,BNavbar,BNavItem,BTooltip
    } from 'bootstrap-vue'
    import Bookmarks from './components/Bookmarks.vue'
    import Locale from './components/Locale.vue'
    import SearchBar from './components/SearchBar.vue'
    import DarkToggler from './components/DarkToggler.vue'
    import CartDropdown from './components/CartDropdown.vue'
    import NotificationDropdown from './components/NotificationDropdown.vue'
    import UserDropdown from './components/UserDropdown.vue'
    import {ref} from '@vue/composition-api'
    import moment from 'moment'
    import AppAutoLogOut from '@core/layouts/components/app-navbar/AppAutoLogOut.vue'

    export default {
        components: {
            AppAutoLogOut,
            BLink,
            BNavbar,
            BNavItem,

            // Navbar Components
            BNavbarNav,
            BTooltip,
            Bookmarks,
            Locale,
            SearchBar,
            DarkToggler,
            CartDropdown,
            NotificationDropdown,
            UserDropdown,
        },
        props: {
            toggleVerticalMenuActive: {
                type: Function,
                default: () => {
                },
            },
        },
        setup(){
            const dateTime = ref(null)

            setInterval(() => {
                dateTime.value = moment(new Date()).format('DD-MM-YYYY hh:mm:ss A')
            },1000)

            return {
                dateTime
            }
        },
    }
</script>
