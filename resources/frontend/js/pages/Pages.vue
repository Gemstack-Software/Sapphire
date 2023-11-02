<script setup>
    import { ref } from 'vue'
    import { Get, Post } from '../utils/Fetch'
    import { Notify, NotifyRed } from '../utils/Notifications'
    import { GetPagesByParentId } from '../utils/Pages'
    import Loader from '../components/Loader.vue'
    import NavPage from '../components/Pages/NavPage.vue'
    import Editor from '../components/Pages/Editor.vue'

    // To store Pages navigation menu state
    window.pagesNavMenu = {}

    /**
     * Obtains all pages avaliable in webapp.
     */
    const pages = ref([])
    const pagesLoading = ref(false)

    const GetPages = () => {
        pagesLoading.value = true
        
        Get('/api/pages/all')
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    pages.value = res.response.content
                    pagesLoading.value = false
                }
            })
    }

    GetPages()

    /**
     * Creating new pages
     */
    const NewPage = (parentId = -1) => {
        pagesLoading.value = true

        Post('/api/pages/create', {
            parentId
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    GetPages()
                }
                else {
                    pagesLoading.value = false
                    Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
                }
            })
    }

    /**
     * Editing pages
     * 
     * This bugs very often (without reloading)
     */
    const editingPageId = ref(window.location.hash.split('/')[1])
    const EditPage = (id) => {
        editingPageId.value = id

        window.location.hash = `/${id}`
        window.location.reload()
    }

    /**
     * On delete page
     */
    const OnDeletePage = (pageId) => {
        GetPages()
        EditPage(0)
    }
</script>

<template>
    <div class="pages">
        <div class="pages-left">
            <div class="pages-left-topbar padding border-bottom">
                <h1 class="medium-header">Pages</h1>
            </div>

            <div class="pages-sidebar">
                <div class="top-flex padding">
                    <h3 class="quick-header">Pages ({{ pages.length }})</h3>

                    <button class="button-small" @click="NewPage()">
                        <em class="fas fa-plus"></em>
                    </button>
                </div>

                <div class="pages-list" v-if="pagesLoading">
                    <Loader />
                </div>

                <div class="pages-list" v-else>
                    <NavPage 
                        v-for="page in GetPagesByParentId(pages)"
                        :key="page"
                        :page="page"
                        :index="1"
                        :pages="pages"
                        @AddSubpage="(parentId) => NewPage(parentId)"
                        @EditPage="(id) => EditPage(id)"
                    />
                </div>
            </div>
        </div>

        <div class="pages-right">
            <div class="pages-loader padding" v-if="pagesLoading">
                <Loader />
            </div>

            <div class="pages-loaded" v-else>
                <div class="pages-editing" v-if="editingPageId">
                    <Editor
                        :pageReloader="pages.find((page) => page.id == editingPageId)"
                        :pageId="editingPageId"
                        @OnDelete="OnDeletePage"
                    />
                </div>

                <div class="pages-menu padding" v-else>
                    <h1 class="medium-header">Select page from sidebar to edit</h1>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .pages {
        display: flex;
        align-items: flex-start;
        justify-content: flex-start;

        height: calc(100vh - 50px);

        .pages-left {
            max-width: 320px;
            width: 100%;
            height: calc(100vh - 50px);

            background: rgba($background-color-lighten, 0.2);
            box-shadow: 0 0 8px #0004;

            .pages-list {
                height: calc(100vh - 144px);
                overflow-x: hidden;
                overflow-y: auto;
            }
        }

        .pages-right {
            width: 100%;
            
            .pages-loader {
                display: flex;
                justify-content: center;
                align-items: center;
            }
        }
    }
</style>