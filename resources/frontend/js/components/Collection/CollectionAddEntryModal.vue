<script setup>
    import { ref } from 'vue' 
    import { MakeArrayFromObject } from '../../utils/Array'
    import { Post } from '../../utils/Fetch'
    import { FormatItemName } from '../../utils/Name'
    import { Type } from '../../utils/Schema'
    import { Notify, NotifyRed } from '../../utils/Notifications'
    import AssetSelector from '../Assets/Selector.vue'
    import MultiSelector from '../Assets/MultiSelector.vue'
    import MixedArraySelector from '../MixedArray/MixedArraySelector.vue'

    const { collection } = defineProps({
        collection: Object
    })

    const $emit = defineEmits([ "CloseModal", "UpdateCollection" ])

    const CloseModal = () => $emit("CloseModal")

    const schemaArray = MakeArrayFromObject(collection.schema.content)
    const entryName = ref('')

    // Make fillable entry data for v-model's
    const fillableEntryData = ref({})
    schemaArray.forEach(([item]) => fillableEntryData.value[item] = null)

    // Create new entry of data
    const CreateEntry = () => {
        Post('/api/collections/add-entry', {
            data: fillableEntryData.value,
            collection_id: collection.info.id,
            name: entryName.value
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    $emit("UpdateCollection", res.response.content)
                    CloseModal()
                }
                else Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
            })
    }
</script>

<template>
    <div class="modal__root" @keyup.esc="CloseModal">
        <div class="modal__interactive-background" @click="CloseModal"></div>

        <div class="modal__body">
            <div class="modal__topbar padding border-bottom top-flex">
                <h1 class="modal__header">New entry</h1>

                <button class="button-small" @click="CloseModal">
                    <em class="fas fa-times"></em>
                </button>
            </div>

            <div class="modal__content padding border-bottom">

                <div class="entry-scaffolding__root">
                    <div class="entry-scaffolding__item border-bottom" v-for="[schemaName, schemaItem] in schemaArray" :key="schemaName">
                        
                        <div class="loop__item" v-if="schemaItem">
                            <label class="entry-scaffolding__name quick-header" :title="schemaName" :for="schemaName">{{ FormatItemName(schemaName) }}</label>

                            <div class="item__string form" v-if="Type(schemaItem.type) === 'String'">
                                <input type="text" class="form-input" :id="schemaName" v-model="fillableEntryData[schemaName]">
                            </div>

                            <div class="item__number form" v-else-if="Type(schemaItem.type) === 'Number'">
                                <input type="number" class="form-input" :id="schemaName" v-model="fillableEntryData[schemaName]">
                            </div>

                            <div class="item__date form" v-else-if="Type(schemaItem.type) === 'Date'">
                                <input type="date" class="form-input" :id="schemaName" v-model="fillableEntryData[schemaName]">
                            </div>

                            <div class="item__date form" v-else-if="Type(schemaItem.type) === 'Image'">
                                <AssetSelector 
                                    :Selected="fillableEntryData[schemaName]"
                                    :Types="['png','jpg','jpeg','svg','webp','bmp']"
                                    @AssetSelect="(asset) => fillableEntryData[schemaName] = asset"
                                />
                            </div>

                            <div class="item__video form" v-else-if="Type(schemaItem.type) === 'Video'">
                                <AssetSelector 
                                    :Selected="fillableEntryData[schemaName]"
                                    :Types="['mp4']"
                                    @AssetSelect="(asset) => fillableEntryData[schemaName] = asset"
                                />
                            </div>

                            <div class="item__date form" v-else-if="Type(schemaItem.type) === 'ImageCollection'">
                                <MultiSelector 
                                    :Selected="fillableEntryData[schemaName] || []"
                                    :Types="['png','jpg','jpeg','svg','webp','bmp']"
                                    @AssetSelect="(asset) => fillableEntryData[schemaName] = asset"
                                />
                            </div>

                            <div class="item__video form" v-else-if="Type(schemaItem.type) === 'VideoCollection'">
                                <MultiSelector 
                                    :Selected="fillableEntryData[schemaName] || []"
                                    :Types="['mp4']"
                                    @AssetSelect="(asset) => fillableEntryData[schemaName] = asset"
                                />
                            </div>

                            <div class="item__video form" v-else-if="Type(schemaItem.type) === 'MultimediaCollection'">
                                <MultiSelector 
                                    :Selected="fillableEntryData[schemaName] || []"
                                    :Types="['png','jpg','jpeg','svg','webp','bmp', 'mp4']"
                                    @AssetSelect="(asset) => fillableEntryData[schemaName] = asset"
                                />
                            </div>

                            <div class="item__video form" v-else-if="Type(schemaItem.type) === 'MixedArray'">
                                <MixedArraySelector 
                                    :Selected="fillableEntryData[schemaName] ? fillableEntryData[schemaName] : []"
                                    @ArraySelect="(mixedArray) => fillableEntryData[schemaName] = mixedArray"
                                />
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="modal__footer top-flex padding">
                <div class="modal__footer-left form">
                    <input 
                        type="text" 
                        class="form-input" 
                        placeholder="Entry name" 
                        v-if="collection.schema.info.name"
                        v-model="entryName">
                </div>

                <button class="button" @click="CreateEntry">Create <em class="fa-solid fa-plus"></em></button>
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

                .entry-scaffolding__root {
                    width: 100%;
                    
                    .entry-scaffolding__item {
                        width: 100%;
                        padding: 8px;
                        background: $background-color-lighten;
                    }
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