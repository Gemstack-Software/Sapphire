<script setup>
    import { ref } from 'vue'
    import { Get, Post } from '../utils/Fetch'
    import { Notify, NotifyRed } from '../utils/Notifications'
    import Loader from '../components/Loader.vue'
    import CollectionItem from '../components/Collection/CollectionItem.vue'
    import CollectionEditor from '../components/Collection/CollectionEditor.vue'

    // Variables
    const collections = ref([])
    const collectionsLoading = ref(true)
    const collection = ref(null)
    
    const creatingCollection = ref(false)
    const collectionName = ref("")
    const createCollectionError = ref("")

    const editorView = ref('entries')
    const reloadIndex = ref(0)

    const role = ref(window.role)

    // Getting the content to show
    const GetCollections = () => {
        Get('/api/collections/all')
            .then(res => res.json())
            .then(res => {
                collectionsLoading.value = false
                collections.value = res.response.content
            })
    }

    GetCollections()

    // Functions
    const ReRender = () => reloadIndex.value = Math.random()

    const Select = (_collection, changeView = 'entries') => {
        // Update collections
        collection.value = _collection
        creatingCollection.value = false

        // Change editor view to entries
        if(changeView) editorView.value = changeView
    }

    const StartCreatingCollection = () => creatingCollection.value = true
    const CancelCreatingCollection = () => creatingCollection.value = false

    const CreateCollection = () => {
        Post('/api/collections/create', {
            name: collectionName.value
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    GetCollections()
                    CancelCreatingCollection()
                    Select(res.response.content.collection)

                    return
                }
                else Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
                
                createCollectionError.value = res.response.message
            })
    }

    /**
     * Updates collection by removing it's schema item
     */
    const OnDeleteProperty = (item) => {
        collections.value.forEach((_collection) => {
            if(_collection?.info.id !== collection.value?.info.id) return // If collection is not this then skip
            
            // Removing collection schema item
            delete _collection.schema.content[item]
            Select(null, 'edit')
            
            // Rerendering
            setTimeout(() => {
                Select(_collection, 'edit')
                ReRender()
            }, 10)
        })
    }

    const OnUpdateCollection = (updatedCollection) => {
        collections.value.forEach((_collection, key) => {
            if(_collection?.info.id !== collection.value?.info.id) return // If collection is not this then skip
            
            collections.value[key] = updatedCollection

            // Removing collection schema item
            Select(null, 'edit')
            
            // Rerendering
            setTimeout(() => {
                Select(collections.value[key], 'edit')
                ReRender()
            }, 10)
        })
    }

    const OnDeleteCollection = () => {
        if(role === 'Moderator') return;
        
        Post('/api/collections/delete-collection', {
            name: collection.value.info.id
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    GetCollections()
                    Select(null)
                }
                else Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
            })
    }

    const UpdateCollection = (_collection) => {
        GetCollections()
        Select(_collection)
    }
</script>

<template>
    <div class="__content" :reloadIndex="reloadIndex">
        <div class="left-bar">
            <div class="left-bar__top padding border-bottom">
                <h1 class="medium-header">
                    Content builder
                </h1> 
            </div>
            
            <div class="left-bar__collections padding">
                <div class="top-flex">
                    <h2 class="quick-header">
                        Collections
                    </h2>

                    <button class="button-small" @click="StartCreatingCollection" v-if="!creatingCollection">
                        <em class="fas fa-plus"></em>
                    </button>
                </div>

                <div class="collections-container">
                    <Loader v-if="collectionsLoading" />

                    <div class="collections-group paddingless">
                        <CollectionItem 
                            v-for="_collection in collections" 
                            :key="_collection"
                            :collection="_collection"
                            :selected="collection?.info.id == _collection.info.id"
                            @onSelect="Select" />
                    </div>
                </div>
            </div>
        </div>

        <div class="main-section">
            <div class="create-collection" v-if="creatingCollection">
                <div class="create-collection__topbar padding border-bottom" data-aos="fade-in">
                    <h1 class="medium-header" v-if="collectionName === ''">New collection</h1>
                    <h1 class="medium-header" v-else>{{ collectionName }}</h1>
                </div>

                <div class="padding" data-aos="fade-in">
                    <div class="form">
                        <div class="input-container">
                            <input type="text" class="form-input" placeholder="Name" v-model="collectionName"> 
                        </div>    
                    </div>

                    <span class="error">{{ createCollectionError }}</span>

                    <div class="buttons-container buttons-margin">
                        <button class="button success" @click="CreateCollection">Create <em class="fa-solid fa-check"></em></button>
                        <button class="button danger" @click="CancelCreatingCollection">Dismiss <em class="fa-solid fa-times"></em></button>
                    </div>
                </div>
            </div>

            <CollectionEditor 
                v-else 
                :collection="collection" 
                :view="editorView"
                @onDeleteProperty="OnDeleteProperty"
                @onUpdateCollection="OnUpdateCollection"
                @onDeleteCollection="OnDeleteCollection"
                @UpdateCollection="UpdateCollection" />
        </div>

    </div>
</template>

<style lang="scss" scoped>
    .__content {
        height: calc(100vh - 50px);
        width: 100%;

        display: flex;
        justify-content: flex-start;
        align-items: center;
    
        /* Bigger Sidebar */
        .left-bar {
            max-width: 320px;
            width: 100%;
            height: calc(100vh - 50px);

            background: rgba($background-color-lighten, 0.2);
            box-shadow: 0 0 8px #0004;

            .collections-container {
                margin-top: 16px;
            }

            .paddingless {
                margin: 0 -32px;
                width: calc(100% + 64px);
            }
        }

        .main-section {
            width: 100%;
            height: 100%;   

            overflow-x: hidden;
            overflow-y: auto;

            .buttons-margin {
                margin: 32px 0;

                .button {
                    margin-right: 16px;
                }
            }
        }
    }
</style>