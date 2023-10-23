<script setup>
    import { FormatItemName } from '../../utils/Name'
    import { ref } from 'vue'

    const { item } = defineProps({
        item: Object
    })

    const open = ref(false)
    const $emit = defineEmits([ "onDelete" ])

    const DeleteContentItem = () => $emit("onDelete", item)
</script>

<template>
    <div class="content-item">
        <div class="content-item__topbar top-flex">
            <div class="content-item__left flex">
                <button class="button-action" @click="open = !open">
                    <em :class="`fas ${open ? 'fa-chevron-down' : 'fa-chevron-right'}`"></em>
                </button>

                <h4 class="quick-header" @click="open = !open">{{ FormatItemName(item[0]) }}</h4>
            </div>

            <div class="content-item__right">
                <button class="button-action" @click="DeleteContentItem">
                    <em class="fas fa-times"></em>
                </button>
            </div>
        </div>

        <div class="content-item__content border-bottom" v-if="open">
            <div class="flex stretch">  
                <span class="info-span">Type: {{ item[1].type }}</span>
                <!-- <span class="info-span" v-if="item[1].max_size">(Max size: {{ item[1].max_size }})</span> -->
            </div>

            <div class="options buttons">
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .content-item {
        margin-top: 0px;

        background: $background-color-lighten;
        transition: .225s;

        &:hover {
            background: rgba($background-color-lighten, 0.4);
        }

        .content-item__topbar {
            padding: 8px;

            .button-action {
                border: 0;
                outline: 0;

                background: 0;
                color: #aaa;

                width: 32px;
                height: 16px;

                cursor: pointer;
                transition: .225s;

                &:hover {
                    color: #888;
                }
            }

            .quick-header {
                cursor: pointer;
            }
        }

        .content-item__content {
            padding: 8px 24px;
            margin-top: 12px;

            .vertical-line {
                height: 24px;
            }

            .info-span {
                margin-right: 8px;
            }
        }
    }
</style>