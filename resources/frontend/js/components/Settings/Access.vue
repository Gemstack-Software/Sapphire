<script setup>
    import { ref } from 'vue'
    import { Get } from '../../utils/Fetch'
    import { Notify, NotifyRed } from '../../utils/Notifications'
    import UserAtList from '../User/UserAtList.vue'
    import CreateUserModal from '../User/CreateUserModal.vue'

    const { settings } = defineProps({
        settings: Object
    })

    /////////////////////////////////////
    // Getting users
    /////////////////////////////////////
    const users = ref([])

    const Obtain = () => {
        Get('/api/user/all')
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    users.value = res.response.content

                    return
                }
                
                Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
            })
    }

    Obtain()

    ////////////////////////////////////
    // Create user modal
    ////////////////////////////////////
    const isCreateUserModalOpened = ref(false)
    const OpenCreateUserModal  = () => isCreateUserModalOpened.value = true 
    const CloseCreateUserModal = () => isCreateUserModalOpened.value = false
</script>

<template>
    <div class="access form">
        <div class="topbar padding border-bottom">
            <h1 class="medium-header">Access and users</h1>
        </div>

        <div class="data-group padding border-bottom">
            <div class="top-flex">
                <h3 class="medium-header">Users</h3>

                <button class="button-small mr-16" @click="OpenCreateUserModal">
                    <em class="fas fa-plus"></em>
                </button>
            </div>

            <div class="users-container">
                <UserAtList
                    v-for="user in users"
                    :key="user"
                    :user="user"
                    @onUpdate="Obtain" />
            </div>
        </div>

        <div class="data-group padding border-bottom">
            <h3 class="medium-header">Custom roles</h3>

            <span class="gray-text">Coming soon</span>
        </div>

        <CreateUserModal 
            v-if="isCreateUserModalOpened"
            @onClose="CloseCreateUserModal"
            @onUpdate="Obtain" />
    </div>
</template>

<style lang="scss" scoped>
    .access {
        width: 100%;

        .data-group {
            .data-item {
                margin-top: 32px;

                .form-label {
                    margin-bottom: 0px!important;
                }

                .time-expression {
                    display: block;
                    margin-top: 8px;
                }
            }

            .gray-text {
                color: #aaa;
            }

            .users-container {
                margin-top: 16px;
                box-shadow: 0 0 8px #0008;
            }
        }
    }
</style>