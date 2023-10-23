<script setup>
    const { name, active } = defineProps({
        name: String,
        active: Boolean
    })


    const $emit = defineEmits([ "selectItem" ])
    const Select = () => $emit("selectItem", name)
</script>

<template>
    <div class="setting-item">
        <div :class="`setting-item__top ${active ? 'active' : ''}`" @click="Select">
            <h3 class="setting-item__setting-name">{{ name }}</h3>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .setting-item {
        .setting-item__top {
            padding: 8px 32px;
            cursor: pointer;
            transition: .225s;

            .setting-item__setting-name {
                font-size: 20px;
                font-weight: 400;
            }

            &:hover, &.active {
                background: rgba($theme, 0.05);
                color: $theme;
                padding: 8px 48px;
            }
        }
    }
</style>