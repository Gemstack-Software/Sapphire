<script setup>
    import { ref } from 'vue'
    import { Post } from '../../utils/Fetch'

    const $emit = defineEmits([
        "onUpdate"
    ])

    /////////////////////////////////////
    // Get user
    /////////////////////////////////////
    const { user } = defineProps({
        user: Object
    })

    /////////////////////////////////////
    // Delete user
    /////////////////////////////////////
    const DeleteUser = () => {
        Post('/api/user/delete', {
            id: user.id,
        })  .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    $emit("onUpdate")
                    closeModal()
                    
                    return
                }
                
                Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
            })
    }
</script>

<template>
    <div class="user-at-list">
        <div class="user__left">
            <strong class="user__name">{{ user.username }}</strong>
            <span class="user__role">({{ user.role }})</span>
        </div>

        <div class="user__right">
            <button class="button-small" @click="DeleteUser">
                <em class="fas fa-trash"></em>
            </button>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .user-at-list {
        width: 100%;
        padding: 8px;

        background: $background-color-lighten;
        border-bottom: 1px solid $background-color;

        display: flex;
        justify-content: space-between;
        align-items: center;

        .user__left {
            .user__role {
                margin: 0 8px;
            }
        }

        .user__right {
            padding-right: 8px;
        }
    }
</style>