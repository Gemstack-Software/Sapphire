<script setup>
    import { ref } from 'vue'
    import CollectionAddEntryModal from './CollectionAddEntryModal.vue'
    import CollectionEntry from './CollectionEntry.vue'

    const { collection } = defineProps({
        collection: Object
    })
    
    const $emit = defineEmits(["UpdateCollection"])

    const isModalOpen = ref(false)
    const OpenModal  = () => isModalOpen.value = true
    const CloseModal = () => isModalOpen.value = false

    const UpdateCollection = (_collection) => $emit("UpdateCollection", _collection)

    const OnDeleteEntry = (entryToDelete) => {
        const collectionCopy = { ...collection }

        collectionCopy.contents.forEach((entry, key) => {
            if(entry == entryToDelete) collectionCopy.contents.splice(key, 1)
        })

        UpdateCollection(collectionCopy)
    }
</script>

<template>
    <div class="collection-entries">
        <div class="collection__empty" v-if="collection.contents.length === 0">
            <img src="/assets/svg/collection.svg" alt="" class="svg">

            <span class="empty-text">
                Collection <strong>{{ collection.info.display_name }}</strong> hasn't any data record! <br>
                <a href="#" class="link" @click="OpenModal">Add new entry</a>
            </span>
        </div>

        <div class="collection__not-empty" v-else>
            <div class="top-flex">
                <h2 class="collection-editor__subheader">Entries ({{ collection.contents.length }})</h2>
            
                <button class="button-small" @click="OpenModal">
                    <em class="fas fa-plus"></em>
                </button>
            </div>

            <div class="collection-entries-container">
                <div class="collection-headers border-bottom">
                    <div class="left">
                        <header class="collection-header" v-if="collection.schema.info.id">
                            id
                        </header>

                        <header class="collection-header" v-if="collection.schema.info.uuid">
                            uuid
                        </header>

                        <header class="collection-header" v-if="collection.schema.info.name">
                            name
                        </header>
                    </div>

                    <div class="right">
                        <header class="collection-header">
                            options
                        </header>
                    </div>
                </div>

                <CollectionEntry
                    v-for="entry in collection.contents"
                    :key="entry"
                    :entry="entry"
                    :info="collection.schema.info"
                    :collection="collection"
                    @OnDelete="OnDeleteEntry"
                    @UpdateCollection="UpdateCollection"
                />
            </div>
        </div>

        <CollectionAddEntryModal 
            v-if="isModalOpen"
            :collection="collection"
            @CloseModal="CloseModal"
            @UpdateCollection="UpdateCollection"
        />
    </div>
</template>

<style lang="scss" scoped>
    .collection-entries {
        .collection__empty {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            flex-direction: column;

            .svg {
                width: 384px;
            }

            .empty-text {
                font-size: 24px;
                margin-top: 32px;
                text-align: center;
            }
        }

        .collection-entries-container {
            margin-top: 32px;
        
            .collection-headers {
                background: $background-color-lighten;

                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 8px;

                .left, .right {
                    display: flex;
                    justify-content: flex-start;
                    align-items: center;
                }

                .collection-header {
                    width: 150px;
                    font-weight: 900;
                }
            }
        }
    }
</style>