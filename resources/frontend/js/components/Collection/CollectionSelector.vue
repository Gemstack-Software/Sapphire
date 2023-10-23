<script setup>
    import { ref } from 'vue'
    import { Get } from '../../utils/Fetch'
    import Loader from '../Loader.vue'

    const { collection } = defineProps({
        collection: String
    })

    /////////////////////////////////////
    // Fetch all collections
    /////////////////////////////////////
    const collections = ref([])
    const collectionsLoading = ref(false)

    const GetCollections = () => {
        collectionsLoading.value = true

        Get('/api/collections/all')
            .then(res => res.json())
            .then(res => {
                collectionsLoading.value = false
                collections.value = res.response.content
            })
    }

    GetCollections()

    /////////////////////////////////////
    // Selecting
    /////////////////////////////////////
    const $emit = defineEmits([ "onSelected" ])
    const OnSelect = ($event) => $emit("onSelected", $event.target.value)
</script>

<template>
    <div class="collections-selector">
        <Loader v-if="collectionsLoading" />

        <div class="collections-loaded form">
            <select class="form-input" :value="collection" @input="OnSelect">
                <option 
                    v-for="collection in collections" 
                    :key="collection"
                    :value="collection.info.id">
                    {{ collection.info.display_name }}    
                </option>
            </select>
        </div>
    </div>
</template>