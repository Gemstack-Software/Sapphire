<script setup>
    import { ref } from 'vue'
    import { Get } from '../../utils/Fetch'

    const { collection, value } = defineProps({
        collection: String,
        value: String
    })

    const previousCollectioName = ref('')

    /////////////////////////////////////
    // Fetch collections
    /////////////////////////////////////
    const collectionJson = ref(null)
    const collectionLoading = ref(false)

    const GetCollections = (collectionName) => {
        if(previousCollectioName.value === collectionName) return "";

        collectionLoading.value = true

        Get(`/api/collections/collection/${collectionName}`)
            .then(res => res.json())
            .then(res => {
                collectionLoading.value = false
                collectionJson.value = res.response.content
                previousCollectioName.value = collectionName
            })

        return ""
    }

    /////////////////////////////////////
    // Selecting
    /////////////////////////////////////
    const $emit = defineEmits([ "onSelected" ])
    const OnSelect = ($event) => $emit("onSelected", $event.target.value)
</script>

<template>
    <div class="__root__">
        {{ GetCollections(collection) }}
    
        <div v-if="collectionJson">
            <select class="form-input" :value="value" @input="OnSelect">
                <option 
                    v-for="collection in collectionJson.contents" 
                    :key="collection"
                    :value="collection.name">
                    {{ collection.name }}    
                </option>
            </select>
        </div>
    </div>
</template>