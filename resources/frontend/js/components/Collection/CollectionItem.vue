<script setup>  
    const { collection, selected } = defineProps({
        collection: Object,
        selected: Boolean
    })

    const $emit = defineEmits([ "onSelect" ])

    const Select = () => $emit("onSelect", collection)
</script>

<template>
    <div :class="`collection-item__root ${selected ? 'active' : ''}`" @click="Select">
        <span class="collection-item__name" data-aos="flip-up">{{ collection.info.display_name }}</span>
    </div>
</template>

<style lang="scss" scoped>
    .collection-item__root {
        padding: 8px 32px;
        cursor: pointer;
        transition: .225s;

        .collection-item__name {
            font-size: 20px;
        }

        &:hover, &.active {
            background: rgba($theme, 0.05);
            color: $theme;
            padding: 8px 48px;
        }
    }
</style>