<script setup>
    const { title, type, icon, color, active } = defineProps({
        title: String,
        type: String,
        icon: String,
        color: String,
        active: Boolean
    })

    const $emit = defineEmits([ "OnSelect" ])
    const Select = () => $emit("OnSelect", type); 
</script>

<template>
    <div class="schema-item__root" @click="Select">
        <div :class="`schema-item__content ${active ? 'active' : ''}`">
            <em :class="icon"></em>
        </div>

        <div class="schema-item__desc">
            <h3 :class="`schema-item__name ${active ? 'active' : ''}`">{{ title }}</h3>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .schema-item__root {
        width: 200px;
        min-height: 100px;
        margin-bottom: 32px;

        .schema-item__content {
            width: 100%;
            height: 100px;

            background: $background-color-lighten;
            box-shadow: 0 0 16px #0008;

            display: flex;
            justify-content: center;
            align-items: center;

            cursor: pointer;
            transition: .225s;

            em {
                font-size: 36px;
            }

            &:hover {
                background: rgba($theme, 0.75);
            }

            &.active {
                background: $theme;
            }
        }

        .schema-item__desc {
            .schema-item__name {
                padding: 8px;
                text-align: center;

                &.active {
                    color: $theme;
                }
            }
        }
    }
</style>