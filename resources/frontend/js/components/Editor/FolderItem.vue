<script setup>
    const { item, active } = defineProps({
        item: Object,
        active: Boolean
    })

    const $emit = defineEmits([ "selectItem" ])

    const Select = () => $emit("selectItem", item.name)
</script>

<template>
    <div class="folder-item">
        <div :class="`folder-item__top ${active ? 'active' : ''}`" @click="Select">
            <h3 class="folder-item__folder-name">{{ item.name }}</h3>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .folder-item {
        .folder-item__top {
            padding: 8px 32px;
            cursor: pointer;
            transition: .225s;

            .folder-item__folder-name {
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