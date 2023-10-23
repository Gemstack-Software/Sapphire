<script setup>
    import { ref } from 'vue'
    import { MakeArrayFromObject } from '../../utils/Array'
    import { Post } from '../../utils/Fetch'
    import { Notify, NotifyRed } from '../../utils/Notifications'
    import CollectionEditContentItem from './CollectionEditContentItem.vue'
    import CollectionSchemaItemAddModal from './CollectionSchemaItemAddModal.vue'

    const { collection } = defineProps({
        collection: Object
    })

    const contents = MakeArrayFromObject(collection.schema.content)
    const $emit = defineEmits([ "onDeleteProperty", "onUpdateCollection" ])

    const OnDelete = (item) => {
        Post('/api/collections/remove-schema-item', {
            collection: collection.info.id,  
            item: item[0]
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    $emit("onDeleteProperty", item[0])
                }
                else Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
            })
    }

    const isOpenModal = ref(false)
    const CloseModal = () => isOpenModal.value = false

    const AddItem = ({item, name}) => {
        Post('/api/collections/add-schema-item', {
            collection: collection.info.id,
            name: name.value,
            type: item.value
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    $emit("onUpdateCollection", res.response.content)
                }
                else Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
            })
    }
</script>

<template>
    <div class="content-editor__root">
        <div class="top-flex">
            <h3 class="subheader">Contents schema</h3>

            <button
                class="button-small add-schema-item-button"
                @click="isOpenModal = !isOpenModal">
                <em class="fas fa-plus"></em>
            </button>
        </div>

        <div class="content-item" v-for="contentItem in contents" :key="contentItem">
            <CollectionEditContentItem :item="contentItem" @onDelete="OnDelete" />
        </div> 

        <div class="no-schema-items" v-if="contents.length === 0">
            <img src="/assets/svg/content.svg" alt="" class="svg">

            <span class="subheader">
                Collection <strong>{{ collection.info.display_name }}</strong> hasn't any schema items! <br>
                Create one <a href="#" @click="isOpenModal = true" class="link">here</a>
            </span>
        </div>

        <CollectionSchemaItemAddModal 
            v-if="isOpenModal" 
            @CloseModal="CloseModal"
            @AddItem="AddItem" />
    </div>
</template>

<style lang="scss" scoped>
    .subheader {
        margin-bottom: 32px;
    }

    .add-schema-item-button {
        margin-right: 16px;
    }

    .no-schema-items {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;

        .svg {
            width: 384px;
        }

        .subheader {
            font-size: 24px;
            margin-top: 32px;
            
            text-align: center;
        }
    }
</style>