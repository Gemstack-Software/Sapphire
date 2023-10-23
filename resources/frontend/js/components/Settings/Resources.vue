<script setup>
    import AssetSelector from '../Assets/Selector.vue'

    const { settings } = defineProps({
        settings: Object
    })
</script>

<template>
    <div class="resources form">
        <div class="topbar padding border-bottom">
            <h1 class="medium-header">Resources</h1>
        </div>

        <div class="data-group padding border-bottom">
            <h3 class="medium-header">Styles</h3>

            <div class="data-item">
                <label for="" class="form-label quick-header">Link component styles with &lt;link&gt;</label>
                <input type="checkbox" class="form-checkbox" v-model="settings.Resources['Link component styles with <link>']">
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .resources {
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