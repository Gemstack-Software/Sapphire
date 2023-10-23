<script setup>
    import AssetSelector from '../Assets/Selector.vue'

    const { settings } = defineProps({
        settings: Object
    })
</script>

<template>
    <div class="general form">
        <div class="topbar padding border-bottom">
            <h1 class="medium-header">General</h1>
        </div>

        <div class="data-group padding border-bottom">
            <h3 class="medium-header">Application information</h3>

            <div class="data-item">
                <label for="" class="form-label quick-header">Name</label>
                <input type="text" class="form-input" v-model="settings.General['Application name']">
            </div>

            <div class="data-item">
                <label for="" class="form-label quick-header">Version</label>
                <input type="text" class="form-input" v-model="settings.General['Application version']">
            </div>

            <div class="data-item">
                <label for="" class="form-label quick-header">Thumbnail</label>

                <AssetSelector 
                    class="asset-selector"
                    :Selected="settings.General['Application thumbnail id']"
                    :Types="['png','jpg','jpeg','svg','webp','bmp']"
                    @AssetSelect="(asset) => settings.General['Application thumbnail id'] = asset"
                />
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .general {
        width: 100%;

        .data-group {
            .data-item {
                margin-top: 32px;

                .asset-selector {
                    margin-top: 24px;
                }
            }
        }
    }
</style>