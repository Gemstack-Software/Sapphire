<script setup>
    import { ref } from 'vue' 
    import SchemaItem from './Schema/SchemaInfo.vue'

    const $emit = defineEmits([ "CloseModal", "AddItem" ])
    const CloseModal = () => $emit("CloseModal")

    const name = ref('')
    const selected = ref('ShortText')
    const SelectSchemaItem = (title) => selected.value = title 
    
    const AddSchemaItem = () => $emit("AddItem", { item: selected, name })
</script>

<template>
    <div class="modal__root" @keyup.esc="CloseModal">
        <div class="modal__interactive-background" @click="CloseModal"></div>

        <div class="modal__body">
            <div class="modal__topbar padding border-bottom top-flex">
                <h1 class="modal__header">New schema item</h1>

                <button class="button-small" @click="CloseModal">
                    <em class="fas fa-times"></em>
                </button>
            </div>

            <div class="modal__content padding border-bottom">

                <SchemaItem 
                    title="Short Text"
                    type="ShortText"
                    icon="fa-solid fa-font"
                    color="#0099ff"
                    :active="'ShortText' === selected"
                    @OnSelect="SelectSchemaItem"
                />

                <SchemaItem 
                    title="Rich Text"
                    type="RichText"
                    icon="fa-solid fa-font"
                    color="#0099ff"
                    :active="'RichText' === selected"
                    @OnSelect="SelectSchemaItem"
                />

                <SchemaItem 
                    title="Long Text"
                    type="LongText"
                    icon="fa-solid fa-font"
                    color="#0099ff"
                    :active="'LongText' === selected"
                    @OnSelect="SelectSchemaItem"
                />

                <SchemaItem 
                    title="Integer number"
                    type="IntNumber"
                    icon="fa-solid fa-0"
                    color="#0099ff"
                    :active="'IntNumber' === selected"
                    @OnSelect="SelectSchemaItem"
                />

                <SchemaItem 
                    title="Floating-point number"
                    type="FloatNumber"
                    icon="fa-solid fa-1 "
                    color="#0099ff"
                    :active="'FloatNumber' === selected"
                    @OnSelect="SelectSchemaItem"
                />

                <SchemaItem 
                    title="Date"
                    type="Date"
                    icon="fa-solid fa-calendar"
                    color="#0099ff"
                    :active="'Date' === selected"
                    @OnSelect="SelectSchemaItem"
                />

                <SchemaItem 
                    title="Image"
                    type="Image"
                    icon="fa-solid fa-image"
                    color="#0099ff"
                    :active="'Image' === selected"
                    @OnSelect="SelectSchemaItem"
                />

                <SchemaItem 
                    title="Images Collection"
                    type="ImageCollection"
                    icon="fa-solid fa-images"
                    color="#0099ff"
                    :active="'ImageCollection' === selected"
                    @OnSelect="SelectSchemaItem"
                />

                <SchemaItem 
                    title="Video"
                    type="Video"
                    icon="fa-solid fa-video"
                    color="#0099ff"
                    :active="'Video' === selected"
                    @OnSelect="SelectSchemaItem"
                />

                <SchemaItem 
                    title="Videos Collection"
                    type="VideoCollection"
                    icon="fa-solid fa-video"
                    color="#0099ff"
                    :active="'VideoCollection' === selected"
                    @OnSelect="SelectSchemaItem"
                />

                <SchemaItem 
                    title="Multimedia Collection"
                    type="MultimediaCollection"
                    icon="fa-solid fa-photo-film"
                    color="#0099ff"
                    :active="'MultimediaCollection' === selected"
                    @OnSelect="SelectSchemaItem"
                />

            </div>

            <div class="modal__footer top-flex padding">
                <div class="modal__footer-left form">
                    <input type="text" class="form-input" placeholder="Name" v-model="name">
                </div>

                <button class="button" @click="AddSchemaItem">Add <em class="fa-solid fa-plus"></em></button>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .modal__root {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        z-index: 1000;
        
        background: #0008;
        display: flex;
        justify-content: center;
        align-items: center;

        .modal__interactive-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .modal__body {
            position: absolute;

            width: 800px;
            min-height: 100px;
            // border-radius: 12px;

            background: $background-color;
            box-shadow: 0 0 8px #0008;

            .modal__content {
                display: flex;
                justify-content: space-between;
                align-items: stretch;
                flex-wrap: wrap;

                height: 320px;
                overflow-y: auto;
            }

            .modal__footer {
                .form-input {
                    margin-top: 0px;
                }
            }
        }
    }
</style>