<script setup>
    const { title, color, value, icon, link, placeholder } = defineProps({
        title: String,
        color: String,
        value: String|Number,
        icon: String,
        link: String,
        placeholder: String
    })

    const isNumber = !Number.isNaN(value)
</script>

<template>
    <div class="info-box">
        <h3 class="info-box__header"> 
            <em :class="icon" :style="{ color, 'margin-right': '8px' }"></em> {{ title }}
        </h3>

        <div class="info-box__bottom">
            <a :href="link" class="link">{{ placeholder }} <em class="fas fa-arrow-right-long"></em></a>

            <span class="info-box__value" :style="{ color }">{{ isNumber ? value.toLocaleString('fi-FI') : value }}</span>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .info-box {
        background: $background-color-lighten;
        box-shadow: 0 0 8px #0008;

        max-width: 100%;
        padding: 20px;

        .info-box__header {
            font-size: 24px;
        }

        .info-box__bottom {
            margin-top: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;

            .link {
                color: #aaa;
                transition: .225s;

                em {
                    transition: .225s margin-left;
                }

                &:hover {
                    color: $theme;
                    text-decoration: underline;

                    em {
                        margin-left: 8px;
                    }
                }
            }

            .info-box__value {
                font-size: 24px;
                font-weight: 900;

                text-shadow: 2px 2px #000;
            }
        }
    }
</style>