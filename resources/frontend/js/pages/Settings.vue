<script setup>
    import { ref } from 'vue'
    import { Get, Post } from '../utils/Fetch'
    import { Notify, NotifyRed } from '../utils/Notifications'
    import Loader from '../components/Loader.vue'
    import SettingItem from '../components/Settings/SettingItem.vue'
    import General from '../components/Settings/General.vue'
    import Internationalization from '../components/Settings/Internationalization.vue'
    import Access from '../components/Settings/Access.vue'
    import OptionalFeatures from '../components/Settings/OptionalFeatures.vue'
    import Resources from '../components/Settings/Resources.vue'
    import Production from '../components/Settings/Production.vue'

    const settingsPages = ref([
        'General',
        'Internationalization',
        'Access and users',
        'Optional features',
        'Resources',
        'Production'
    ])

    ///////////////////////////////
    // Selecting settings page
    ///////////////////////////////
    const page = ref(settingsPages.value[0])
    const setPage = (_page) => page.value = _page 
    const isPage = (item) => item === page.value

    ///////////////////////////////
    // Selecting settings page
    ///////////////////////////////
    const isLoading = ref(false)
    const settings = ref([])

    const GetSettings = () => {
        isLoading.value = true

        Get('/api/settings/all')
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) settings.value = res.response.content
                else Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')

                isLoading.value = false
            })
    }

    GetSettings()
    
    ///////////////////////////////
    // Save settings
    ///////////////////////////////
    const isSaving = ref(false)
    const textSaving = ref('Save')
    const SaveSettings = () => {
        isSaving.value = true

        Post('/api/settings/save', { settings: settings.value })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) settings.value = res.response.content
                else Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')

                isSaving.value = false
                textSaving.value = 'Saved'

                setTimeout(() => {
                    textSaving.value = 'Save'
                }, 1500)
            })
    }
</script>

<template>
    <div class="settings">
        <div class="settings-sidebar">
            <div class="top-flex padding">
                <h3 class="quick-header top-flex">
                    <span>Settings</span>
                </h3>
            </div>

            <div class="settings-list__outer">
                <div class="settings-list">

                    <SettingItem 
                        v-for="(settingPage, key) in settingsPages"
                        :key="key"
                        :name="settingPage"
                        :active="isPage(settingPage)"
                        @selectItem="setPage"
                    />
                    
                </div>
            </div>
        </div>

        <div class="settings-body">
            <div class="settings-loader" v-if="isLoading">
                <Loader />
            </div>

            <div class="settings__loaded" v-else>
                <General v-if="page === 'General'" :settings="settings" />
                <Internationalization v-else-if="page === 'Internationalization'" :settings="settings" />
                <Access v-else-if="page === 'Access and users'" :settings="settings" />
                <OptionalFeatures v-else-if="page === 'Optional features'" :settings="settings" />
                <Resources v-else-if="page === 'Resources'" :settings="settings" />
                <Production v-else-if="page === 'Production'" :settings="settings" />

                <div class="padding" v-if="page !== 'Access and users'">
                    <button class="button success" @click="SaveSettings">
                        <span class="text" v-if="!isSaving">{{ textSaving }}</span> 
                        <Loader v-else />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .settings {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;

        .settings-sidebar {
            max-width: 320px;
            width: 100%;
            height: calc(100vh - 50px);
            background: rgba(24, 24, 27, 0.2);
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2666666667);

            .quick-header {
                width: 100%;

                button {
                    margin-left: 16px;
                }
            }
        }

        .settings-body {
            width: 100%;
            height: calc(100vh - 131px);
            overflow-y: auto; 

            .settings-loader {
                margin-top: 32px;
            }
        }
    }
</style>