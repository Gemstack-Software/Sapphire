<script setup>
    import { ref } from 'vue'
    import { Get } from '../utils/Fetch'
    import Loader from '../components/Loader.vue'
    import AssetsUploader from '../components/Assets/Uploader.vue'
    import Asset from '../components/Assets/Asset.vue'

    /////////////////////////////////
    // Obtaining assets
    /////////////////////////////////
    const assets = ref([])
    const assetsError = ref("")
    const isLoading = ref(true)

    const GetAssets = () => {
        isLoading.value = true

        Get('/api/assets/all')
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200)
                    assets.value = res.response.content
                else 
                    assetsError.value = res.response.message

                isLoading.value = false
            })
    }

    GetAssets()

    /////////////////////////////////////
    // Events
    /////////////////////////////////////
    const OnUpload = () => GetAssets()

    /////////////////////////////////////
    // Searcher
    /////////////////////////////////////
    const search = ref("")
</script>

<template>
    <div class="assets">
        <div class="assets-topbar padding border-bottom">
            <h1 class="medium-header">
                Assets
            </h1> 
        </div>

        <div class="assets-body">
            <div class="assets-loader" v-if="isLoading">
                <Loader />
            </div>

            <div class="assets__loaded" v-else>
                <div class="assets-error" v-if="assetsError !== ''">
                    <h3>{{ assetsError }}</h3> 
                </div>

                <div class="assets-body__inner padding border-bottom" v-else>
                    <AssetsUploader 
                        @Upload="OnUpload"
                    />
                </div>

                <div class="assets-search__container padding border-bottom form">
                    <input type="text" placeholder="Search" class="form-input asset-search__input" v-model="search">
                </div>

                <div class="assets-container padding">
                    <div class="assets-container__inner">
                        <div 
                            v-for="asset in assets" 
                            :key="asset"
                            class="asset__root"
                            :style="{ display: (asset.label.toLowerCase().indexOf(search.toLowerCase()) != -1) ? 'block' : 'none' }"
                        >
                            <Asset 
                                :asset="asset"
                                @Update="OnUpload" 
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .assets {
        .assets-body {
            height: calc(100vh - 131px);
            overflow-y: auto; 

            .assets-loader {
                margin-top: 32px;
            }

            .assets-search__container {
                display: flex;
                justify-content: flex-end;
                align-items: center;

                .asset-search__input {
                    width: 300px;
                    margin: 0;
                }
            }

            .assets-container {
                .assets-container__inner {
                    display: flex;
                    justify-content: space-between;
                    align-items: stretch;
                    flex-wrap: wrap;
                }
            }
        }
    }
</style>