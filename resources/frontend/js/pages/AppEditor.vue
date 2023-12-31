<script setup>
    import Loader from '../components/Loader.vue'
    import FolderItem from '../components/Editor/FolderItem.vue'
    import FolderEditor from '../components/Editor/FolderEditor.vue'
    import { Get, Post } from '../utils/Fetch'
    import { ref } from 'vue'

    //////////////////////////////////////
    // Contents
    //////////////////////////////////////
    const layouts = ref([])
    const isLoadingLayouts = ref(true)
    
    const components = ref([])
    const isLoadingComponents = ref(true)

    const styles = ref([])
    const isLoadingStyles = ref(true)

    const controllers = ref([])
    const isLoadingControllers = ref(true)

    const FetchFolder = (folder, before, callback) => {
        before()

        Get('/api/app-files/folder/' + folder)
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) callback(res.response.content)
            })
    }

    //////////////////////////////////////
    // Load layouts and components
    //////////////////////////////////////
    const LoadAll = () => {
        FetchFolder('layouts', () => {
            isLoadingLayouts.value = true
        }, (_layouts) => {
            layouts.value = _layouts
            isLoadingLayouts.value = false
        });

        FetchFolder('components', () => {
            isLoadingComponents.value = true
        }, (_components) => {
            components.value = _components
            isLoadingComponents.value = false
        });

        FetchFolder('styles', () => {
            isLoadingStyles.value = true
        }, (_styles) => {
            styles.value = _styles
            isLoadingStyles.value = false
        });

        FetchFolder('controllers', () => {
            isLoadingControllers.value = true
        }, (_controllers) => {
            controllers.value = _controllers
            isLoadingControllers.value = false
        });
    }

    LoadAll()

    //////////////////////////////////////
    // Editor
    //////////////////////////////////////
    const folder = ref(null)
    const type = ref(null)

    const Select = (newFolder, newType) => {
        folder.value = newFolder
        type.value = newType
    }

    //////////////////////////////////////
    // Adding folder
    //////////////////////////////////////
    const Add = (where) => {
        Post('/api/app-files/add', {
            where,
            name: prompt("Pass name:")
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) LoadAll()
            })
    }

    ////////////////////////////////////
    // Opened folders
    ////////////////////////////////////
    const isOpenLayouts = ref(false)
    const isOpenComponents = ref(false)
    const isOpenStyles = ref(false) 
    const isOpenControllers = ref(false)
</script>

<template>
    <div class="app-editor">
        <div class="app-sidebar">
            <div class="top-flex top-folder padding">
                <h3 class="quick-header top-flex">
                    <span>Layouts</span>
                    
                    <div class="buttons">
                        <button class="button-small" @click="Add('layouts')"><em class="fa-solid fa-plus"></em></button> 

                        <button class="button-small" @click="isOpenLayouts = !isOpenLayouts">
                            <em :class="`fa-solid ${isOpenLayouts ? 'fa-chevron-down' : 'fa-chevron-right'}`"></em>
                        </button> 
                    </div>
                </h3>
            </div>

            <div class="pages-list" v-if="isOpenLayouts">
                <Loader v-if="isLoadingLayouts" />

                <div class="layouts-list" v-else>
                    <FolderItem 
                        v-for="layout in layouts"
                        :key="layout"
                        :item="layout"
                        :active="type == 'layout' && folder == layout.name"
                        @selectItem="(folder) => Select(folder, 'layout')"
                    />
                </div>
            </div>

            <!-- Components -->

            <div class="top-flex top-folder padding">
                <h3 class="quick-header top-flex">
                    <span>Components</span> 
                    
                    <div class="buttons">
                        <button class="button-small" @click="Add('components')"><em class="fa-solid fa-plus"></em></button> 

                        <button class="button-small" @click="isOpenComponents = !isOpenComponents">
                            <em :class="`fa-solid ${isOpenComponents ? 'fa-chevron-down' : 'fa-chevron-right'}`"></em>
                        </button> 
                    </div>
                </h3>
            </div>

            <div class="pages-list" v-if="isOpenComponents">
                <Loader v-if="isLoadingComponents" />

                <div class="components-list" v-else>
                    <FolderItem 
                        v-for="component in components"
                        :key="component"
                        :item="component"
                        :active="type == 'component' && folder == component.name"
                        @selectItem="(folder) => Select(folder, 'component')"
                    />
                </div>
            </div>

            <!-- Styles -->

            <div class="top-flex top-folder padding">
                <h3 class="quick-header top-flex">
                    <span>Styles</span> 

                    <div class="buttons">
                        <button class="button-small" @click="Add('styles')"><em class="fa-solid fa-plus"></em></button> 

                        <button class="button-small" @click="isOpenStyles = !isOpenStyles">
                            <em :class="`fa-solid ${isOpenStyles ? 'fa-chevron-down' : 'fa-chevron-right'}`"></em>
                        </button> 
                    </div>
                </h3>
            </div>

            <div class="pages-list" v-if="isOpenStyles">
                <Loader v-if="isLoadingStyles" />

                <div class="components-list" v-else>
                    <FolderItem 
                        v-for="style in styles"
                        :key="style"
                        :item="style"
                        :active="type == 'style' && folder == style.name"
                        @selectItem="(folder) => Select(folder, 'style')"
                    />
                </div>
            </div>

            <!-- Controllers -->

            <div class="top-flex top-folder padding">
                <h3 class="quick-header top-flex">
                    <span>Controllers</span> 

                    <div class="buttons">
                        <button class="button-small" @click="Add('controllers')"><em class="fa-solid fa-plus"></em></button> 

                        <button class="button-small" @click="isOpenControllers = !isOpenControllers">
                            <em :class="`fa-solid ${isOpenControllers ? 'fa-chevron-down' : 'fa-chevron-right'}`"></em>
                        </button> 
                    </div>
                </h3>
            </div>

            <div class="pages-list" v-if="isOpenControllers">
                <Loader v-if="isLoadingStyles" />

                <div class="components-list" v-else>
                    <FolderItem 
                        v-for="controller in controllers"
                        :key="controller"
                        :item="controller"
                        :active="type == 'controller' && folder == controller.name"
                        @selectItem="(folder) => Select(folder, 'controller')"
                    />
                </div>
            </div>
        </div>

        <div class="app-editor__inner">
            <FolderEditor
                :folder="folder"
                :type="type"
            />
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .app-editor {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;

        .app-sidebar {
            max-width: 320px;
            width: 100%;
            height: calc(100vh - 50px);
            background: rgba(24, 24, 27, 0.2);
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2666666667);

            .top-folder {
                padding: 12px 24px;
                background: #0000;
                transition: .225s;

                &:hover {
                    background: #0002;
                }

                .quick-header {
                    width: 100%;

                    button {
                        margin-left: 16px;
                    }
                }
            }
        }

        .app-editor__inner {
            width: 100%;
        }
    }
</style>