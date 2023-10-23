<script setup>
    import { ref } from 'vue'
    import { ValidEmail } from '../utils/Email'
    import { PasswordStrength, RandomPassword } from '../utils/Password'
    import { Post } from '../utils/Fetch'

    const slide = ref(0)
    const username = ref('')
    const email = ref('')
    const password = ref('')
    const hide_password = ref(true)
    const loading = ref(false)
    const error = ref('')

    const GenerateRandomPassword = () => {
        password.value = RandomPassword()
    }

    const Complete = () => {
        loading.value = true

        Post('/api/super-admin/setup', {
            username: username.value,
            email: email.value,
            password: password.value
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status !== 200) {
                    error.value = res.response.message
                } 
                else {
                    window.location.reload()
                }
            })
    }
</script>

<template>
    <div class="setup-user__container flex-center full">
        <div class="slider-root">
            <div class="slider" :style="{ 'margin-left': (slide * -800) + 'px' }">

                <!-- INTRODUCTION SLIDE -->

                <div class="setup-user__form glass-form">
                    <h1 class="header"><span class="theme">Sapphire</span> is almost ready!</h1>
                    <h2 class="subheader">Last step is to create your super admin user</h2>

                    <div class="button-right">
                        <button class="button button-continue" @click="slide++">
                            Start <em class="fa-solid fa-arrow-right-long"></em>
                        </button>
                    </div>
                </div>

                <!-- USERNAME SLIDE -->

                <div class="setup-user__form glass-form">
                    <h1 class="header">Username</h1>
                    <label for="username" class="subheader">What you want to be named</label>

                    <div class="form">
                        <input id="username" class="form-input" type="text" placeholder="John Smith" v-model="username">

                        <span class="error">
                            {{ username !== '' ? 
                                ( username.length >= 4 && username.length <= 24 ? 
                                    '' : 
                                    'Username should be at least 4 characters long and less than 24' ) : '' }}
                        </span>
                    </div>

                    <div class="button-right">
                        <button 
                            class="button button-continue" 
                            @click="() => (username.length >= 4 && username.length <= 24) ? ++slide : 0" 
                            :disabled="!(username.length >= 4 && username.length <= 24)">

                            Next <em class="fa-solid fa-arrow-right-long"></em>
                        </button>
                    </div>
                </div>

                <!-- EMAIL SLIDE -->

                <div class="setup-user__form glass-form">
                    <h1 class="header">Email</h1>
                    <label for="email" class="subheader">It can help when you will forget password</label>

                    <div class="form">
                        <input id="email" class="form-input" type="email" placeholder="your-cool-email@sapphire-mail.com" v-model="email">

                        <span class="error">
                            {{ email !== '' ? 
                                ( ValidEmail(email) ? 
                                    '' : 
                                    'This e-mail is not valid! Valid format: username@postname.domain' ) : '' }}
                        </span>
                    </div>

                    <div class="button-between">
                        <button class="button button-previous" @click="slide--">
                            <em class="fa-solid fa-arrow-left-long default left-icon"></em> Previous
                        </button>

                        <button 
                            class="button button-continue" 
                            @click="() => ValidEmail(email) ? ++slide : 0" 
                            :disabled="!ValidEmail(email)">
                            
                            Next <em class="fa-solid fa-arrow-right-long"></em>
                        </button>
                    </div>
                </div>

                <!-- PASSWORD SLIDE -->

                <div class="setup-user__form glass-form">
                    <h1 class="header">Password</h1>
                    <label for="password" class="subheader">It is essential to protect your account</label>

                    <div class="form">
                        <div class="input-container">
                            <input id="password" class="form-input" :type="hide_password ? 'password' : 'text'" placeholder="SuperSecretPassword123" v-model="password">

                            <button class="button" @click="hide_password = !hide_password">
                                <em class="fas fa-eye" v-if="hide_password"></em>
                                <em class="fas fa-eye-slash" v-else></em>
                            </button>

                            <button class="button" @click="GenerateRandomPassword()">
                                <em class="fas fa-dice"></em>
                            </button>
                        </div>

                        <span :class="`password-strenth ${PasswordStrength(password).class}`">
                            {{ password !== '' ? 'Your password is ' + PasswordStrength(password).name : '' }}
                        </span>
                    </div>

                    <div class="button-between">
                        <button class="button button-previous" @click="slide--">
                            <em class="fa-solid fa-arrow-left-long default left-icon"></em> Previous
                        </button>

                        <button 
                            class="button button-continue" 
                            @click="() => PasswordStrength(password).level >= 1 ? ++slide : 0"
                            :disabled="!(PasswordStrength(password).level >= 1)">
                            Next <em class="fa-solid fa-arrow-right-long"></em>
                        </button>
                    </div>
                </div>

                <!-- CONFIRMATION SLIDE -->

                <div class="setup-user__form glass-form confirmation">
                    <img src="/avatars/default.png" alt="" class="avatar">

                    <h1 class="header">{{ username }}</h1>
                    <h2 class="subheader">{{ email }}</h2>
                    
                    <div class="buttons">
                        <button class="button danger button-continue" @click="slide = 1">Change <em class="fa-solid fa-arrow-left-long"></em></button>
                        <button class="button success button-continue" @click="Complete()">Complete <em class="fa-solid fa-check"></em></button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<style lang="scss" scoped>
    .slider-root {
        width: 800px;

        .slider {
            width: 800px * 5;
            min-height: 500px; 

            .setup-user__form {
                width: 600px;
                margin: 0px 100px;

                .header {
                    font-size: 28px;
                    margin-bottom: 6px;
                }

                .subheader {
                    font-size: 18px;
                    font-weight: 900;
                    color: #fff;
                }

                .button-continue, .button-previous {
                    margin-top: 32px;
                }

                .form-input {
                    margin-top: 16px;
                }

                .error {
                    font-size: 14px;
                    color: $danger;
                    margin-top: 16px;
                    display: block;
                }

                &.confirmation {
                    text-align: center;

                    .header {
                        font-size: 48px;
                        margin-bottom: 20px;
                    }

                    .subheader {
                        font-size: 26px;
                        color: #999;
                    }
                    
                    .avatar {
                        height: 128px;
                        margin-top: -96px;
                        margin-bottom: 24px;
                    }
                }
            }
        }
    }
</style>