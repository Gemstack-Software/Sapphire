<script setup>
    import { ref } from 'vue'
    import { Post } from '../utils/Fetch'

    const slide = ref(0)
    const emailPlaceholder = ref('example@email.com')
    const credential = ref('')

    setInterval(() => {
        emailPlaceholder.value = (emailPlaceholder.value === 'example@email.com') ? 'Example username' : 'example@email.com'
    }, 3500)

    const username = ref(''), avatar = ref('')
    const error = ref('')

    const FirstPageContinue = () => {
        if(credential.value.length < 4) return;

        Post('/api/auth/login-credentials', {
            credential: credential.value
        })
            .then(res => res.json())
            .then(res => {
                const { content, status, message } = res.response

                if(status === 404) {
                    error.value = message
                    return
                }

                username.value = content.username
                avatar.value = content.avatar
                error.value = ''
                slide.value++
            })
    }

    const password = ref('')
    const hide_password = ref(true)

    const SignIn = () => {
        Post('/api/auth/sign-in', {
            username: username.value,
            password: password.value
        })
            .then(res => res.json())
            .then(res => {
                const { content, status, message } = res.response

                if(status === 404) {
                    error.value = message
                    return
                }
                
                window.location.href = window.location.origin + '/admin'
            })
    }
</script>

<template>
    <div class="login-container">
        <div class="slider-root">
            <div class="slider" :style="{ 'margin-left': (slide * -700) + 'px' }">
                
                <!-- CREDENTIAL SLIDE -->

                <div class="login-form" data-aos="fade-up">
                    <h2 class="login-header" data-aos="fade-up">Login</h2>

                    <div class="form email-container">
                        <label for="cred" class="form-label" data-aos="fade-up">Email or username</label>
                        <input id="cred" type="text" class="form-input" :placeholder="emailPlaceholder" v-model="credential" data-aos="fade-up">
                    </div>

                    <span class="error" v-if="error !== ''">Error: {{ error }}</span>

                    <div class="button-right">
                        <button class="button" @click="FirstPageContinue" :disabled="credential.length < 4">
                            Continue <em class="fa-solid fa-arrow-right-long"></em>
                        </button>
                    </div>
                </div>

                <!-- WELCOME SLIDE -->

                <div class="login-form welcome-section">
                    <div class="avatar-root">
                        <img :src="avatar" alt="" class="avatar">
                    </div>

                    <h1 class="header">Welcome back {{ username }} 👋</h1>

                    <div class="buttons">
                        <button class="button" @click="slide++">
                            Continue <em class="fa-solid fa-arrow-right-long"></em>
                        </button>
                    </div>
                </div>

                <!-- PASSWORD SLIDE -->

                <div class="login-form password-section">
                    <h2 class="login-header">Almost ready!</h2>

                    <div class="form email-container">
                        <label class="form-label" for="password">Password</label>

                        <div class="input-container">
                            <input id="password" :type="hide_password ? 'password' : 'text'" class="form-input" placeholder="YourSecretPassword" v-model="password">

                            <button class="button" @click="hide_password = !hide_password">
                                <em class="fas fa-eye" v-if="hide_password"></em>
                                <em class="fas fa-eye-slash" v-else></em>
                            </button>
                        </div>
                    </div>

                    <div class="button-right">
                        <button class="button" @click="SignIn">
                            Sign in <em class="fas fa-arrow-right-long"></em>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;

        height: 100vh;

        .slider-root {
            width: 700px;

            .slider {
                width: 700px * 3;
                min-height: 500px; 

                .login-form {
                    background: $background-color-lighten;
                    box-shadow: 0 0 8px #0008;

                    margin: 0 100px;
                    width: 500px;
                    padding: 20px;
                    border-radius: 12px;

                    .login-header {
                        color: $font-color;
                    }

                    .email-container {
                        margin-bottom: 24px;
                    }

                    .error {
                        color: $danger;
                    }
                }

                .welcome-section {
                    .header {
                        font-size: 28px;
                        margin-bottom: 20px;

                        text-align: center;
                    }

                    .avatar-root {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    
                        .avatar {
                            height: 128px;
                            margin-top: -96px;
                            margin-bottom: 24px;
                        }
                    }
                }

                .password-section {
                    .input-container {
                        margin-top: 32px;
                    }
                }
            }
        }
    }
</style>