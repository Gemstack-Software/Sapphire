<script setup>
    import { onMounted, ref } from 'vue'
    import { Get } from '../../utils/Fetch'
    import { CompareArrays } from '../../utils/Array'
    import FileLabel from './FileLabel.vue'
    import FileEditor from './FileEditor.vue'

    const { type, folder } = defineProps({
        type: String,
        folder: String
    });

    /////////////////////////////////////////////
    // Getting content of the folder
    /////////////////////////////////////////////
    const content = ref(null)
    const GetFolderContent = (_type, _folder) => {
        if(!_folder) return;
        if(!_type) return;

        Get(`/api/app-files/inner-folder/${_type}s/${_folder}`)
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    if(content.value && CompareArrays(Array.from(content.value), res.response.content)) {
                        return;
                    }

                    content.value = res.response.content
                }
            })

        return ""
    }
    
    ///////////////////////////////////////////
    // File to edit
    ///////////////////////////////////////////
    const edit = ref(null)

    ///////////////////////////////////////////
    // File which is saving rn
    ///////////////////////////////////////////
    const saving = ref(null)

    const SaveStart = (_type, _folder) => {
        window.currentFile = edit.value
        window.currentFolder = _folder
        window.currentType = _type

        saving.value = edit.value
    }

    const SaveEnd = () => {
        saving.value = null
    }
</script>

<template>
    <div class="folder-editor">
        {{ GetFolderContent(type, folder) }}
        
        <div class="content__loaded">
            <div class="folder-topbar">
                <div class="files-list">
                    <FileLabel 
                        v-for="file in content"
                        :key="file"
                        :file="file"
                        :active="edit == file"
                        :saving="saving == file"
                        @selectFile="(file) => edit = file"
                    />
                </div>
            </div>

            <FileEditor 
                :file="edit"
                :folder="folder"
                :type="type"
                v-if="edit"
                @SaveStart="() => SaveStart(type, folder)"
                @SaveEnd="SaveEnd"
            />

            <div class="file-not-selected padding" v-else>
                <h1 class="medium-header">Welcome to Sapphire app editor</h1>

                <div class="folder-selected" v-if="content && content.length > 0">
                    <h1 class="medium-header">Select file to edit</h1>
                </div>

                <div class="folder-not-selected" v-else>

                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .folder-editor {
        width: 100%;

        .folder-topbar {
            width: 100%;
            background: rgba(24, 24, 27, 0.2);
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2666666667);

            .files-list {
                display: flex;
                justify-content: flex-start;
                align-items: center;

            }
        }
    }
</style>