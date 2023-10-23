<script setup>
    import { Post } from '../../utils/Fetch'
    import { ref } from 'vue'

    const { Types, Selected } = defineProps({
        Types: Array,
        Selected: String
    })

    // Getting the assets
    const assets = ref([])

    const GetAssets = () => {
        Post('/api/assets/filter-by-extension', {
            extensions: Types
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200)
                    assets.value = res.response.content
            })
    }

    GetAssets()

    const $emit = defineEmits([ "AssetSelect" ])
    const Select = (id) => $emit("AssetSelect", id)

    const search = ref('')
</script>

<template>
    <div class="asset-selector">
        <div class="asset-selector__topbar form top-flex">
            <input type="text" class="form-input" placeholder="Search for asset" v-model="search">
        </div>
        
        <div class="assets-container">
            <div 
                v-for="asset in assets.filter(_asset => _asset.label.indexOf(search) > -1)" 
                :key="asset"
                :class="`asset ${asset.id == Selected ? 'active' : ''}`"
                :title="asset.label"
                @click="Select(asset.id)">
                
                <img :src="asset.filename" alt="">

            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .asset-selector {
        background: $background-color-lighten;
        box-shadow: 0 0 8px #0008;
        padding: 8px;

        .asset-selector__topbar {
            margin-bottom: 32px;

            .form-input {
                margin-top: 0px;
            }
        }

        .assets-container {
            display: flex;
            justify-content: flex-start;
            align-items: stretch;
            flex-wrap: wrap;

            max-height: 100px;
            overflow-y: auto;

            .asset {
                margin-bottom: 16px;
                margin-right: 16px;

                cursor: pointer;

                img {
                    max-height: 96px;
                }
                
                &.active {
                    padding: 8px;
                    border: 4px solid $theme;

                    img {
                        max-height: 72px;
                    }
                }
            }
        }
    }
</style>