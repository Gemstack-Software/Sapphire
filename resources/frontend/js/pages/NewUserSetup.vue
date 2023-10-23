<script setup>
    import { ref } from 'vue'
    import { Post } from '../utils/Fetch'

    const { userstring } = defineProps({
        userstring: Object
    })

    const user = ref(JSON.parse(decodeURIComponent(userstring)))
    const password = ref('')

    const SetupUser = () => {
        Post('/api/user/change-password', {
            id: user.value.id,
            password: password.value
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    window.location.reload()
                    window.location.href = window.location
                }
            })
    }
</script>

<template>
    <div class="new-user-setup__container flex-center full">
        <div class="new-user__form form">
            <div class="new-user__topbar border-bottom">
                <h2>{{ user.username }}</h2>
            </div>

            <div class="new-user__content border-bottom">
                <label for="new-password" class="quick-header">New Password</label>
                <input id="new-password" type="password" class="form-input" v-model="password">
            </div>

            <div class="new-user__content flex-content">
                <span class="danger">Your sapphire account is incomplete!</span>
                
                <button class="button" @click="SetupUser">
                    Continue <em class="fas fa-arrow-right"></em>
                </button>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .new-user__form {
        width: 500px;

        background: $background-color-lighten;
        box-shadow: 0 0 8px #0008;

        .new-user__topbar, .new-user__content {
            padding: 20px;

            .danger {
                color: $danger;
            }

            &.flex-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
        }

        .quick-header {
            font-size: 14px;
            color: #888;
            text-transform: uppercase;
        }
    }
</style>