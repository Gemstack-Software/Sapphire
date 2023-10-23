<script setup>
    import { Extension } from '../../utils/File'

    const { file, active, saving } = defineProps({
        file: String,
        active: Boolean,
        saving: Boolean
    })

    const $emit = defineEmits([ "selectFile" ])
    const SelectFile = () => $emit("selectFile", file)

    const extension = Extension(file)
</script>

<template>
    <div :class="`file-label ${active ? 'active' : ''}`" @click="SelectFile">
        <img class="file-label__icon" :src="`/assets/fileicons/${extension}.png`" alt="">

        <span class="file-label__name">
            {{ file }} <em class="fas fa-save saving-icon" v-if="false"></em>
        </span>
    </div>
</template>

<style lang="scss" scoped>
    @import "../../../scss/animations";

    .file-label {
        padding: 8px 16px;
        border-right: 1px solid #0004;
        cursor: pointer;
        transition: .225s;

        display: flex;
        justify-content: space-between;
        align-items: center;

        .file-label__icon {
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }

        .file-label__name {
            .saving-icon {
                margin-left: 12px;
                animation: Blinking 1s infinite;
                color: $theme;
            }
        }

        &:hover { 
            background: #ffffff04;
        }

        &.active {
            background: rgba($theme, 0.05);
        }
    }
</style>