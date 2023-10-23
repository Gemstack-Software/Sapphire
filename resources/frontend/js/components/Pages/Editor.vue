<script setup>
    import UserShortcut from '../User/Shortcut.vue'
    import { onMounted, ref } from 'vue'
    import { GetFullUrl } from '../../utils/Pages'
    import { Post, Get } from '../../utils/Fetch'
    import { RemoveNumeric } from '../../utils/Object'
    import { Reload } from '../../utils/Reload'

    const { pageId, pageReloader } = defineProps({
        pageId: String | Number,
        pageReloader: Object
    })

    const $emit = defineEmits([ "OnDelete" ])
    const error = ref('')

    // Getting the page
    const page = ref(null)
    const GetPage = (id = window.location.hash.split('/')[1]) => {
        Get(`/api/pages/id/${id}`)
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) 
                    page.value = res.response.content
            })

        return ""
    }

    GetPage() // pageId

    // Getting the full url
    const fullUrl = ref('')
    const ObtainFullUrl = (_page) => {
        GetFullUrl(_page)
            .then(fullUrlResponse => {
                fullUrl.value = fullUrlResponse
            })

        return ""
    }

    // Saving the page
    const SavePage = () => {
        Post('/api/pages/save', {
            page: RemoveNumeric(page.value)
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    GetFullUrl(page)
                        .then(fullUrlResponse => {
                            fullUrl.value = fullUrlResponse
                        })
                }
                else {
                    error.value = res.response.message ? res.response.message : "Error whilst saving!"
                }
            })
    }

    // Deleting the page
    const DeletePage = () => {
        Post('/api/pages/delete', {
            id: page.value.id
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) 
                    $emit("OnDelete", page.id)
            })
    }

    // Getting layouts
    const layouts = ref([])

    const GetLayouts = () => {
        Get('/api/layouts/all')
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) 
                    layouts.value = res.response.content
            })
    }

    GetLayouts()
</script>

<template>
    <div class="page-editor" v-if="page" :reloader="pageReloader">
        {{ ObtainFullUrl(page) }}

        <div class="page-editor__left">
            <div class="page-editor__topbar padding border-bottom">
                <h1 class="medium-header text-overflow">{{ page.name }}</h1>
            </div>

            <div class="page-editor__content padding border-bottom form">
                <div class="data-container">
                    <label for="page-name" class="quick-header">Name</label>
                    <input id="page-name" type="text" class="form-input" v-model="page.name">
                </div>

                <div class="data-container">
                    <label for="page-subname" class="quick-header">Subname</label>
                    <input id="page-subname" type="text" class="form-input" v-model="page.subname">
                </div>

                <div class="data-container">
                    <label for="page-content" class="quick-header">Content</label>
                    <textarea id="page-content" type="text" class="form-textarea" v-model="page.content"></textarea>
                </div>

                <div class="data-row">
                    <div class="data-container">
                        <label for="page-url" class="quick-header">Url part</label>
                        <input id="page-url" type="text" class="form-input" v-model="page.url">
                    </div>

                    <div class="data-container">
                        <label for="page-layout" class="quick-header">Layout</label>
                        <select id="page-layout" type="text" class="form-input" v-model="page.layout">
                            <option 
                                v-for="layout in layouts"
                                :key="layout"
                                :value="layout">{{ layout }}</option>
                        </select>
                    </div>
                </div>

                <div class="data-container">
                    <label for="page-home" class="quick-header">Home page</label>
                    <input id="page-home" type="checkbox" class="form-checkbox" :checked="page.is_home == 1 || page.is_home == true || page.is_home == 'true'" @input="page.is_home = !page.is_home">
                </div>
            </div>

            <div class="page-editor__bottom padding">
                <button class="button success" @click="SavePage">Save</button>
                <button class="button danger" @click="DeletePage">Delete</button>
                
                <span class="page-error">{{ error }}</span>
            </div>
        </div>

        <div class="page-editor__right">
            <div class="page-editor__right__topbar padding border-bottom">
                <h1 class="medium-header transparent" style="color: transparent;">.</h1>
            </div>

            <div class="page-editor__info-content padding">
                <div class="data-group">
                    <h3 class="quick-header">Id:</h3>
                    <span class="value">#{{ page.id }} </span>
                </div>

                <div class="data-group">
                    <h3 class="quick-header">Created at:</h3>
                    <span class="value">{{ page.created_at }} </span>
                </div>

                <div class="data-group">
                    <h3 class="quick-header">Created by:</h3>
                    
                    <div class="user-shortcut">
                        <UserShortcut :user="page.created_by" />
                    </div>
                </div>

                <div class="data-group">
                    <h3 class="quick-header">Last updated at:</h3>
                    <span class="value">{{ page.updated_at }} </span>
                </div>

                <div class="data-group">
                    <h3 class="quick-header">Last updated by:</h3>
                    
                    <div class="user-shortcut">
                        <UserShortcut :user="page.updated_by" />
                    </div>
                </div>

                <div class="data-group">
                    <h3 class="quick-header">Full url</h3>
                    <a class="value link" :href="`/${fullUrl}`" target="_blank">/{{ fullUrl }} </a>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .page-editor {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;

        .page-editor__left {
            width: 100%;

            .page-editor__content {
                overflow-y: auto;

                .data-container {
                    margin-bottom: 32px;
                }

                .data-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;

                    .data-container {
                        width: 48%;
                    }
                }
            }
        }

        .page-editor__bottom {
            .button {
                margin-right: 8px;
            }
        }

        .page-editor__right {
            min-width: 320px;
            max-width: 320px;
            height: calc(100vh - 50px);
            background: rgba($background-color-lighten, 0.2);
            box-shadow: 0 0 8px #0004;

            .data-group {
                .value {
                    margin-top: 4px;
                    margin-bottom: 24px;
                    display: block;
                    font-size: 14px;
                }

                .value.link {
                    display: block;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }

                .user-shortcut {
                    margin-top: 4px;
                    margin-bottom: 24px;
                }
            }
        }
    }
</style>