<script setup>
    import { ref } from 'vue'
    import { Post } from '../utils/Fetch'
    import { Notify, NotifyRed } from '../utils/Notifications'

    const { userstring } = defineProps({
        userstring: Object
    })

    const user = ref(JSON.parse(decodeURIComponent(userstring)))

    ///////////////////////////////
    // Account editing
    ///////////////////////////////
    const isEditing = ref(false)
    const openEditAccount = () => isEditing.value = !isEditing.value

    const changeUsername = () => {
        Post('/api/user/change-username', {
            id: user.value.id,
            username: user.value.username
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    openEditAccount()

                    return
                }
                else Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
            })
    }
</script>

<template>
    <div class="account">
        <div class="account-topbar padding border-bottom">
            <h1 class="medium-header">
                Account
            </h1> 
        </div>

        <div class="account-body">
            <div class="account-body__top padding border-bottom">
                <div class="account-body__top__left">
                    <div class="account-body__top__left__left">
                        <img :src="`/api/user/avatar/${user.id}`" alt="" class="account-body__avatar">
                    </div>

                    <div class="account-body__top__left__right">
                        <div class="account-body__username-topbar">
                            <div class="account-body__editor form" v-if="isEditing">
                                <input type="text" class="form-input username-input" v-model="user.username">

                                <button class="button-tile danger" @click="openEditAccount">
                                    <em class="fas fa-times"></em>
                                </button>

                                <button class="button-tile success" @click="changeUsername">
                                    <em class="fas fa-check"></em>
                                </button>
                            </div>

                            <div class="account-body__edited" v-else>
                                <h1 class="account-body__username">{{ user.username }}</h1>
                                <div class="role-badge"> {{ user.role }} </div>
                            </div>
                        </div>

                        <h3 class="account-body__email">{{ user.email }}</h3>
                    </div>
                </div>

                <div class="account-body__buttons">
                    <button class="button" @click="openEditAccount">
                        <span v-if="!isEditing">Edit account</span>
                        <span v-else>Close editor</span>
                    </button>
                    <button class="button danger">Delete account</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .account {
        height: calc(100vh - 50px);

        .account-body {
            .account-body__top {
                display: flex;
                justify-content: space-between;
                align-items: center;

                .account-body__top__left {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;

                    .account-body__top__left__left {
                        .account-body__avatar {
                            width: 192px;
                            border-radius: 50%;
                            border: 8px solid #fff0;
                            background: #fff2;
                            box-shadow: 0 0 32px #0008;
                        }
                    }

                    .account-body__top__left__right {
                        padding: 20px;

                        .account-body__username-topbar {
                            display: flex;
                            justify-content: flex-start;
                            align-items: center;

                            .account-body__edited {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                
                                .account-body__username {
                                    margin-bottom: 8px;
                                }

                                .role-badge {
                                    padding: 8px;
                                    margin-left: 12px;
                                    border-radius: 8px;
                                    display: inline;

                                    color: $background-color;
                                    background: $success;
                                    box-shadow: 0 0 8px #0008;
                                    font-size: 14px;
                                }
                            }

                            .account-body__editor {
                                display: flex;
                                justify-content: flex-start;
                                align-items: center;

                                .username-input {
                                    width: 400px;

                                    border: 0px;
                                    margin: 0px;
                                    margin-bottom: 12px;
                                }
                            }
                        }

                        .account-body__email {
                            color: #888;
                        }
                    }
                }

                .account-body__buttons {
                    .button {
                        margin: 0 4px;
                    }
                }
            }
        }
    }
</style>