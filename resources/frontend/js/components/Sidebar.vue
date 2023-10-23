<script setup>
    const { userstring, active } = defineProps({
        userstring: String,
        active: String
    })

    const user = JSON.parse(decodeURIComponent(userstring))

    const { adminSidebarNavigation, role } = window
</script>

<template>
    <div class="app-sidebar">
        <div class="app-sidebar__top">
            <a href="/admin">
                <img src="/assets/sapphire.png" alt="" class="app-sidebar__brand">
            </a>

            <div class="app-sidebar__buttons">
                <a href="/admin" :class="`button-icon mb ${active === 'home' ? 'active' : ''}`" v-tippy="{ placement: 'right', content: 'Home' }">
                    <em class="fas fa-home"></em>
                </a>    

                <span class="horitzontal-line"></span>

                <a href="/admin/pages" :class="`button-icon mb ${active === 'pages' ? 'active' : ''}`" v-tippy="{ placement: 'right', content: 'Pages' }">
                    <em class="fas fa-file-lines"></em>
                </a>

                <a href="/admin/content" :class="`button-icon mb ${active === 'content' ? 'active' : ''}`" v-tippy="{ placement: 'right', content: 'Content' }">
                    <em class="fas fa-pen-to-square"></em>
                </a> 

                <a href="/admin/assets" :class="`button-icon mb ${active === 'assets' ? 'active' : ''}`" v-tippy="{ placement: 'right', content: 'Assets' }">
                    <em class="fas fa-image"></em>
                </a> 

                <a href="/admin/app" :class="`button-icon mb ${active === 'app' ? 'active' : ''}`" v-if="role !== 'Moderator'" v-tippy="{ placement: 'right', content: 'App' }">
                    <em class="fas fa-laptop-code"></em>
                </a> 

                <span class="horitzontal-line"></span>

                <a 
                    v-for="sidebarNavigationItem in adminSidebarNavigation"
                    :key="sidebarNavigationItem"
                    :href="sidebarNavigationItem.link"
                    :class="`button-icon mb ${active === sidebarNavigationItem.name ? 'active' : ''}`"
                    v-tippy="{ placement: 'right', content: sidebarNavigationItem.name }">
                    <em :class="sidebarNavigationItem.icon"></em>
                </a>

                <!-- <a href="/admin/sales" :class="`button-icon mb ${active === 'sales' ? 'active' : ''}`" v-tippy="{ placement: 'right', content: 'Sales' }">
                    <em class="fas fa-dollar"></em>
                </a>

                <a href="/admin/advertise" :class="`button-icon mb ${active === 'advertise' ? 'active' : ''}`" v-tippy="{ placement: 'right', content: 'Ads' }">
                    <em class="fas fa-rectangle-ad"></em>
                </a> -->

                <span class="horitzontal-line"></span>

                <a href="/admin/plugins" :class="`button-icon mb ${active === 'plugins' ? 'active' : ''}`" v-if="role === 'Super Admin'" v-tippy="{ placement: 'right', content: 'Plugins' }">
                    <em class="fas fa-plug"></em>
                </a> 
                
                <a href="/admin/settings" :class="`button-icon mb ${active === 'settings' ? 'active' : ''}`" v-if="role === 'Super Admin'" v-tippy="{ placement: 'right', content: 'Settings' }">
                    <em class="fas fa-cog"></em>
                </a> 

                <a href="/api/auth/sign-out" :class="`button-icon mb ${active === 'sign-out' ? 'active' : ''}`" v-tippy="{ placement: 'right', content: 'Sign out' }">
                    <em class="fas fa-sign-out-alt"></em>
                </a> 
            </div>
        </div>

        <div class="app-sidebar__bottom">
            <a href="/admin/account">
                <img :src="`/api/user/avatar/${user.id}`" alt="" class="app-sidebar__avatar">
            </a>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .app-sidebar {
        width: 60px;
        height: 100vh;
        background: $background-color-lighten;
        box-shadow: 0 0 8px #0008;

        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-direction: column;

        .app-sidebar__top {
            padding: 16px;
            padding-top: 20px;

            .app-sidebar__brand {
                width: 28px;
                height: 28px;
                margin: 0 8px;
            }

            .app-sidebar__buttons {
                margin-top: 16px;
                width: 100%;
                
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;

                .button {
                    margin-top: 0px;
                }
            }
        }

        .app-sidebar__bottom {
            padding-bottom: 8px;   

            .app-sidebar__avatar {
                cursor: pointer;
                transition: .225s;
                
                width: 32px;
                height: 32px;
                padding: 0px;
                border-radius: 50%;
                margin-bottom: 8px;

                background: #fff1;

                &:hover {
                    width: 48px;
                    height: 48px;
                    padding: 8px;
                    margin-bottom: 0px;
                }

            }
        }
    }
</style>