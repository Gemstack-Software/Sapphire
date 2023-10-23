<script setup>
    import { Post } from '../../utils/Fetch'
    import { Notify, NotifyRed } from '../../utils/Notifications'
    import { ref } from 'vue'
    import CollectionEntryEditModal from './CollectionEntryEditModal'
    
    const $emit = defineEmits([ "OnDelete", "UpdateCollection" ])

    const { entry, info, collection } = defineProps({
        entry: Object,
        info: Object,
        collection: Object
    })

    const DeleteEntry = () => {
        Post('/api/collections/remove-entry', {
            id: collection.info.id,
            entry
        })
            .then(res => res.json())
            .then(res => {
                console.log(res)

                if(res.response.status === 200) $emit("OnDelete", entry)
                else Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
            })
    }

    const isEditModal = ref(false)
    const OpenEditModal  = () => isEditModal.value = true
    const CloseEditModal = () => isEditModal.value = false

    const UpdateCollection = (_collection) => $emit("UpdateCollection", _collection)
</script>

<template>
    <div class="collection-entry">
        <div class="collection-entry__left">
            <span class="value" v-if="info.id">
                {{ entry.id }}
            </span>

            <span class="value" v-if="info.uuid">
                {{ entry.uuid }}
            </span>

            <span class="value" v-if="info.name">
                {{ entry.name }}
            </span>
        </div>

        <div class="collection-entry__right">
            <button class="button-small" @click="OpenEditModal">
                <em class="fas fa-pen"></em>
            </button>

            <button class="button-small danger" @click="DeleteEntry">
                <em class="fas fa-times"></em>
            </button>
        </div>

        <CollectionEntryEditModal 
            v-if="isEditModal"
            :entry="entry" 
            :collection="collection"
            @CloseModal="CloseEditModal"
            @UpdateCollection="UpdateCollection" />
    </div>
</template>

<style lang="scss" scoped>
    .collection-entry {
        background: $background-color-lighten;

        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 8px;

        &:nth-child(2n) {
            background: lighten($background-color-lighten, 5%);
        }

        .collection-entry__left, .collection-entry__right {
            display: flex;
            align-items: center;
            justify-content: flex-start;

            .value {
                display: block;
                min-width: 150px;
            }
        }

        .collection-entry__right {
            width: 150px;

            .button-small {
                width: 32px;
            }
        }
    }
</style>