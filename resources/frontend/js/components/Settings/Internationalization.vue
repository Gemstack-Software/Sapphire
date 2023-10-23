<script setup>
    import { ref } from 'vue'
    import CollectionSelector from '../Collection/CollectionSelector.vue'
    import CollectionEntrySelector from '../Collection/CollectionEntrySelector.vue'

    const { settings } = defineProps({
        settings: Object
    })

    /////////////////////////////////////
    // Selecting translation collection
    /////////////////////////////////////
    const collectionEntrySelector_Collection = ref(settings.Internationalization['Locales collection'])
    const SelectCollection = (collection) => {
        settings.Internationalization['Locales collection'] = collectionEntrySelector_Collection.value = collection 
    }
</script>

<template>
    <div class="internationalization form">
        <div class="topbar padding border-bottom">
            <h1 class="medium-header">Internationalization</h1>
        </div>

        <div class="data-group padding border-bottom">
            <h3 class="medium-header">Application internationalization</h3>

            <div class="data-item">
                <label for="" class="form-label quick-header">Locales collection</label>
                
                <CollectionSelector 
                    :collection="settings.Internationalization['Locales collection']"
                    @onSelected="(collection) => SelectCollection(collection)" />
            </div>

            <div class="data-item">
                <label for="" class="form-label quick-header">Default locale</label>

                <CollectionEntrySelector 
                    :collection="collectionEntrySelector_Collection"
                    :value="settings.Internationalization['Default locale']" />
            </div>
        </div>

        {{ collection }}
    </div>
</template>

<style lang="scss" scoped>
    .internationalization {
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