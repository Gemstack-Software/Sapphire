<script setup>
    import { ref } from 'vue'
    import { Post } from '../../utils/Fetch'

    const $emit = defineEmits([ "onClose", "onUpdate" ])

    ////////////////////////////////////
    // Close modal
    ////////////////////////////////////
    const closeModal = () => $emit("onClose")

    ////////////////////////////////////
    // User data
    ////////////////////////////////////
    const email = ref('')
    const role = ref('Moderator')

    ////////////////////////////////////
    // Create user
    ////////////////////////////////////
    const createUser = () => {
        Post('/api/user/create', {
            email: email.value,
            role: role.value
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
    <div class="modal">
        <div class="modal__backdrop" @click="closeModal"></div>
        <div class="modal__body">
            <div class="modal__topbar padding border-bottom">
                <h1 class="medium-header">Create user</h1>
            </div>

            <div class="modal__content padding border-bottom form">
                <div class="data-group">
                    <label for="email" class="form-label quick-header">Email address</label>
                    <input id="email" type="text" class="form-input" v-model="email">
                </div>
            </div>

            <div class="modal__content padding border-bottom form">
                <div class="data-group">
                    <label for="role" class="form-label quick-header">Role</label>

                    <select v-model="role" id="role" class="form-input">
                        <option value="Moderator">Moderator</option>
                        <option value="Admin">Admin</option>
                        <option value="Super Admin">Super Admin</option>
                    </select>
                </div>
            </div>

            <div class="model__footer padding">
                <button class="button success" @click="createUser">Create</button>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .modal {
        position: fixed;
        top: 0;
        left: 0;

        .modal__backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            background: #0004;
        }

        .modal__body {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

            width: 600px;

            background: $background-color;
            box-shadow: 0 0 8px #0008;

            .form-label {
                margin-top: 0px;
                margin-bottom: 0px;
            }
        }
    }
</style>