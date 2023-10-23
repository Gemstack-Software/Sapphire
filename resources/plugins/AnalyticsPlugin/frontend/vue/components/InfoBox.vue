<script setup>
    import { ref } from 'vue'

    ///////////////////////////////////////
    // Props
    /////////////////////////////////////// 
    const { title, color, value, icon, placeholder } = defineProps({
        title: String,
        color: String,
        value: String|Number,
        icon: String,
        placeholder: String
    })

    const isNumber = !Number.isNaN(value)
</script>

<template>
    <div class="analytics__info-box">
        <h3 class="analytics__info-box__header"> 
            <em :class="icon" :style="{ color, 'margin-right': '8px' }"></em> {{ title }}
        </h3>

        <div class="analytics__info-box__bottom">
            <!-- <a href="#" class="link"><em class="fas fa-hand-pointer"></em> Click to see more</a> -->
            <span></span>

            <span class="analytics__info-box__value" :style="{ color }">{{ isNumber ? value.toLocaleString('fi-FI') : value }}</span>
        </div>
    </div>
</template>

<style lang="scss">
    .analytics__info-box {
        background: $background-color-lighten;
        box-shadow: 0 0 8px #0008;

        max-width: 100%;
        padding: 20px;

        margin-right: 16px;
        margin-bottom: 16px;

        .analytics__info-box__header {
            font-size: 24px;
        }

        .analytics__info-box__bottom {
            margin-top: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;

            .link {
                color: #aaa;
                transition: .225s;

                em {
                    transition: .225s margin-right;
                    margin-right: 4px;
                }

                &:hover {
                    color: $theme;

                    em {
                        margin-right: 12px;
                    }
                }
            }

            .analytics__info-box__value {
                font-size: 24px;
                font-weight: 900;

                text-shadow: 2px 2px #000;
            }
        }
    }
</style>