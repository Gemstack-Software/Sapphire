<script setup>  
    import { ref } from 'vue'
    import CollectionEditInfo from './CollectionEditInfo.vue'
    import CollectionEditContents from './CollectionEditContents.vue'
    import CollectionApiUsage from './CollectionApiUsage.vue'
    import CollectionEntries from './CollectionEntries.vue'

    const { collection, view } = defineProps({
        collection: Object,
        view: String
    })

    const $emit = defineEmits([ "onDeleteProperty", "onUpdateCollection", "onDeleteCollection", "UpdateCollection" ])

    const OnDeleteProperty = (item) => $emit("onDeleteProperty", item) 
    const OnUpdateCollection = (item) => $emit("onUpdateCollection", item)

    const isShowingDangerOptions = ref(false)

    const DeleteCollection = () => $emit("onDeleteCollection")
    const UpdateCollection = (_collection) => $emit("UpdateCollection", _collection)
    
    const role = ref(window.role)
</script>

<template>
    <div class="collection-editor__root">
        <div class="collection-editor__exists" v-if="collection">
            <div class="collection-editor__top padding border-bottom"> 
                <h1 class="collection-editor__header" data-aos="flip-up">{{ collection.info.display_name }}</h1>
            </div>

            <div class="collection-editor__toolbar border-bottom" data-aos="flip-up">
                <button :class="`button-slim ${view === 'entries' ? 'active' : ''}`" @click="view = 'entries'">Data <em class="fas fa-database"></em></button>
                <button :class="`button-slim ${view === 'edit' ? 'active' : ''}`" @click="view = 'edit'" v-if="role !== 'Moderator'">Schema <em class="fas fa-pen-to-square"></em></button>
                <button :class="`button-slim ${view === 'api' ? 'active' : ''}`" @click="view = 'api'">Usage <em class="fas fa-server"></em></button>
            </div>

            <!-- EDITOR -->

            <div class="edit" v-if="view === 'edit'">
                <div class="editor__base padding border-bottom" >
                    <CollectionEditInfo :collection="collection" />
                </div>

                <div class="editor__base padding padding-bottom">
                    <CollectionEditContents 
                        :collection="collection" 
                        @onDeleteProperty="OnDeleteProperty"
                        @onUpdateCollection="OnUpdateCollection" />
                </div>
            </div>

            <div class="collection__entries padding" v-else-if="view === 'entries'">
                <CollectionEntries :collection="collection" @UpdateCollection="UpdateCollection" />
            </div>

            <div class="collection__api" v-else-if="view === 'api'" data-aos="fade-up">
                <CollectionApiUsage :collection="collection" />
            </div>

            <!-- DANGER OPTIONS -->
            <div class="editor__base padding border-top" data-aos="fade-up" v-if="role !== 'Moderator'">
                <header class="dangerous-header" @click="isShowingDangerOptions = !isShowingDangerOptions"> 
                    <em class="fa-solid fa-chevron-down" v-if="isShowingDangerOptions"></em>
                    <em class="fa-solid fa-chevron-right" v-else></em>

                    Show danger options
                </header>

                <div class="content" v-if="isShowingDangerOptions">
                    <button 
                        class="button danger"
                        @click="DeleteCollection">
                        Delete collection <em class="fa-solid fa-trash"></em>
                    </button>
                </div>

                <div class="bottom-text" v-if="collection.contents.length > 0">   
                    <span class="warning">
                        <em class="fas fa-exclamation-triangle"></em> Warning: Modifing schema of not-empty collection can be dangerous and may broke your data
                    </span>
                </div>
            </div>
        </div>

        <div class="collection-editor__not-exists padding" v-else>
            <h1 class="collection-editor__header">Let's get started</h1>
            <h3 class="collection-editor__subheader">Choose or create collection to work with in left sidebar</h3>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .collection-editor__root {
        .collection-editor__header {
            font-size: 32px;
        }

        .collection-editor__subheader {
            font-size: 24px;
            margin-top: 12px;
            color: #888;
        }

        .dangerous-header {
            cursor: pointer;
            margin-bottom: 24px;

            em {
                margin-right: 16px;
            }
        }

        .bottom-text {
            margin-top: 16px;

            em {
                color: $danger;
            }
        }
    }
</style>