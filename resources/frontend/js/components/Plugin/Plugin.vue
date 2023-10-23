<script setup>
    import { ref } from 'vue'

    const { plugin } = defineProps({
        plugin: Object
    })
</script>

<template>
    <div class="plugin">
        <span class="plugin-name">{{ plugin.name }}</span>
    </div>
</template>

<style lang="scss" scoped>
    .plugin {
        padding: 20px;
        width: 400px;

        background: $background-color-lighten;
        box-shadow: 0 0 8px #0008;

        display: flex;
        justify-content: space-between;
        align-items: center;

        .plugin-name {
            font-size: 24px;
        }
    }
</style>