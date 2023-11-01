<script setup>
    import { onMounted, ref } from 'vue'
    import { GetFullUrl } from '../../utils/Pages'
    import { Post, Get } from '../../utils/Fetch'
    import { RemoveNumeric } from '../../utils/Object'
    import { Reload } from '../../utils/Reload'
    import { Notify, NotifyRed } from '../../utils/Notifications'
    import UserShortcut from '../User/Shortcut.vue'
    import Property from './Property.vue'
    import TextEditor from 'primevue/editor';

    const { pageId, pageReloader } = defineProps({
        pageId: String | Number,
        pageReloader: Object
    })

    const $emit = defineEmits([ "OnDelete" ])
    const error = ref('')
    const success = ref('')

    // Getting the page
    const page = ref(null)
    const GetPage = (id = window.location.hash.split('/')[1]) => {
        Get(`/api/pages/id/${id}`)
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    page.value = res.response.content
                    GetProperties()
                }
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

                    success.value = 'Successfully saved page'

                    setTimeout(() => {
                        success.value = ''
                    }, 500)
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
    
    /////////////////////////
    // Getting properties
    /////////////////////////
    const properties = ref([])
    const GetProperties = () => {
        Get('/api/pages/properties/' + page.value.id)
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    properties.value = res.response.content
                }
            })
    }

    const isOpenCreateProperty = ref(false)
    const propertyName = ref('')

    const OpenCreateProperty = () => isOpenCreateProperty.value = !isOpenCreateProperty.value
    const CreateProperty = () => {
        Post('/api/pages/create-property', {
            id: page.value.id,
            name: propertyName.value
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    GetProperties()
                    OpenCreateProperty()
                }
                else {
                    Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
                }
            })
    }
</script>

<template>
    <div class="page-editor" v-if="page" :reloader="pageReloader">
        {{ ObtainFullUrl(page) }}

        <div class="page-editor__left">
            <div class="page-editor__topbar padding border-bottom">
                <h1 class="medium-header text-overflow">{{ page.name }}</h1>
            </div>

            <div class="page-scroll">
                <div class="page-editor__content padding border-bottom form">
                    <h3 class="medium-header">General</h3>

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
                        <div class="editor-container">
                            <TextEditor v-model="page.content" />
                        </div>
                        <!-- <textarea id="page-content" type="text" class="form-textarea" v-model="page.content"></textarea> -->
                    </div>
                </div>

                <div class="page-editor__rendering-and-url padding border-bottom form">
                    <h3 class="medium-header">Rendering & Url</h3>

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

                <div class="page-editor__props padding form">
                    <h3 class="medium-header">Properties</h3>

                    <label for="" class="quick-header">Page properties</label>

                    <div class="properties-container">
                        <div class="properties-container__top">
                            <button class="button-small" @click="OpenCreateProperty" v-if="!isOpenCreateProperty">
                                <em class="fas fa-plus"></em>
                            </button>

                            <div class="properties-container__top-open" v-else>
                                <input type="text" class="form-input" placeholder="Name of Property" v-model="propertyName">

                                <button class="button-tile success" @click="CreateProperty">
                                    <em class="fas fa-plus"></em>
                                </button>
                                <button class="button-tile danger" @click="isOpenCreateProperty = false">
                                    <em class="fas fa-times"></em>
                                </button>
                            </div>
                        </div>

                        <div class="properties-list">
                            <Property 
                                v-for="property in properties"
                                :key="property"
                                :property="property"
                                @OnUpdate="GetProperties"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-editor__bottom padding border-top">
                <button class="button success" @click="SavePage">Save</button>
                <button class="button danger" @click="DeletePage">Delete</button>
                
                <span class="page-error">{{ error }}</span>
                <div class="page-success">{{ success }}</div>
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

            .page-scroll {
                height: calc(100vh - 131px - 83px);
                overflow-x: hidden;
                overflow-y: auto;

                .medium-header {
                    margin-bottom: 16px;
                    font-size: 24px;
                }
            }
    
            .page-editor__bottom {
                .button {
                    margin-right: 8px;
                }
            }
        }

        .data-row {
            display: flex;
            justify-content: space-between;
            align-items: center;

            .data-container {
                width: 48%;
            }
        }

        .data-container {
            margin-bottom: 32px;
        }

        .properties-list {
            margin-top: 32px;
        }

        .properties-container__top {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        
            .properties-container__top-open {
                display: flex;
                align-items: center;
                justify-content: flex-end;

                input {
                    margin-top: -8px;
                    width: 300px;
                }
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

<style lang="scss">
    .editor-container {
        margin-top: 16px;
    }

    .p-editor-toolbar {
        * {
            color: #eee !important;
            // fill: #eee !important;
            stroke: #eee !important;
        }
    }
</style>