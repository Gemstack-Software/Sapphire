<script setup>
    import AssetSelector from '../Assets/Selector.vue'

    const { settings } = defineProps({
        settings: Object
    })
</script>

<template>
    <div class="production form">
        <div class="topbar padding border-bottom">
            <h1 class="medium-header">Production</h1>
        </div>

        <div class="data-group padding border-bottom">
            <h3 class="medium-header">Platform</h3>

            <div class="data-item">
                <label for="" class="form-label quick-header">Mode</label>

                <select v-model="settings.Production['Platform mode']" class="form-input">
                    <option value="Development">Development</option>
                    <option value="Production">Production</option>
                </select>
            </div>
        </div>

        <div class="data-group padding border-bottom">
            <h3 class="medium-header">Optimalization</h3>

            <div class="data-item">
                <label for="" class="form-label quick-header">Minify response</label>
                <input type="checkbox" class="form-checkbox" v-model="settings.Production['Minify response']">
            </div>

            <div class="data-item">
                <label for="" class="form-label quick-header">Minify compiled resources</label>
                <input type="checkbox" class="form-checkbox" v-model="settings.Production['Minify compiled resources']">
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .production {
        width: 100%;

        .data-group {
            .data-item {
                margin-top: 32px;

                .form-label {
                    margin-bottom: 0px!important;
                }
            }
        }
    }
</style>