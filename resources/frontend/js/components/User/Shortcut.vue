<script setup>
    import { ref } from 'vue'
    import { Get } from '../../utils/Fetch'

    // User is user id
    const { user } = defineProps({
        user: String
    })

    const username = ref('')

    // Get user
    Get(`/api/user/username/${user}`)
        .then(res => res.json())
        .then(res => {
            if(res.response.status === 200) username.value = res.response.content
            else username.value = 'Error whilst trying to fetch user data.'
        })
</script>

<template>
    <div class="user-shortcut">
        <img
            class="user-shortcut__avatar" 
            :src="`/api/user/avatar/${user}`" 
            alt="">

        <span class="user-shortcut__username">
            {{ username }}
        </span>
    </div>
</template>

<style lang="scss" scoped>
    .user-shortcut {
        display: flex;
        justify-content: flex-start;
        align-items: center;

        .user-shortcut__avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
        }

        .user-shortcut__username {
            margin-left: 8px;
        }
    }
</style>