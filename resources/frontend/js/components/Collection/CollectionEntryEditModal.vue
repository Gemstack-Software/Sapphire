<script setup>
    import { MakeArrayFromObject } from "../../utils/Array"
    import { FormatItemName } from "../../utils/Name"
    import { Type } from '../../utils/Schema'
    import { Post } from '../../utils/Fetch'
    import { Notify } from '../../utils/Notifications'
    import AssetSelector from '../Assets/Selector.vue'

    const { entry, collection } = defineProps({
        entry: Object,
        collection: Object
    })

    const attributesArray = MakeArrayFromObject(entry.attributes)
    const GetAttributeType = (index) => collection.schema.content[attributesArray[index][0]].type

    const $emit = defineEmits([ "CloseModal", "UpdateCollection" ])
    const CloseModal = () => $emit("CloseModal")

    const Save = () => {
        Post('/api/collections/edit-entry', {
            entry,
            id: collection.info.id
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) 
                    $emit("UpdateCollection", res.response.content)
                else 
                    Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
            })

        
    }
</script>

<template>
    <div class="modal__root" @keyup.esc="CloseModal">
        <div class="modal__interactive-background" @click="CloseModal"></div>

        <div class="modal__body">
            <div class="modal__topbar padding border-bottom top-flex">
                <h1 class="modal__header">
                    Editing entry <span class="theme">{{ entry.name }}</span> 
                </h1>

                <button class="button-small" @click="CloseModal">
                    <em class="fas fa-times"></em>
                </button>
            </div>

            <div class="modal__content padding border-bottom">
                <div class="attributes-container">
                    <div class="attribute" v-for="([attributeName, attributeItem], key) in attributesArray" :key="attributeName">
                        <div class="attribute__inner" v-if="attributeItem">
                            <label class="entry-scaffolding__name quick-header" :for="attributeName">{{ FormatItemName(attributeName) }}</label>

                            <div class="item__string form" v-if="Type(GetAttributeType(key)) === 'String'">
                                <input type="text" class="form-input" :id="attributeName" v-model="entry.attributes[attributeName]">
                            </div>

                            <div class="item__number form" v-else-if="Type(GetAttributeType(key)) === 'Number'">
                                <input type="number" class="form-input" :id="attributeName" v-model="entry.attributes[attributeName]">
                            </div>

                            <div class="item__date form" v-else-if="Type(GetAttributeType(key)) === 'Date'">
                                <input type="date" class="form-input" :id="attributeName" v-model="entry.attributes[attributeName]">
                            </div>

                            <div class="item__image form" v-else-if="Type(GetAttributeType(key)) === 'Image'">
                                <AssetSelector 
                                    :Selected="entry.attributes[attributeName]"
                                    :Types="['png','jpg','jpeg','svg','webp','bmp']"
                                    @AssetSelect="(asset) => entry.attributes[attributeName] = asset"
                                />
                            </div>

                            <div class="item__video form" v-else-if="Type(GetAttributeType(key)) === 'Video'">
                                <AssetSelector 
                                    :Selected="entry.attributes[attributeName]"
                                    :Types="['mp4']"
                                    @AssetSelect="(asset) => entry.attributes[attributeName] = asset"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>  

            <div class="modal__footer top-flex padding">
                <div class="modal__footer-left form">
                    
                </div>

                <button class="button success" @click="Save">
                    Save <em class="fa-solid fa-save"></em>
                </button>
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
                height: 320px;
                overflow-y: auto;

                .attribute {
                    margin-bottom: 16px;
                }
            }

            .modal__footer {
                .form-input {
                    margin-top: 0px;
                }
            }
        }
    }
</style>