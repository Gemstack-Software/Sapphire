<script setup>
    const { id } = defineProps({
        id: Number|String
    })
</script>

<template>
    <div class="avatar-root">
        <img :src="`/api/user/avatar/${id}`" alt="" class="avatar-root__image">
    </div>
</template>

<style lang="scss" scoped>
    .avatar-root {
        width: 100%;

        .avatar-root__image {
            width: 32px;
            height: 32px;
        }
    }
</style>