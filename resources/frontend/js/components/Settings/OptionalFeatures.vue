<script setup>
    import { ref } from 'vue'
    import { SecondsToTime } from "../../utils/Time"
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
    <div class="optional form">
        <div class="topbar padding border-bottom">
            <h1 class="medium-header">Optional features</h1>
        </div>

        <div class="data-group padding border-bottom">
            <h3 class="medium-header">Session</h3>

            <div class="data-item">
                <label for="" class="form-label quick-header">Session lifetime (seconds)</label>
                <input type="number" step="1800" min="0" max="100000000" class="form-input" v-model="settings['Optional features']['Session lifetime']">

                <span class="time-expression">Expressed as time: {{ SecondsToTime(settings['Optional features']['Session lifetime']) }}</span>
            </div>
        </div>

        <div class="data-group padding border-bottom">
            <h3 class="medium-header">Custom APIs <em class="fas fa-question-circle" v-tippy="'Custom APIs - This function allows developers to create own controllers via App Editor and use them using: /api'"></em></h3>

            <div class="data-item">
                <label for="" class="form-label quick-header">Enable</label>
                <input type="checkbox" class="form-checkbox" v-model="settings['Optional features']['Custom APIs']">
            </div>

            <span class="soon">Custom APIs will be avaliable soon!</span>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .optional {
        width: 100%;

        .data-group {
            .data-item {
                margin-top: 32px;

                .form-label {
                    margin-bottom: 0px!important;
                }

                .time-expression {
                    display: block;
                    margin-top: 8px;
                }
            }

            .soon {
                margin: 12px 0;
                display: block;
            }
        }
    }
</style>